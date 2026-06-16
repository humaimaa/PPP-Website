<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Hierarchy; // Changed from Designation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index(Request $request)
    {
        $query = Team::with('hierarchy'); // Changed from 'designation'
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('designation', 'like', '%' . $search . '%'); // Added designation search
            });
        }
        
        $teamMembers = $query->latest()->paginate(10);
        
        return view('admin.team.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create()
    {
        $hierarchies = Hierarchy::orderBy('order')->orderBy('title')->get(); // Changed from Designation
        return view('admin.team.create', compact('hierarchies'));
    }

    /**
     * Store a newly created team member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hierarchy_id' => 'required|exists:hierarchy,id', // Changed from designation_id
            'designation' => 'required|string|max:255', // New validation for designation
            'email' => 'required|email|unique:team,email',
            'img' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'phone' => 'required|string|max:20',
        ]);

        $imagePath = $request->file('img')->store('team', 'public');

        Team::create([
            'name' => $request->name,
            'hierarchy_id' => $request->hierarchy_id, // Changed from designation_id
            'designation' => $request->designation, // New field
            'email' => $request->email,
            'img' => $imagePath,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member added successfully.');
    }

    /**
     * Display the specified team member.
     */
    public function show(Team $team)
    {
        $team->load('hierarchy'); // Changed from 'designation'
        return view('admin.team.show', ['teamMember' => $team]);
    }
    
    /**
     * Show the form for editing the specified team member.
     */
    public function edit(Team $team)
    {
        $hierarchies = Hierarchy::orderBy('order')->orderBy('title')->get(); // Changed from Designation
        return view('admin.team.edit', ['teamMember' => $team, 'hierarchies' => $hierarchies]);
    }
    
    /**
     * Update the specified team member.
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hierarchy_id' => 'required|exists:hierarchy,id', // Changed from designation_id
            'designation' => 'required|string|max:255', // New validation for designation
            'email' => 'required|email|unique:team,email,' . $team->id,
            'img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'phone' => 'required|string|max:20',
        ]);

        $data = [
            'name' => $request->name,
            'hierarchy_id' => $request->hierarchy_id, // Changed from designation_id
            'designation' => $request->designation, // New field
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('img')) {
            // Delete old image
            if ($team->img) {
                Storage::disk('public')->delete($team->img);
            }
            $data['img'] = $request->file('img')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member updated successfully.');
    }

    /**
     * Remove the specified team member.
     */
    public function destroy(Team $team)
    {
        // Delete image
        if ($team->img) {
            Storage::disk('public')->delete($team->img);
        }
        
        $team->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member deleted successfully.');
    }

    /**
     * Bulk delete team members.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'team_ids' => 'required|array',
            'team_ids.*' => 'exists:team,id',
        ]);

        $teamMembers = Team::whereIn('id', $request->team_ids)->get();
        $deletedCount = $teamMembers->count();
        
        foreach ($teamMembers as $member) {
            if ($member->img) {
                Storage::disk('public')->delete($member->img);
            }
        }
        
        Team::whereIn('id', $request->team_ids)->delete();

        return redirect()->route('admin.team.index')
            ->with('success', $deletedCount . ' team member(s) deleted successfully.');
    }
}