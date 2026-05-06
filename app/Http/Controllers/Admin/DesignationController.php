<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Designation::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // Order by title alphabetically
        $designations = $query->orderBy('title')->paginate(15);
        
        return view('admin.designations.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.designations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:designations,title',
        ], [
            'title.required' => 'The designation title is required.',
            'title.unique' => 'This designation already exists. Please enter a unique title.',
            'title.max' => 'The designation title cannot exceed 255 characters.',
        ]);
        
        Designation::create([
            'title' => $request->title,
        ]);
        
        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        return view('admin.designations.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('designations', 'title')->ignore($designation->id),
            ],
        ], [
            'title.required' => 'The designation title is required.',
            'title.unique' => 'This designation already exists. Please enter a unique title.',
            'title.max' => 'The designation title cannot exceed 255 characters.',
        ]);
        
        $designation->update([
            'title' => $request->title,
        ]);
        
        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        // Check if designation is being used in other tables
        $isUsed = false;
        $usageMessage = '';
        
        // Check leadership_messages table
        if ($designation->leadershipMessages()->exists()) {
            $isUsed = true;
            $usageMessage = 'leadership messages';
        }
        
        // Check staff table (if you have a staff table)
        if ($designation->staff()->exists()) {
            $isUsed = true;
            $usageMessage = 'staff members';
        }
        
        if ($isUsed) {
            return redirect()->route('admin.designations.index')
                ->with('error', 'Cannot delete this designation because it is currently being used by ' . $usageMessage . '.');
        }
        
        $designation->delete();
        
        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation deleted successfully!');
    }

    /**
 * Bulk delete designations
 */
public function bulkDelete(Request $request)
{
    $request->validate([
        'designation_ids' => 'required|array',
        'designation_ids.*' => 'exists:designations,id'
    ]);
    
    try {
        $designationIds = $request->designation_ids;
        $deletedCount = 0;
        
        foreach ($designationIds as $designationId) {
            $designation = Designation::find($designationId);
            if ($designation) {
                $designation->delete();
                $deletedCount++;
            }
        }
        
        return redirect()->route('admin.designations.index')
            ->with('success', "{$deletedCount} designation(s) deleted successfully!");
            
    } catch (\Exception $e) {
        return redirect()->route('admin.designations.index')
            ->with('error', 'Error deleting designations: ' . $e->getMessage());
    }
}
}