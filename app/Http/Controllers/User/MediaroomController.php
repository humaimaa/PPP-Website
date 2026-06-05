<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;

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
     * Updates page
     */
    public function updatesIndex()
    {
        $updates = News::orderBy('created_at', 'desc')->paginate(9);
        return view('user.updates.index', compact('updates'));
    }

    /**
     * Individual updates detail page
     */
    public function updatesShow($id)
    {
        $news = News::findOrFail($id);
        return view('user.updates.show', compact('news'));
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