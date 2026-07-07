<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acronym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AcronymController extends Controller
{
    /**
     * Display a listing of the acronyms with search functionality.
     */
    public function index(Request $request)
    {
        $query = Acronym::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('acronym', 'like', '%' . $search . '%')
                  ->orWhere('standfor', 'like', '%' . $search . '%');
            });
        }
        
        // Sort by latest first with pagination (10 items per page)
        $acronyms = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // If you want to keep the query string parameters in pagination links
        $acronyms->appends($request->query());
        
        return view('admin.acronyms.index', compact('acronyms'));
    }

    /**
     * Show the form for creating a new acronym.
     */
    public function create()
    {
        return view('admin.acronyms.create');
    }

    /**
     * Store a newly created acronym in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'acronym' => 'required|string|max:50|unique:acronyms,acronym',
                'standfor' => 'required|string|max:255',
            ]);

            Acronym::create($validated);

            return redirect()->route('admin.acronyms.index')
                ->with('success', 'Acronym created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Acronym creation failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Error creating acronym: ' . $e->getMessage())
                ->withInput();
        }
    }

   

    /**
     * Show the form for editing the specified acronym.
     */
    public function edit(Acronym $acronym)
    {
        return view('admin.acronyms.edit', compact('acronym'));
    }

    /**
     * Update the specified acronym in storage.
     */
    public function update(Request $request, Acronym $acronym)
    {
        try {
            $validated = $request->validate([
                'acronym' => 'required|string|max:50|unique:acronyms,acronym,' . $acronym->id,
                'standfor' => 'required|string|max:255',
            ]);

            $acronym->update($validated);

            return redirect()->route('admin.acronyms.index')
                ->with('success', 'Acronym updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Acronym update failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Error updating acronym: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified acronym from storage.
     */
    public function destroy(Acronym $acronym)
    {
        try {
            $acronym->delete();
            
            return redirect()->route('admin.acronyms.index')
                ->with('success', 'Acronym deleted successfully!');
                
        } catch (\Exception $e) {
            Log::error('Acronym deletion failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.acronyms.index')
                ->with('error', 'Error deleting acronym: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete acronyms.
     */
    public function bulkDelete(Request $request)
    {
        try {
            // Handle both array and comma-separated string
            $acronymIds = $request->input('acronym_ids');
            
            // If it's a string, convert to array
            if (is_string($acronymIds)) {
                $acronymIds = explode(',', $acronymIds);
            }
            
            // Ensure we have an array and filter out empty values
            if (!is_array($acronymIds)) {
                $acronymIds = [];
            }
            
            $acronymIds = array_filter($acronymIds, function($id) {
                return !empty($id) && is_numeric($id);
            });
            
            // Validate that we have IDs
            if (empty($acronymIds)) {
                return redirect()->route('admin.acronyms.index')
                    ->with('error', 'No valid acronym IDs provided for deletion.');
            }
            
            // Check if all IDs exist
            $validIds = Acronym::whereIn('id', $acronymIds)->pluck('id')->toArray();
            
            if (empty($validIds)) {
                return redirect()->route('admin.acronyms.index')
                    ->with('error', 'No valid acronyms found to delete.');
            }
            
            $deletedCount = Acronym::whereIn('id', $validIds)->delete();

            return redirect()->route('admin.acronyms.index')
                ->with('success', $deletedCount . ' acronym(s) deleted successfully.');
                
        } catch (\Exception $e) {
            Log::error('Bulk delete failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.acronyms.index')
                ->with('error', 'Error deleting acronyms: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint to get acronyms for autocomplete/select2
     */
    public function apiSearch(Request $request)
    {
        try {
            $search = $request->input('q', '');
            $limit = $request->input('limit', 20);
            
            $query = Acronym::query();
            
            if (!empty($search)) {
                $query->where('acronym', 'like', '%' . $search . '%')
                      ->orWhere('standfor', 'like', '%' . $search . '%');
            }
            
            $acronyms = $query->limit($limit)->get();
            
            return response()->json([
                'success' => true,
                'data' => $acronyms->map(function($acronym) {
                    return [
                        'id' => $acronym->id,
                        'acronym' => $acronym->acronym,
                        'standfor' => $acronym->standfor,
                        'text' => $acronym->acronym . ' - ' . $acronym->standfor
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            Log::error('API search failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error searching acronyms'
            ], 500);
        }
    }

    /**
     * Export acronyms to CSV
     */
    public function export()
    {
        try {
            $acronyms = Acronym::orderBy('acronym')->get();
            
            $filename = 'acronyms_' . date('Y-m-d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            $callback = function() use ($acronyms) {
                $file = fopen('php://output', 'w');
                
                // Add headers
                fputcsv($file, ['ID', 'Acronym', 'Stands For', 'Created At', 'Updated At']);
                
                // Add data rows
                foreach ($acronyms as $acronym) {
                    fputcsv($file, [
                        $acronym->id,
                        $acronym->acronym,
                        $acronym->standfor,
                        $acronym->created_at,
                        $acronym->updated_at
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error exporting acronyms: ' . $e->getMessage());
        }
    }
}