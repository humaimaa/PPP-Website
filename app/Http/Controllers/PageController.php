<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CompletedProjectDetail;
use App\Models\OngoingProjectDetail;


class PageController extends Controller
{
    /**
     * Pitchbook page
     */
    public function pitchbook()
    {
        return view('user.pitchbook');
    }
    /**
     * API endpoint for downloading files
     */
    public function apiDownloadFile($id)
    {
        // Implement file download logic
        return response()->json(['success' => true]);
    }

    /**
     * API endpoint for previewing files
     */
    public function apiPreviewFile($id)
    {
        // Implement file preview logic
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