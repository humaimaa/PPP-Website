<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hierarchy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HierarchyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hierarchy::query();

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $hierarchies = $query->orderBy('order')->orderBy('title')->paginate(15);

        return view('admin.hierarchy.index', compact('hierarchies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hierarchy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:hierarchy,title',
            'order' => 'required|integer|min:0|unique:hierarchy,order',
        ], [
            'title.required' => 'The hierarchy title is required.',
            'title.unique'   => 'This hierarchy entry already exists. Please enter a unique title.',
            'title.max'      => 'The hierarchy title cannot exceed 255 characters.',
            'order.required' => 'The display order is required.',
            'order.unique'   => 'This order number is already taken. Please choose a different one.',
            'order.integer'  => 'Order must be a valid number.',
            'order.min'      => 'Order must be at least 0.',
        ]);

        Hierarchy::create([
            'title' => $request->title,
            'order' => $request->order,
        ]);

        return redirect()->route('admin.hierarchy.index')
            ->with('success', 'Hierarchy entry created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hierarchy $hierarchy)
    {
        return view('admin.hierarchy.edit', compact('hierarchy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hierarchy $hierarchy)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hierarchy', 'title')->ignore($hierarchy->id),
            ],
            'order' => [
                'required',
                'integer',
                'min:0',
                Rule::unique('hierarchy', 'order')->ignore($hierarchy->id),
            ],
        ], [
            'title.required' => 'The hierarchy title is required.',
            'title.unique'   => 'This hierarchy entry already exists. Please enter a unique title.',
            'title.max'      => 'The hierarchy title cannot exceed 255 characters.',
            'order.required' => 'The display order is required.',
            'order.unique'   => 'This order number is already taken. Please choose a different one.',
            'order.integer'  => 'Order must be a valid number.',
            'order.min'      => 'Order must be at least 0.',
        ]);

        $hierarchy->update([
            'title' => $request->title,
            'order' => $request->order,
        ]);

        return redirect()->route('admin.hierarchy.index')
            ->with('success', 'Hierarchy entry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hierarchy $hierarchy)
    {
        try {
            if ($hierarchy->isUsed()) {
                $usageDetails = $hierarchy->getUsageDetails();
                return redirect()->route('admin.hierarchy.index')
                    ->with('error', 'Cannot delete this hierarchy entry because it is currently being used by ' . $usageDetails . '. Please reassign or delete those team members first.');
            }

            $hierarchyTitle = $hierarchy->title;
            $hierarchy->delete();

            return redirect()->route('admin.hierarchy.index')
                ->with('success', 'Hierarchy entry "' . $hierarchyTitle . '" deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.hierarchy.index')
                ->with('error', 'Error deleting hierarchy entry: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete hierarchy entries
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'hierarchy_ids' => 'required|array',
            'hierarchy_ids.*' => 'exists:hierarchy,id'
        ]);

        $hierarchyIds = $request->hierarchy_ids;
        $deletedCount = 0;
        $failedDeletions = [];

        foreach ($hierarchyIds as $hierarchyId) {
            $hierarchy = Hierarchy::find($hierarchyId);
            if ($hierarchy && !$hierarchy->isUsed()) {
                $hierarchy->delete();
                $deletedCount++;
            } else if ($hierarchy && $hierarchy->isUsed()) {
                $failedDeletions[] = $hierarchy->title;
            }
        }

        $message = '';
        if ($deletedCount > 0) {
            $message .= $deletedCount . ' hierarchy entry(ies) deleted successfully! ';
        }

        if (count($failedDeletions) > 0) {
            $message .= 'Cannot delete: ' . implode(', ', $failedDeletions) . ' (currently in use by team members).';
        }

        if ($deletedCount > 0 || count($failedDeletions) > 0) {
            return redirect()->route('admin.hierarchy.index')
                ->with('warning', trim($message));
        }

        return redirect()->route('admin.hierarchy.index')
            ->with('error', 'No hierarchy entries were deleted. Please select valid entries that are not in use.');
    }

    /**
     * Update order of hierarchy entries (for drag-and-drop sorting)
     */
    public function updateOrder(Request $request)
    {
        try {
            $request->validate([
                'orders' => 'required|array',
                'orders.*.id' => 'exists:hierarchy,id',
                'orders.*.order' => 'required|integer|min:0',
            ]);

            // Check for duplicate order values
            $orders = collect($request->orders);
            $duplicate = $orders->duplicates('order');
            if ($duplicate->isNotEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Duplicate order values are not allowed: ' . $duplicate->implode(', ')
                ], 422);
            }

            foreach ($request->orders as $item) {
                Hierarchy::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating order: ' . $e->getMessage()], 500);
        }
    }
}