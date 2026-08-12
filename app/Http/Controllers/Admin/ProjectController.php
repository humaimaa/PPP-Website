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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with(['sector', 'ongoingDetail', 'completedDetail']);
        
        // Optional: Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('sector', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
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
        
        // Optional: Add sector filter (using sector_id now)
        if ($request->has('sector') && !empty($request->sector)) {
            $query->where('sector_id', $request->sector);
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
                'sector_id' => 'required|exists:sectors,id',
                'implementing_authority' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'cost' => 'required|string|max:50',
                'overview' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
                'division' => 'required|array|min:1',
                'division.*' => 'in:Bannu,Dera Ismail Khan,Hazara,Kohat,Malakand,Mardan,Peshawar,FATA',
                'category' => 'required|in:Pipeline,Ongoing,Construction & Operational',
            ];

            // Conditional validation for status and category-specific fields
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

            // Handle image upload (REQUIRED)
            if (!$request->hasFile('image')) {
                throw new \Exception('Image is required for creating a project.');
            }

            $image = $request->file('image');
            
            // Validate image
            if (!$image->isValid()) {
                throw new \Exception('Invalid image upload: ' . $image->getErrorMessage());
            }
            
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image->getClientOriginalName());
            $imagePath = $image->storeAs('projects', $imageName, 'public');
            
            // Verify image was saved
            if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
                throw new \Exception('Failed to save image. Please check storage permissions.');
            }
            
            $validated['image'] = $imagePath;

            // Convert division array to comma-separated string for SET column
            if ($request->has('division') && is_array($request->division)) {
                $divisions = array_filter(array_map('trim', $request->division));
                $validated['division'] = implode(',', $divisions);
            } else {
                $validated['division'] = null;
            }

            // Remove slug from validated data if present (let model handle it)
            unset($validated['slug']);

            // Create the project (slug will be auto-generated by model event)
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
        $project = Project::with(['sector', 'ongoingDetail', 'completedDetail'])->findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = Project::with(['sector', 'ongoingDetail', 'completedDetail'])->findOrFail($id);
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
            'sector_id' => 'required|exists:sectors,id',
            'implementing_authority' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'cost' => 'required|string|max:50',
            'overview' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'division' => 'required|array|min:1',
            'division.*' => 'in:Bannu,Dera Ismail Khan,Hazara,Kohat,Malakand,Mardan,Peshawar,FATA',
            'category' => 'required|in:Pipeline,Ongoing,Construction & Operational',
        ];

        // Conditional validation for status and category-specific fields
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
                // Validate new image
                $image = $request->file('image');
                if (!$image->isValid()) {
                    throw new \Exception('Invalid image upload: ' . $image->getErrorMessage());
                }
                
                // Delete old image
                if ($project->image && Storage::disk('public')->exists($project->image)) {
                    Storage::disk('public')->delete($project->image);
                }
                
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image->getClientOriginalName());
                $imagePath = $image->storeAs('projects', $imageName, 'public');
                
                // Verify image was saved
                if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
                    throw new \Exception('Failed to save new image. Please check storage permissions.');
                }
                
                $validated['image'] = $imagePath;
            }
            // If no new image is uploaded, KEEP EXISTING IMAGE
            // Remove image from validated array so it doesn't get set to null
            else {
                unset($validated['image']);
            }

            // Convert division array to comma-separated string for SET column
            if ($request->has('division') && is_array($request->division)) {
                $divisions = array_filter(array_map('trim', $request->division));
                $validated['division'] = implode(',', $divisions);
            } else {
                $validated['division'] = null;
            }

            // Remove slug from validated data if present (let model handle it)
            unset($validated['slug']);

            // Update the project (slug will be auto-regenerated if name changed)
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
            
            // Delete project image
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }
            
            // Delete associated details based on category
            if ($project->category === 'Ongoing') {
                OngoingProjectDetail::where('project_id', $project->id)->delete();
            } elseif ($project->category === 'Construction & Operational') {
                CompletedProjectDetail::where('project_id', $project->id)->delete();
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
        try {
            // Handle both array and comma-separated string
            $projectIds = $request->input('project_ids');
            
            // If it's a string, convert to array
            if (is_string($projectIds)) {
                $projectIds = explode(',', $projectIds);
            }
            
            // Ensure we have an array and filter out empty values
            if (!is_array($projectIds)) {
                $projectIds = [];
            }
            
            $projectIds = array_filter($projectIds, function($id) {
                return !empty($id) && is_numeric($id);
            });
            
            // Validate that we have IDs
            if (empty($projectIds)) {
                return redirect()->route('admin.projects.index')
                    ->with('error', 'No valid project IDs provided for deletion.');
            }
            
            // Check if all IDs exist
            $validIds = Project::whereIn('id', $projectIds)->pluck('id')->toArray();
            
            if (empty($validIds)) {
                return redirect()->route('admin.projects.index')
                    ->with('error', 'No valid projects found to delete.');
            }
            
            $deletedCount = 0;
            
            foreach ($validIds as $projectId) {
                $project = Project::find($projectId);
                if ($project) {
                    // Delete project image if exists
                    if ($project->image && Storage::disk('public')->exists($project->image)) {
                        Storage::disk('public')->delete($project->image);
                    }
                    
                    // Delete associated details based on category
                    if ($project->category === 'Ongoing') {
                        OngoingProjectDetail::where('project_id', $project->id)->delete();
                    } elseif ($project->category === 'Construction & Operational') {
                        CompletedProjectDetail::where('project_id', $project->id)->delete();
                    }
                    
                    $project->delete();
                    $deletedCount++;
                }
            }
            
            return redirect()->route('admin.projects.index')
                ->with('success', "{$deletedCount} project(s) deleted successfully!");
                
        } catch (\Exception $e) {
            \Log::error('Bulk delete failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.projects.index')
                ->with('error', 'Error deleting projects: ' . $e->getMessage());
        }
    }
}