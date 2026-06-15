<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CompletedProjectDetail;
use App\Models\OngoingProjectDetail;

class PageController extends Controller
{
    public function pitchbook()
    {
        $data = [
            'title' => 'PPP KP - Digital Pitchbook ' . date('Y'),
            'totalPages' => 80,
            'slideCount' => 80,
            'currentYear' => date('Y'),
            'companyName' => 'PPP KP',
            'email' => 'info@ppkp.com',
            'phone' => '+92 XXX XXXXXXX'
        ];
        
        return view('user.pitchbook', $data);
    }

    /**
     * API endpoint for downloading files
     */
    public function apiDownloadFile($id)
    {
        return response()->json(['success' => true]);
    }

    /**
     * API endpoint for previewing files
     */
    public function apiPreviewFile($id)
    {
        return response()->json(['success' => true]);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return view('user.contact');
    }
}