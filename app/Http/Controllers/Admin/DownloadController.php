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
    public function index()
    {
        $downloads = Download::orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
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
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:pitchbook,guidelines,reports,agreements,act,policy',
            'date' => 'required|date',
            'document_path' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('document_path')) {
            $file = $request->file('document_path');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('downloads', $fileName, 'public');
            
            // Create new download record
            Download::create([
                'title' => $validated['title'],
                'type' => $validated['type'],
                'date' => $validated['date'],
                'document_path' => $filePath,
            ]);
        }

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
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:pitchbook,guidelines,reports,agreements,act,policy',
            'date' => 'required|date',
            'document_path' => 'nullable|file|mimes:pdf|max:10240', // 10MB max, nullable for updates
        ]);

        // Update basic fields
        $download->title = $validated['title'];
        $download->type = $validated['type'];
        $download->date = $validated['date'];

        // Handle file upload if new file is provided
        if ($request->hasFile('document_path')) {
            // Delete old file if exists
            if ($download->document_path && Storage::disk('public')->exists($download->document_path)) {
                Storage::disk('public')->delete($download->document_path);
            }
            
            // Upload new file
            $file = $request->file('document_path');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('downloads', $fileName, 'public');
            $download->document_path = $filePath;
        }

        $download->save();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Document updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Download $download)
    {
        // Delete the file from storage
        if ($download->document_path && Storage::disk('public')->exists($download->document_path)) {
            Storage::disk('public')->delete($download->document_path);
        }
        
        // Delete the record from database
        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Document deleted successfully!');
    }

    /**
     * Download the file.
     */
    public function download(Download $download)
    {
        // Check if file exists
        if (!Storage::disk('public')->exists($download->document_path)) {
            return redirect()->route('admin.downloads.index')
                ->with('error', 'File not found!');
        }

        // Return file download
        return Storage::disk('public')->download($download->document_path, $download->title . '.pdf');
    }


    /**
 * Bulk delete documents
 */
public function bulkDelete(Request $request)
{
    $request->validate([
        'download_ids' => 'required|array',
        'download_ids.*' => 'exists:downloads,id'
    ]);
    
    try {
        $downloadIds = $request->download_ids;
        $deletedCount = 0;
        
        foreach ($downloadIds as $downloadId) {
            $download = Download::find($downloadId);
            if ($download) {
                // Delete file from storage
                if ($download->document_path && Storage::disk('public')->exists($download->document_path)) {
                    Storage::disk('public')->delete($download->document_path);
                }
                
                // Delete the record
                $download->delete();
                $deletedCount++;
            }
        }
        
        return redirect()->route('admin.downloads.index')
            ->with('success', "{$deletedCount} document(s) deleted successfully!");
            
    } catch (\Exception $e) {
        return redirect()->route('admin.downloads.index')
            ->with('error', 'Error deleting documents: ' . $e->getMessage());
    }
}
}