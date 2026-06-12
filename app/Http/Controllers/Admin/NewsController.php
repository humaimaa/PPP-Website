<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        // Filter by type
        if ($request->filled('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Filter by featured
        if ($request->filled('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        $news = $query->latest()->paginate(10);
        $news->appends(request()->query());

        return view('admin.updates.index', compact('news'));
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
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'type'        => 'required|in:Update,Announcement,Press Release,Notice,Other',
            'image'       => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'is_featured' => 'nullable|boolean',
            'news_date'   => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news/images', 'public');
        }

        // Set news_date: use user input if provided, otherwise use current timestamp
        $newsDate = $request->filled('news_date') 
            ? Carbon::parse($request->news_date) 
            : Carbon::now();

        News::create([
            'title'       => $validated['title'],
            'content'     => $validated['content'],
            'type'        => $validated['type'],
            'img_path'    => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'news_date'   => $newsDate,
        ]);

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update created successfully!');
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
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'type'        => 'required|in:Update,Announcement,Press Release,Notice,Other',
            'image'       => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'is_featured' => 'nullable|boolean',
            'news_date'   => 'nullable|date',
        ]);

        $imagePath = $news->img_path;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->img_path && Storage::disk('public')->exists($news->img_path)) {
                Storage::disk('public')->delete($news->img_path);
            }
            $imagePath = $request->file('image')->store('news/images', 'public');
        }

        // Set news_date: use user input if provided, otherwise keep existing or use current
        if ($request->filled('news_date')) {
            $newsDate = Carbon::parse($request->news_date);
        } else {
            $newsDate = $news->news_date ?? Carbon::now();
        }

        $news->update([
            'title'       => $validated['title'],
            'content'     => $validated['content'],
            'type'        => $validated['type'],
            'img_path'    => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'news_date'   => $newsDate,
        ]);

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->img_path && Storage::disk('public')->exists($news->img_path)) {
            Storage::disk('public')->delete($news->img_path);
        }

        $news->delete();

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update deleted successfully!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(News $news)
    {
        $news->update(['is_featured' => !$news->is_featured]);

        $status = $news->is_featured ? 'featured' : 'unfeatured';

        return redirect()
            ->route('admin.updates.index')
            ->with('success', "Update {$status} successfully!");
    }

    /**
     * Feature update
     */
    public function feature(News $news)
    {
        $news->update(['is_featured' => true]);

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update featured successfully!');
    }

    /**
     * Unfeature update
     */
    public function unfeature(News $news)
    {
        $news->update(['is_featured' => false]);

        return redirect()
            ->route('admin.updates.index')
            ->with('success', 'Update removed from featured!');
    }

    /**
     * Bulk delete updates
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'update_ids'   => 'required|array',
            'update_ids.*' => 'exists:news,id',
        ]);

        $updateIds    = $request->update_ids;
        $deletedCount = 0;

        foreach ($updateIds as $updateId) {
            $news = News::find($updateId);
            if ($news) {
                // Delete image if exists
                if ($news->img_path && Storage::disk('public')->exists($news->img_path)) {
                    Storage::disk('public')->delete($news->img_path);
                }
                $news->delete();
                $deletedCount++;
            }
        }

        return redirect()
            ->route('admin.updates.index')
            ->with('success', "{$deletedCount} update(s) deleted successfully!");
    }
}