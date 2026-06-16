<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\LeadershipMessage;

class AboutController extends Controller
{
    /**
     * About page - main overview
     */
    public function about()
    {
        return view('user.about.index');
    }

    /**
     * Functions page
     */
    public function function()
    {
        return view('user.about.function');
    }

    /**
     * Message from leadership page
     */
    public function message()
    {
        // Define the order based on enum values (excluding Chief Minister)
        $order = [
            'Chief Secretary',
            'Additional Chief Secretary Development',
            'Secretary P&D',
            'Chief PPP'
        ];
        
        // Fetch all leadership messages EXCEPT Chief Minister and order by the custom order
        $messages = LeadershipMessage::where('designation', '!=', 'Chief Minister')
            ->orderByRaw("FIELD(designation, '" . implode("','", $order) . "')")
            ->get();
        
        // Return view with messages data
        return view('user.about.messages', compact('messages'));
    }

    /**
     * Organogram page
     */
    public function organogram()
    {
        return view('user.about.organogram');
    }
    
    /**
     * Team page
     */
    public function team()
    {
        // Load team members with their hierarchy (not designation)
        $team = Team::with('hierarchy') // Changed from 'designation'
            ->join('hierarchy', 'team.hierarchy_id', '=', 'hierarchy.id')
            ->orderBy('hierarchy.order', 'asc')
            ->select('team.*') // Prevent column conflicts
            ->get();
        
        return view('user.about.team', compact('team'));
    }

    /**
     * Mission & Vision page
     */
    public function missionVision()
    {
        return view('user.about.mission-vision');
    }
}