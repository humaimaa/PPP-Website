<?php

// Change this line
namespace App\Http\Controllers\User;  // Add 'User' to namespace

// Keep these
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
        // Fetch all leadership messages
        $messages = LeadershipMessage::all();
        
        // Return view with messages data
        return view('user.about.message', compact('messages'));
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
    $team = \App\Models\Team::with(['designation' => function($query) {
        $query->orderBy('order', 'asc');
    }])
    ->get()
    ->sortBy(function($member) {
        return $member->designation->order ?? 999; // Fallback for members without designation
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