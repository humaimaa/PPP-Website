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

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $designations = $query->orderBy('order')->orderBy('title')->paginate(15);

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
            'order' => 'required|integer|min:0|unique:designations,order',
        ], [
            'title.required' => 'The designation title is required.',
            'title.unique'   => 'This designation already exists. Please enter a unique title.',
            'title.max'      => 'The designation title cannot exceed 255 characters.',
            'order.required' => 'The display order is required.',
            'order.unique'   => 'This order number is already taken. Please choose a different one.',
            'order.integer'  => 'Order must be a valid number.',
            'order.min'      => 'Order must be at least 0.',
        ]);

        Designation::create([
            'title' => $request->title,
            'order' => $request->order,
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
            'order' => [
                'required',
                'integer',
                'min:0',
                Rule::unique('designations', 'order')->ignore($designation->id),
            ],
        ], [
            'title.required' => 'The designation title is required.',
            'title.unique'   => 'This designation already exists. Please enter a unique title.',
            'title.max'      => 'The designation title cannot exceed 255 characters.',
            'order.required' => 'The display order is required.',
            'order.unique'   => 'This order number is already taken. Please choose a different one.',
            'order.integer'  => 'Order must be a valid number.',
            'order.min'      => 'Order must be at least 0.',
        ]);

        $designation->update([
            'title' => $request->title,
            'order' => $request->order,
        ]);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        try {
            if ($designation->isUsed()) {
                $usageDetails = $designation->getUsageDetails();
                return redirect()->route('admin.designations.index')
                    ->with('error', 'Cannot delete this designation because it is currently being used by ' . $usageDetails . '. Please reassign or delete those team members first.');
            }

            $designationTitle = $designation->title;
            $designation->delete();

            return redirect()->route('admin.designations.index')
                ->with('success', 'Designation "' . $designationTitle . '" deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.designations.index')
                ->with('error', 'Error deleting designation: ' . $e->getMessage());
        }
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

        $designationIds = $request->designation_ids;
        $deletedCount = 0;
        $failedDeletions = [];

        foreach ($designationIds as $designationId) {
            $designation = Designation::find($designationId);
            if ($designation && !$designation->isUsed()) {
                $designation->delete();
                $deletedCount++;
            } else if ($designation && $designation->isUsed()) {
                $failedDeletions[] = $designation->title;
            }
        }

        $message = '';
        if ($deletedCount > 0) {
            $message .= $deletedCount . ' designation(s) deleted successfully! ';
        }

        if (count($failedDeletions) > 0) {
            $message .= 'Cannot delete: ' . implode(', ', $failedDeletions) . ' (currently in use by team members).';
        }

        if ($deletedCount > 0 || count($failedDeletions) > 0) {
            return redirect()->route('admin.designations.index')
                ->with('warning', trim($message));
        }

        return redirect()->route('admin.designations.index')
            ->with('error', 'No designations were deleted. Please select valid designations that are not in use.');
    }

    /**
     * Update order of designations (for drag-and-drop sorting) - with duplicate check
     */
    public function updateOrder(Request $request)
    {
        try {
            $request->validate([
                'orders' => 'required|array',
                'orders.*.id' => 'exists:designations,id',
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
                Designation::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating order: ' . $e->getMessage()], 500);
        }
    }
}