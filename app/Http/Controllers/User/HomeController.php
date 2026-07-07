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
        
        // Get leadership messages - prioritize Chief Minister
        $leadershipMessage = LeadershipMessage::where('designation', 'Chief Minister / Chairman of PPP Committee')->first();
        
        // If no Chief Minister message, try Chief Secretary
        if (!$leadershipMessage) {
            $leadershipMessage = LeadershipMessage::where('designation', 'Chief Secretary / Chairman of PPP Unit')->first();
        }
        
        // If still no message, get the first available
        if (!$leadershipMessage) {
            $leadershipMessage = LeadershipMessage::first();
        }
        
        // Get latest 3 featured news (only published)
        $latestNews = News::where('publish', 'yes')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // If no featured news found, get the latest 3 published news instead
        if ($latestNews->count() < 3) {
            $fallbackNews = News::where('publish', 'yes')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
            
            // Merge if we have some featured news, otherwise use fallback
            if ($latestNews->count() > 0) {
                $latestNews = $latestNews->merge($fallbackNews)->unique('id')->take(3);
            } else {
                $latestNews = $fallbackNews;
            }
        }
        
        return view('user.home', compact('sectors', 'leadershipMessage', 'latestNews'));
    }
}