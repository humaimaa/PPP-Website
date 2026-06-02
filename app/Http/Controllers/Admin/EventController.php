<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource with search functionality.
     */
    public function index(Request $request)
    {
        $query = Event::with('gallery');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('event_date', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('event_date', '<=', $request->to_date);
        }
        
        $events = $query->latest()->paginate(10);
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'thumbnail' => 'required|integer|min:0',
        ]);

        // Create event
        $event = Event::create([
            'title' => $validated['title'],
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'event_date' => $validated['event_date'],
        ]);

        // Upload and save gallery images
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('events/gallery', 'public');
            
            Gallery::create([
                'event_id' => $event->id,
                'image' => $path,
                'is_thumbnail' => ($index == $request->thumbnail),
            ]);
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully with gallery images.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('gallery');
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $event->load('gallery');
        return view('admin.events.edit', compact('event'));
    }

    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, Event $event)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'event_date' => 'required|date',
        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        'deleted_images' => 'nullable|array',
        'deleted_images.*' => 'exists:gallery,id',
        'thumbnail' => 'nullable|string', // Can be ID or 'new_X'
    ]);

    // Update event details
    $event->update([
        'title' => $validated['title'],
        'location' => $validated['location'] ?? null,
        'description' => $validated['description'] ?? null,
        'event_date' => $validated['event_date'],
    ]);

    // Handle deleted images
    if (isset($validated['deleted_images']) && !empty($validated['deleted_images'])) {
        foreach ($validated['deleted_images'] as $imageId) {
            $gallery = Gallery::find($imageId);
            if ($gallery) {
                Storage::disk('public')->delete($gallery->image);
                $gallery->delete();
            }
        }
    }

    // Upload new images
    $newImageIndices = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('events/gallery', 'public');
            
            $gallery = Gallery::create([
                'event_id' => $event->id,
                'image' => $path,
                'is_thumbnail' => false,
            ]);
            $newImageIndices[$index] = $gallery->id;
        }
    }

    // Handle thumbnail update
    if ($request->has('thumbnail')) {
        $thumbnail = $request->thumbnail;
        
        // Reset all thumbnails
        $event->gallery()->update(['is_thumbnail' => false]);
        
        // Check if thumbnail is a new image
        if (str_starts_with($thumbnail, 'new_')) {
            $newIndex = (int) explode('_', $thumbnail)[1];
            if (isset($newImageIndices[$newIndex])) {
                Gallery::where('id', $newImageIndices[$newIndex])->update(['is_thumbnail' => true]);
            }
        } else {
            // Thumbnail is an existing image ID
            Gallery::where('id', $thumbnail)->update(['is_thumbnail' => true]);
        }
    }

    return redirect()->route('admin.events.index')
        ->with('success', 'Event updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete all associated gallery images from storage
        foreach ($event->gallery as $gallery) {
            Storage::disk('public')->delete($gallery->image);
        }
        
        $event->delete();
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Bulk delete events.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'event_ids' => 'required|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $events = Event::whereIn('id', $request->event_ids)->get();
        $deletedCount = $events->count();
        
        foreach ($events as $event) {
            // Delete all gallery images
            foreach ($event->gallery as $gallery) {
                Storage::disk('public')->delete($gallery->image);
            }
        }
        
        Event::whereIn('id', $request->event_ids)->delete();

        return redirect()->route('admin.events.index')
            ->with('success', $deletedCount . ' event(s) deleted successfully.');
    }

    /**
     * Set an image as thumbnail via AJAX.
     */
    public function setThumbnail(Request $request, $imageId)
    {
        $gallery = Gallery::findOrFail($imageId);
        
        // Remove thumbnail flag from all images of this event
        Gallery::where('event_id', $gallery->event_id)->update(['is_thumbnail' => false]);
        
        // Set the selected image as thumbnail
        $gallery->update(['is_thumbnail' => true]);
        
        return response()->json(['success' => true]);
    }
}