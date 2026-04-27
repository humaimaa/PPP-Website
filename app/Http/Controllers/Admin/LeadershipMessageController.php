<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadershipMessageController extends Controller
{
    public function index()
    {
        $messages = LeadershipMessage::latest()->get();
        return view('admin.leadership.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.leadership.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'message'     => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'designation', 'message']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('leadership', 'public');
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
            'designation' => 'required|string|max:255',
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
}