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
            'designation_ids' => ['required', 'array'],
            'designation_ids.*' => ['exists:designations,id'],
        ]);

        $designationIds = $request->designation_ids;
        
        // Check which designations are in use
        $usedDesignations = [];
        
        foreach ($designationIds as $id) {
            $designation = Designation::find($id);
            
            if ($designation) {
                if ($designation->leadershipMessages()->exists()) {
                    $usedDesignations[] = $designation->title;
                } elseif ($designation->staff()->exists()) {
                    $usedDesignations[] = $designation->title;
                }
            }
        }
        
        // If there are used designations, don't delete any
        if (!empty($usedDesignations)) {
            $list = implode(', ', array_slice($usedDesignations, 0, 5));
            if (count($usedDesignations) > 5) {
                $list .= ' and ' . (count($usedDesignations) - 5) . ' more';
            }
            
            return redirect()->route('admin.designations.index')
                ->with('error', 'Cannot delete the following designation(s) because they are in use: ' . $list . '.');
        }
        
        // Delete all selected designations
        $deletedCount = Designation::whereIn('id', $designationIds)->delete();
        
        return redirect()->route('admin.designations.index')
            ->with('success', "{$deletedCount} designation(s) deleted successfully!");
    }
}