<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Sector;
use App\Models\OngoingProjectDetail;
use App\Models\CompletedProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with(['ongoingDetail', 'completedDetail']);
        
        // Optional: Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sector', 'like', "%{$search}%")
                  ->orWhere('implementing_authority', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }
        
        // Optional: Add category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Optional: Add sector filter
        if ($request->has('sector') && !empty($request->sector)) {
            $query->where('sector', $request->sector);
        }
        
        // Optional: Add status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Sort by latest first with pagination (10 items per page)
        $projects = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // If you want to keep the query string parameters in pagination links
        $projects->appends($request->query());
        
        // Get sectors for filter dropdown (if needed)
        $sectors = Sector::orderBy('name')->get();
        
        return view('admin.projects.index', compact('projects', 'sectors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sectors = Sector::orderBy('name')->get();
        return view('admin.projects.create', compact('sectors'));
    }

  public function store(Request $request)
{
    // dd($request->all()); // Debugging line to check incoming request data
    try {
        // Validate basic project data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sector' => 'required|exists:sectors,name',
            'implementing_authority' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'cost' => 'required|numeric|min:0',
            'status' => 'nullable|string|max:255',
            'overview' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'required|in:Pipeline,Ongoing,Completed',
        ]);

        \Log::info('Validation passed for project: ' . $request->name);

        // Add conditional validation based on category
        if ($request->category === 'Ongoing') {
            $request->validate([
                'implementing_modality' => 'required|string',
                'government_contribution' => 'required|string',
                'government_return' => 'required|string',
                'private_party_return' => 'required|string',
            ]);
        } elseif ($request->category === 'Completed') {
            $request->validate([
                'scope' => 'required|string',
                'cost_financing_mix' => 'required|string',
                'project_timeline' => 'required|string',
                'expected_financial_benefits_to_government' => 'required|string',
            ]);
        }

        DB::beginTransaction();
        
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image->getClientOriginalName());
            $imagePath = $image->storeAs('projects', $imageName, 'public');
            $validated['image'] = $imagePath;
        }
        
        // Create the main project
        $project = Project::create($validated);
        
        // Handle category-specific details
        if ($request->category === 'Ongoing') {
            OngoingProjectDetail::create([
                'project_id' => $project->id,
                'implementing_modality' => $request->implementing_modality,
                'government_contribution' => $request->government_contribution,
                'government_return' => $request->government_return,
                'private_party_return' => $request->private_party_return,
            ]);
        } elseif ($request->category === 'Completed') {
            CompletedProjectDetail::create([
                'project_id' => $project->id,
                'scope' => $request->scope,
                'cost_financing_mix' => $request->cost_financing_mix,
                'project_timeline' => $request->project_timeline,
                'expected_financial_benefits_to_government' => $request->expected_financial_benefits_to_government,
            ]);
        }
        
        DB::commit();
        
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
            
    } catch (\Illuminate\Validation\ValidationException $e) {
        throw $e; // Let Laravel handle validation exceptions
    } catch (\Exception $e) {
        DB::rollback();
        // Delete uploaded image if something went wrong
        if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        
        // Log the error for debugging
        \Log::error('Project creation failed: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Error creating project: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::with(['ongoingDetail', 'completedDetail'])->findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = Project::with(['ongoingDetail', 'completedDetail'])->findOrFail($id);
        $sectors = Sector::orderBy('name')->get();
        return view('admin.projects.edit', compact('project', 'sectors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sector' => 'required|exists:sectors,name',
            'implementing_authority' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'cost' => 'required|numeric|min:0',
            'status' => 'nullable|string|max:255',
            'overview' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'required|in:Pipeline,Ongoing,Completed',
        ]);
        
        // Add conditional validation based on category
        if ($request->category === 'Ongoing') {
            $request->validate([
                'implementing_modality' => 'required|string',
                'government_contribution' => 'required|string',
                'government_return' => 'required|string',
                'private_party_return' => 'required|string',
            ]);
        } elseif ($request->category === 'Completed') {
            $request->validate([
                'scope' => 'required|string',
                'cost_financing_mix' => 'required|string',
                'project_timeline' => 'required|string',
                'expected_financial_benefits_to_government' => 'required|string',
            ]);
        }
        
        DB::beginTransaction();
        
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                // Delete old image
                if ($project->image && Storage::disk('public')->exists($project->image)) {
                    Storage::disk('public')->delete($project->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image->getClientOriginalName());
                $imagePath = $image->storeAs('projects', $imageName, 'public');
                $validated['image'] = $imagePath;
            }
            
            $project->update($validated);
            
            // Handle category-specific details
            if ($request->category === 'Ongoing') {
                OngoingProjectDetail::updateOrCreate(
                    ['project_id' => $project->id],
                    [
                        'implementing_modality' => $request->implementing_modality,
                        'government_contribution' => $request->government_contribution,
                        'government_return' => $request->government_return,
                        'private_party_return' => $request->private_party_return,
                    ]
                );
                
                // Delete completed details if they exist
                CompletedProjectDetail::where('project_id', $project->id)->delete();
                
            } elseif ($request->category === 'Completed') {
                CompletedProjectDetail::updateOrCreate(
                    ['project_id' => $project->id],
                    [
                        'scope' => $request->scope,
                        'cost_financing_mix' => $request->cost_financing_mix,
                        'project_timeline' => $request->project_timeline,
                        'expected_financial_benefits_to_government' => $request->expected_financial_benefits_to_government,
                    ]
                );
                
                // Delete ongoing details if they exist
                OngoingProjectDetail::where('project_id', $project->id)->delete();
                
            } else {
                // Pipeline category - delete any existing details
                OngoingProjectDetail::where('project_id', $project->id)->delete();
                CompletedProjectDetail::where('project_id', $project->id)->delete();
            }
            
            DB::commit();
            
            return redirect()->route('admin.projects.index')
                ->with('success', 'Project updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            return redirect()->back()
                ->with('error', 'Error updating project: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            
            // Delete project image
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }
            
            // Delete the project (related details will be deleted automatically due to cascade)
            $project->delete();
            
            return redirect()->route('admin.projects.index')
                ->with('success', 'Project deleted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Error deleting project: ' . $e->getMessage());
        }
    }
    
    /**
     * Bulk delete projects
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:projects,id'
        ]);
        
        try {
            $projectIds = $request->project_ids;
            $deletedCount = 0;
            
            foreach ($projectIds as $projectId) {
                $project = Project::find($projectId);
                if ($project) {
                    // Delete project image
                    if ($project->image && Storage::disk('public')->exists($project->image)) {
                        Storage::disk('public')->delete($project->image);
                    }
                    
                    // Delete the project (related details will be deleted automatically due to cascade)
                    $project->delete();
                    $deletedCount++;
                }
            }
            
            return redirect()->route('admin.projects.index')
                ->with('success', "{$deletedCount} project(s) deleted successfully!");
                
        } catch (\Exception $e) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Error deleting projects: ' . $e->getMessage());
        }
    }
}