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
        // Fetch all leadership messages EXCEPT Chief Minister
        $messages = LeadershipMessage::where('designation', '!=', 'Chief Minister')
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
        // Load team members with their designations, ordered by designation.order
        $team = Team::with(['designation' => function($query) {
            $query->orderBy('order', 'asc');
        }])
        ->get()
        ->sortBy(function($member) {
            return $member->designation->order ?? 999;
        });
        
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