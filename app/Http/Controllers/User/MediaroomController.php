<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use Illuminate\Http\Request;

class MediaroomController extends Controller
{
    /**
     * Events page - Only shows published events, latest first
     */
    public function eventsIndex()
    {
        $events = Event::with('gallery')
            ->withCount('gallery')
            ->where('publish', 'yes') // Only show published events
            ->orderByRaw('COALESCE(event_date, created_at) DESC') // Latest events first, fallback to created_at
            ->paginate(12);
        
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
     * Gallery album page - Only shows published event
     */
    public function eventGallery(Event $event)
    {
        // Check if event is published
        if ($event->publish !== 'yes') {
            abort(404);
        }
        
        $event->load('gallery');
        return view('user.events.gallery', compact('event'));
    }

    /**
     * Updates page with pagination and filtering - Only shows published updates
     */
    public function updatesIndex(Request $request)
    {
        $perPage = 6; // Number of items per page
        
        // Start query - Only show published news
        $query = News::query()->where('publish', 'yes');
        
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
        $query->orderByRaw('COALESCE(news_date, created_at) DESC');
        
        $updates = $query->paginate($perPage);
        
        // Get unique types for filter dropdown (only from published news)
        $types = News::where('publish', 'yes')
            ->select('type')
            ->distinct()
            ->whereNotNull('type')
            ->pluck('type');
        
        return view('user.updates.index', compact('updates', 'types'));
    }

    /**
     * Individual updates detail page - Only shows published update
     */
    public function updatesShow(News $news)
    {
        // Check if news is published
        if ($news->publish !== 'yes') {
            abort(404);
        }
        
        // Get previous and next news for navigation (only published)
        $previousNews = News::where('publish', 'yes')
            ->where(function($query) use ($news) {
                $query->whereRaw('COALESCE(news_date, created_at) < ?', [$news->news_date ?? $news->created_at]);
            })
            ->orderByRaw('COALESCE(news_date, created_at) DESC')
            ->first();

        $nextNews = News::where('publish', 'yes')
            ->where(function($query) use ($news) {
                $query->whereRaw('COALESCE(news_date, created_at) > ?', [$news->news_date ?? $news->created_at]);
            })
            ->orderByRaw('COALESCE(news_date, created_at) ASC')
            ->first();

        return view('user.updates.show', compact('news', 'previousNews', 'nextNews'));
    }
}