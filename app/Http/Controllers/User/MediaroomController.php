<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaroomController extends Controller
{
    /**
     * Events page with albums
     */
    public function eventsIndex(Request $request)
    {
        $perPage = 9; // Number of events per page
        
        // Get events with gallery count and eager load galleries for thumbnail
        $events = Event::withCount('galleries')
                       ->with('galleries') // Eager load galleries to get thumbnail
                       ->orderBy('event_date', 'desc')
                       ->paginate($perPage);
        
        return view('user.events.index', compact('events'));
    }

    /**
     * Event gallery - Show all images for a specific event
     */
    public function eventGallery($id)
    {
        $event = Event::with('galleries')->findOrFail($id);
        
        // Get previous and next events for navigation
        $previousEvent = Event::where('event_date', '<', $event->event_date)
                              ->orderBy('event_date', 'desc')
                              ->first();
        
        $nextEvent = Event::where('event_date', '>', $event->event_date)
                          ->orderBy('event_date', 'asc')
                          ->first();
        
        return view('user.events.gallery', compact('event', 'previousEvent', 'nextEvent'));
    }

    /**
     * Updates page with pagination
     */
    public function updatesIndex(Request $request)
    {
        $perPage = 6;
        
        $updates = News::orderByRaw('COALESCE(news_date, created_at) DESC')
                       ->paginate($perPage);
        
        return view('user.updates.index', compact('updates'));
    }

    /**
     * Individual updates detail page
     */
    public function updatesShow($id)
    {
        $news = News::findOrFail($id);
        
        $currentDate = $news->news_date ?? $news->created_at;
        
        $previousNews = News::where(function($query) use ($currentDate, $news) {
                                $query->where(DB::raw('COALESCE(news_date, created_at)'), '<', $currentDate)
                                      ->orWhere(function($q) use ($currentDate, $news) {
                                          $q->where(DB::raw('COALESCE(news_date, created_at)'), $currentDate)
                                            ->where('id', '<', $news->id);
                                      });
                            })
                            ->orderBy(DB::raw('COALESCE(news_date, created_at)'), 'desc')
                            ->orderBy('id', 'desc')
                            ->first();
        
        $nextNews = News::where(function($query) use ($currentDate, $news) {
                            $query->where(DB::raw('COALESCE(news_date, created_at)'), '>', $currentDate)
                                  ->orWhere(function($q) use ($currentDate, $news) {
                                      $q->where(DB::raw('COALESCE(news_date, created_at)'), $currentDate)
                                        ->where('id', '>', $news->id);
                                  });
                        })
                        ->orderBy(DB::raw('COALESCE(news_date, created_at)'), 'asc')
                        ->orderBy('id', 'asc')
                        ->first();
        
        return view('user.updates.show', compact('news', 'previousNews', 'nextNews'));
    }
}