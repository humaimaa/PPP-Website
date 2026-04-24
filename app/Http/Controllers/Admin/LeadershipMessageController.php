<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMessage;
use Illuminate\Http\Request;

class LeadershipMessageController extends Controller
{
    public function index()
    {
        $messages = LeadershipMessage::all();
        return view('admin.leadershipMessages.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.leadershipMessages.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'message'     => 'required',
        ]);

        LeadershipMessage::create($validated);

        return redirect()
            ->route('admin.leadership-messages.index')   // change if you don't have 'admin.' prefix
            ->with('success', 'Message created successfully.');
    }

    // Resource route parameter is {leadership_message} (automatically from 'leadership-messages')
    public function show(LeadershipMessage $leadership_message)
    {
        return view('admin.leadershipMessages.show', [
            'message' => $leadership_message   // alias so Blade can use $message
        ]);
    }

    public function edit(LeadershipMessage $leadership_message)
    {
        return view('admin.leadershipMessages.edit', [
            'message' => $leadership_message
        ]);
    }

    public function update(Request $request, LeadershipMessage $leadership_message)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'message'     => 'required',
        ]);

        $leadership_message->update($validated);

        return redirect()
            ->route('admin.leadership-messages.index')
            ->with('success', 'Message updated successfully.');
    }

    public function destroy(LeadershipMessage $leadership_message)
    {
        $leadership_message->delete();

        return redirect()
            ->route('admin.leadership-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}