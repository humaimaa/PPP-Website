<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use Illuminate\Http\Request;

class MediaroomController extends Controller
{
    /**
     * Events page
     */
    public function eventsIndex()
    {
        $events = Event::with('gallery')->withCount('gallery')->orderBy('event_date', 'desc')->paginate(12);
        
        // Debug: Check if images exist
        foreach($events as $event) {
            foreach($event->gallery as $gallery) {
                $fullPath = storage_path('app/public/' . $gallery->image);
                if (!file_exists($fullPath)) {
                    \Log::warning('Image not found: ' . $fullPath);
                }
            }
        }
        
        return view('user.events.index', compact('events'));
    }

    /**
     * Gallery album page
     */
    public function eventGallery($id)
    {
        $event = Event::with('gallery')->findOrFail($id);
        return view('user.events.gallery', compact('event'));
    }

    /**
     * Updates page with pagination and filtering
     */
    public function updatesIndex(Request $request)
    {
        $perPage = 6; // Number of items per page
        
        // Start query
        $query = News::query();
        
        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sort by date: use news_date if available, otherwise created_at
        // For MySQL: COALESCE(news_date, created_at) as sort_date
        $query->orderByRaw('COALESCE(news_date, created_at) DESC');
        
        $updates = $query->paginate($perPage);
        
        // Get unique types for filter dropdown
        $types = News::select('type')->distinct()->whereNotNull('type')->pluck('type');
        
        return view('user.updates.index', compact('updates', 'types'));
    }

    /**
     * Individual updates detail page
     */
  public function updatesShow(News $news)
{
    // Get previous and next news for navigation
    $previousNews = News::where(function($query) use ($news) {
            $query->whereRaw('COALESCE(news_date, created_at) < ?', [$news->news_date ?? $news->created_at]);
        })
        ->orderByRaw('COALESCE(news_date, created_at) DESC')
        ->first();

    $nextNews = News::where(function($query) use ($news) {
            $query->whereRaw('COALESCE(news_date, created_at) > ?', [$news->news_date ?? $news->created_at]);
        })
        ->orderByRaw('COALESCE(news_date, created_at) ASC')
        ->first();

    return view('user.updates.show', compact('news', 'previousNews', 'nextNews'));
}
}