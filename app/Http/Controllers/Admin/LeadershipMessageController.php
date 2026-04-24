<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMessage;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'message'     => 'required|string',
        ]);

        LeadershipMessage::create($validated);

        return redirect()
            ->route('admin.leadership.index')
            ->with('success', 'Message created successfully.');
    }

    // Parameter name MUST match the route {message}
    public function show(LeadershipMessage $message)
    {
        return view('admin.leadership.show', compact('message'));
    }

    public function edit(LeadershipMessage $message)
    {
        return view('admin.leadership.edit', compact('message'));
    }

    public function update(Request $request, LeadershipMessage $message)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'message'     => 'required|string',
        ]);

        $message->update($validated);

        return redirect()
            ->route('admin.leadership.index')
            ->with('success', 'Message updated successfully.');
    }

    public function destroy(LeadershipMessage $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.leadership.index')
            ->with('success', 'Message deleted successfully.');
    }
}