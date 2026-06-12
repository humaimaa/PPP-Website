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
}