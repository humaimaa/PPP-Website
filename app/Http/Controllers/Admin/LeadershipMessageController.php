<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LeadershipMessageController extends Controller
{
    /**
     * Display a listing of messages with search functionality.
     */
    public function index(Request $request)
    {
        $query = LeadershipMessage::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('designation', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%');
            });
        }
        
        $messages = $query->latest()->paginate(10);
        
        return view('admin.leadership.index', compact('messages'));
    }

    /**
     * Show the form for creating a new message.
     */
    public function create()
    {
        return view('admin.leadership.create');
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => ['required', 'string', Rule::in(LeadershipMessage::getDesignations())],
            'message'     => 'required|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'designation', 'message']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('leadership', 'public');
        }

        LeadershipMessage::create($data);

        return redirect()->route('admin.leadership.index')
                         ->with('success', 'Leadership message added successfully.');
    }

    /**
     * Display the specified message.
     */
    public function show($id)
    {
        $message = LeadershipMessage::findOrFail($id);
        return view('admin.leadership.show', compact('message'));
    }

    /**
     * Show the form for editing the specified message.
     */
    public function edit($id)
    {
        $message = LeadershipMessage::findOrFail($id);
        return view('admin.leadership.edit', compact('message'));
    }

    /**
     * Update the specified message.
     */
    public function update(Request $request, $id)
    {
        $message = LeadershipMessage::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => ['required', 'string', Rule::in(LeadershipMessage::getDesignations())],
            'message'     => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'designation', 'message']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($message->image) {
                Storage::disk('public')->delete($message->image);
            }
            $data['image'] = $request->file('image')->store('leadership', 'public');
        }

        $message->update($data);

        return redirect()->route('admin.leadership.index')
                         ->with('success', 'Leadership message updated successfully.');
    }

    /**
     * Remove the specified message.
     */
    public function destroy($id)
    {
        $message = LeadershipMessage::findOrFail($id);

        if ($message->image) {
            Storage::disk('public')->delete($message->image);
        }

        $message->delete();

        return redirect()->route('admin.leadership.index')
                         ->with('success', 'Leadership message deleted successfully.');
    }

    /**
     * Bulk delete messages.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'message_ids' => ['required', 'array'],
            'message_ids.*' => ['exists:leadership_messages,id'],
        ]);

        $messageIds = $request->message_ids;
        $deletedCount = 0;
        $deletedMessages = [];

        foreach ($messageIds as $id) {
            $message = LeadershipMessage::find($id);
            if ($message) {
                // Delete associated image
                if ($message->image) {
                    Storage::disk('public')->delete($message->image);
                }
                $deletedMessages[] = $message->name;
                $message->delete();
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            $messageText = $deletedCount . " message(s) deleted successfully";
            if (count($deletedMessages) <= 5) {
                $messageText .= ": " . implode(', ', $deletedMessages);
            }
            return redirect()->route('admin.leadership.index')
                ->with('success', $messageText);
        }

        return redirect()->route('admin.leadership.index')
            ->with('error', 'No messages were deleted.');
    }
}