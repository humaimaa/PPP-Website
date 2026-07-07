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
                  ->orWhere('division', 'like', "%{$search}%")
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
        
        // Optional: Add division filter
        if ($request->has('division') && !empty($request->division)) {
            $query->where('division', 'like', '%' . $request->division . '%');
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
 * Toggle publish status
 */
public function togglePublish($id)
{
    try {
        $project = Project::findOrFail($id);
        $project->publish = $project->publish === 'yes' ? 'no' : 'yes';
        $project->save();
        
        return redirect()->back()->with('success', 'Publish status updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error updating publish status: ' . $e->getMessage());
    }
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sectors = Sector::orderBy('name')->get();
        $divisions = ['Bannu', 'Dera Ismail Khan', 'Hazara', 'Kohat', 'Malakand', 'Mardan', 'Peshawar', 'FATA'];
        return view('admin.projects.create', compact('sectors', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Basic validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'sector' => 'required|exists:sectors,name',
                'implementing_authority' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'cost' => 'required|string|max:50',
                'overview' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
                'division' => 'required|array|min:1',
                'division.*' => 'in:Bannu,Dera Ismail Khan,Hazara,Kohat,Malakand,Mardan,Peshawar,FATA',
                'category' => 'required|in:Pipeline,Ongoing,Construction & Operational',
            ];

            // Conditional validation for status and category-specific fields (now nullable)
            if ($request->category === 'Ongoing') {
                $rules['status'] = 'required|in:Private Partner Selection,Transaction Advisory';
                $rules['implementing_modality'] = 'nullable|string';
                $rules['government_contribution'] = 'nullable|string';
                $rules['government_return'] = 'nullable|string';
                $rules['private_party_return'] = 'nullable|string';
            } elseif ($request->category === 'Construction & Operational') {
                $rules['status'] = 'required|in:Operational,Construction';
                $rules['scope'] = 'nullable|string';
                $rules['cost_financing_mix'] = 'nullable|string';
                $rules['project_timeline'] = 'nullable|string';
                $rules['expected_financial_benefits_to_government'] = 'nullable|string';
            } else { // Pipeline
                $rules['status'] = 'nullable';
            }

            // Validate the request
            $validated = $request->validate($rules);

            DB::beginTransaction();

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image->getClientOriginalName());
                $imagePath = $image->storeAs('projects', $imageName, 'public');
                $validated['image'] = $imagePath;
            }

            // Convert division array to comma-separated string for SET column
            if ($request->has('division') && is_array($request->division)) {
                $divisions = array_filter(array_map('trim', $request->division));
                $validated['division'] = implode(',', $divisions);
            } else {
                $validated['division'] = null;
            }

            // Create the project
            $project = Project::create($validated);

            // Handle category-specific details (always create, but fields may be null)
            if ($request->category === 'Ongoing') {
                OngoingProjectDetail::create([
                    'project_id' => $project->id,
                    'implementing_modality' => $request->implementing_modality,
                    'government_contribution' => $request->government_contribution,
                    'government_return' => $request->government_return,
                    'private_party_return' => $request->private_party_return,
                ]);
            } elseif ($request->category === 'Construction & Operational') {
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
            throw $e;
        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded image if exists
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
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
        $divisions = ['Bannu', 'Dera Ismail Khan', 'Hazara', 'Kohat', 'Malakand', 'Mardan', 'Peshawar', 'FATA'];
        return view('admin.projects.edit', compact('project', 'sectors', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'sector' => 'required|exists:sectors,name',
            'implementing_authority' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'cost' => 'required|string|max:50',
            'overview' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'division' => 'required|array|min:1',
            'division.*' => 'in:Bannu,Dera Ismail Khan,Hazara,Kohat,Malakand,Mardan,Peshawar,FATA',
            'category' => 'required|in:Pipeline,Ongoing,Construction & Operational',
        ];

        // Conditional validation for status and category-specific fields (now nullable)
        if ($request->category === 'Ongoing') {
            $rules['status'] = 'required|in:Private Partner Selection,Transaction Advisory';
            $rules['implementing_modality'] = 'nullable|string';
            $rules['government_contribution'] = 'nullable|string';
            $rules['government_return'] = 'nullable|string';
            $rules['private_party_return'] = 'nullable|string';
        } elseif ($request->category === 'Construction & Operational') {
            $rules['status'] = 'required|in:Operational,Construction';
            $rules['scope'] = 'nullable|string';
            $rules['cost_financing_mix'] = 'nullable|string';
            $rules['project_timeline'] = 'nullable|string';
            $rules['expected_financial_benefits_to_government'] = 'nullable|string';
        } else { // Pipeline
            $rules['status'] = 'nullable';
        }

        // Validate the request
        $validated = $request->validate($rules);
        
        DB::beginTransaction();
        
        try {
            // Handle image upload
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

            // Convert division array to comma-separated string for SET column
            if ($request->has('division') && is_array($request->division)) {
                $divisions = array_filter(array_map('trim', $request->division));
                $validated['division'] = implode(',', $divisions);
            } else {
                $validated['division'] = null;
            }

            // Update the project
            $project->update($validated);
            
            // Handle category-specific details (update or create, fields may be null)
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
                
            } elseif ($request->category === 'Construction & Operational') {
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
                
            } else { // Pipeline
                // Delete both details if they exist
                OngoingProjectDetail::where('project_id', $project->id)->delete();
                CompletedProjectDetail::where('project_id', $project->id)->delete();
            }
            
            DB::commit();
            
            return redirect()->route('admin.projects.index')
                ->with('success', 'Project updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete newly uploaded image if error occurs
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            \Log::error('Project update failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
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
            
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }
            
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
                    if ($project->image && Storage::disk('public')->exists($project->image)) {
                        Storage::disk('public')->delete($project->image);
                    }
                    
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