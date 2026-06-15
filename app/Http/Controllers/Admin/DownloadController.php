<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Download::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        $downloads = $query->latest()->paginate(10);
        $downloads->appends($request->query());
        
        return view('admin.downloads.index', compact('downloads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.downloads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Legal Framework,Prequalified Transaction Advisory,Policies, Regulations and Guidelines,Knowledge Hub',
            'date' => 'required|date|before_or_equal:today',
            'document_path' => 'required|file|mimes:pdf|max:10240',
        ]);

        // Handle file upload
        $documentPath = null;
        if ($request->hasFile('document_path')) {
            $document = $request->file('document_path');
            $documentName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $document->getClientOriginalName());
            $documentPath = $document->storeAs('downloads', $documentName, 'public');
        }

        // Create download record
        Download::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'date' => $validated['date'],
            'document_path' => $documentPath,
        ]);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Document uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Download $download)
    {
        return view('admin.downloads.show', compact('download'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Download $download)
    {
        return view('admin.downloads.edit', compact('download'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Legal Framework,Prequalified Transaction Advisory,Policies, Regulations and Guidelines,Knowledge Hub',
            'date' => 'required|date|before_or_equal:today',
            'document_path' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('document_path')) {
            // Delete old file
            if ($download->document_path && Storage::disk('public')->exists($download->document_path)) {
                Storage::disk('public')->delete($download->document_path);
            }
            
            $document = $request->file('document_path');
            $documentName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $document->getClientOriginalName());
            $validated['document_path'] = $document->storeAs('downloads', $documentName, 'public');
        }

        $download->update($validated);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Document updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Download $download)
    {
        // Delete the file
        if ($download->document_path && Storage::disk('public')->exists($download->document_path)) {
            Storage::disk('public')->delete($download->document_path);
        }
        
        $download->delete();
        
        return redirect()->route('admin.downloads.index')
            ->with('success', 'Document deleted successfully!');
    }
    
    /**
     * Bulk delete documents
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'document_ids' => 'required|array',
            'document_ids.*' => 'exists:downloads,id'
        ]);
        
        $documentIds = $request->document_ids;
        $deletedCount = 0;
        
        foreach ($documentIds as $documentId) {
            $download = Download::find($documentId);
            if ($download) {
                // Delete the file
                if ($download->document_path && Storage::disk('public')->exists($download->document_path)) {
                    Storage::disk('public')->delete($download->document_path);
                }
                $download->delete();
                $deletedCount++;
            }
        }
        
        return redirect()->route('admin.downloads.index')
            ->with('success', "{$deletedCount} document(s) deleted successfully!");
    }
}