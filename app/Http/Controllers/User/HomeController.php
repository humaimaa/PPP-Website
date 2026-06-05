<?php
namespace App\Http\Controllers\User;  

use App\Http\Controllers\Controller;

use App\Models\Sector;
use App\Models\LeadershipMessage;
use App\Models\News;

class HomeController extends Controller
{
    /**
     * Homepage
     */
    public function home()
    {
        // Get all sectors for display (4 per row)
        $sectors = Sector::all();
        
        // Get leadership messages (show the Chief PPP first if exists, otherwise first record)
        $leadershipMessage = LeadershipMessage::where('designation', 'Chief PPP')->first();
        if (!$leadershipMessage) {
            $leadershipMessage = LeadershipMessage::first();
        }
        
        // Get latest 3 news updates
        $latestNews = News::orderBy('created_at', 'desc')->take(3)->get();
        
        return view('user.home', compact('sectors', 'leadershipMessage', 'latestNews'));
    }
}