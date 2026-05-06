<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::latest();

        // Filter by type
        if ($request->filled('type')) {
            if ($request->type === 'featured') {
                $query->featured();
            } else {
                $query->ofType($request->type);
            }
        }

        $news  = $query->paginate(10)->withQueryString();
        $total = News::count();

        return view('admin.updates.index', compact('news', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.updates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'type'       => 'required|in:Update,Event,Announcement,Press Release,Notice,Circular',
            'event_date' => 'nullable|required_if:type,Event|date',
            'pdf_file'   => 'nullable|file|mimes:pdf|max:10240',
            'is_featured'=> 'nullable|boolean',
        ]);

        $pdfPath = null;
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('news/pdfs', 'public');
        }

        News::create([
            'title'       => $validated['title'],
            'content'     => $validated['content'],
            'type'        => $validated['type'],
            'event_date'  => $validated['event_date'] ?? null,
            'pdf_path'    => $pdfPath,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('admin.updates.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('admin.updates.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'type'       => 'required|in:Update,Event,Announcement,Press Release,Notice,Circular',
            'event_date' => 'nullable|required_if:type,Event|date',
            'pdf_file'   => 'nullable|file|mimes:pdf|max:10240',
            'is_featured'=> 'nullable|boolean',
        ]);

        $pdfPath = $news->pdf_path; // keep existing by default

        if ($request->hasFile('pdf_file')) {
            // Delete old PDF
            if ($news->pdf_path) {
                Storage::disk('public')->delete($news->pdf_path);
            }
            $pdfPath = $request->file('pdf_file')->store('news/pdfs', 'public');
        }

        $news->update([
            'title'       => $validated['title'],
            'content'     => $validated['content'],
            'type'        => $validated['type'],
            'event_date'  => $validated['event_date'] ?? null,
            'pdf_path'    => $pdfPath,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update saved successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->pdf_path) {
            Storage::disk('public')->delete($news->pdf_path);
        }

        $news->delete();

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update deleted successfully!');
    }
}