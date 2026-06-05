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
        $events = Event::orderBy('event_date', 'desc')->paginate(12);
        return view('user.events.index', compact('events'));
    }

    /**
     * Updates page with pagination
     */
    public function updatesIndex(Request $request)
    {
        $perPage = 6; // Number of items per page
        $updates = News::orderBy('created_at', 'desc')->paginate($perPage);
        
        return view('user.updates.index', compact('updates'));
    }

    /**
     * Individual updates detail page
     */
    public function updatesShow($id)
    {
        $news = News::findOrFail($id);
        
        // Get previous and next news for navigation
        $previousNews = News::where('created_at', '<', $news->created_at)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $nextNews = News::where('created_at', '>', $news->created_at)
            ->orderBy('created_at', 'asc')
            ->first();
        
        return view('user.updates.show', compact('news', 'previousNews', 'nextNews'));
    }

    /**
     * Gallery album page
     */
    public function eventGallery($id)
    {
        $event = Event::findOrFail($id);
        return view('user.events.gallery', compact('event'));
    }
}