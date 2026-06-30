<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LeadershipMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = LeadershipMessage::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        $messages = $query->latest()->paginate(10);
        return view('admin.leadership.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.leadership.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => ['required', 'string', Rule::in(LeadershipMessage::getDesignations())],
            'message'     => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        $data = $request->only(['name', 'designation', 'message']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('leadership', 'public');
            $data['image'] = $imagePath;
        }

        LeadershipMessage::create($data);

        return redirect()->route('admin.leadership.index')
                         ->with('success', 'Leadership message added successfully.');
    }

    public function show($id)
    {
        $message = LeadershipMessage::findOrFail($id);
        return view('admin.leadership.show', compact('message'));
    }

    public function edit($id)
    {
        $message = LeadershipMessage::findOrFail($id);
        return view('admin.leadership.edit', compact('message'));
    }

    public function update(Request $request, $id)
    {
        $message = LeadershipMessage::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => ['required', 'string', Rule::in(LeadershipMessage::getDesignations())],
            'message'     => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        $data = $request->only(['name', 'designation', 'message']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($message->image && Storage::disk('public')->exists($message->image)) {
                Storage::disk('public')->delete($message->image);
            }
            
            $imagePath = $request->file('image')->store('leadership', 'public');
            $data['image'] = $imagePath;
        }

        $message->update($data);

        return redirect()->route('admin.leadership.index')
                         ->with('success', 'Leadership message updated successfully.');
    }

    public function destroy($id)
    {
        $message = LeadershipMessage::findOrFail($id);
        
        // Delete image if exists
        if ($message->image && Storage::disk('public')->exists($message->image)) {
            Storage::disk('public')->delete($message->image);
        }
        
        $message->delete();

        return redirect()->route('admin.leadership.index')
                         ->with('success', 'Leadership message deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'message_ids'   => 'required|array',
            'message_ids.*' => 'exists:leadership_messages,id',
        ]);

        $ids = $request->message_ids;
        $deletedCount = 0;
        $deletedNames = [];

        foreach ($ids as $id) {
            $message = LeadershipMessage::find($id);
            if ($message) {
                // Delete image if exists
                if ($message->image && Storage::disk('public')->exists($message->image)) {
                    Storage::disk('public')->delete($message->image);
                }
                $deletedNames[] = $message->name;
                $message->delete();
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            $messageText = $deletedCount . " message(s) deleted successfully.";
            if (count($deletedNames) <= 5) {
                $messageText .= " (" . implode(', ', $deletedNames) . ")";
            }
            return redirect()->route('admin.leadership.index')
                             ->with('success', $messageText);
        }

        return redirect()->route('admin.leadership.index')
                         ->with('error', 'No messages were deleted.');
    }
}