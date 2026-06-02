<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Download;
use App\Models\Tender;  
use App\Models\CompletedProjectDetail;
use App\Models\OngoingProjectDetail;
use App\Models\LeadershipMessage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Homepage
     */
    public function home()
    {
        return view('user.home');
    }

    /**
     * Pitchbook page
     */
    public function pitchbook()
    {
        return view('user.pitchbook');
    }



    /**
     * Projects page with optional status parameter
     */
    public function projectsIndex($status = 'pipeline')
    {
        $validStatuses = ['pipeline', 'ongoing', 'operational', 'complete'];

        if (!in_array($status, $validStatuses)) {
            $status = 'pipeline';
        }

        // Map 'complete' to 'operational' for the view
        if ($status === 'complete') {
            $status = 'operational';
        }

        return view('user.projects.index', compact('status'));
    }

    /**
     * Project show page
     */
    public function projectShow($id)
    {
        // Fetch the project with its details based on category
        $project = Project::findOrFail($id);
        
        $pipelineDetails = null;
        $ongoingDetails = null;
        $completedDetails = null;
        $achievements = [];
        
        // Fetch category-specific details
        if ($project->category === 'Pipeline') {
            $pipelineDetails = $project->pipelineDetail;
        }
        elseif ($project->category === 'Ongoing') {
            $ongoingDetails = OngoingProjectDetail::where('project_id', $project->id)->first();
        }
        elseif ($project->category === 'Completed') {
            $completedDetails = CompletedProjectDetail::where('project_id', $project->id)->first();
            
            // Example achievements for completed projects
            $achievements = [
                'Successfully completed within budget',
                'Created 500+ local jobs',
                'Served 100,000+ beneficiaries',
                'Received international recognition for best practices'
            ];
        }
        
        return view('user.projects.show', compact(
            'project', 
            'pipelineDetails', 
            'ongoingDetails', 
            'completedDetails',
            'achievements'
        ));
    }



    /**
     * Events page
     */
    public function eventsIndex()
    {
        return view('user.events.index');
    }

    /**
     * Events page
     */
    public function updatesIndex()
    {
        return view('user.updates.index');
    }

/**
 * Tenders page with optional section parameter
 */
public function tenders($section = 'general-procurement')
{
    $validSections = [
        'general-procurement',
        'transaction-advisory',
        'private-partner'
    ];

    if (!in_array($section, $validSections)) {
        $section = 'general-procurement';
    }

    // Map URL sections to database category values
    $categoryMapping = [
        'general-procurement' => 'General Procurement',
        'transaction-advisory' => 'Transaction Advisory',
        'private-partner' => 'Private Partner Selection'
    ];

    $category = $categoryMapping[$section];

    // Fetch all tenders (both active and archived) ordered by closing date desc
    $allTenders = Tender::where('category', $category)
        ->orderBy('closing_date', 'desc')
        ->with('additionalDocs')
        ->get();

    return view('user.tenders', compact('section', 'allTenders'));
}

    /**
     * Individual updates detail page
     */
    public function updatesShow($id)
    {
        return view('user.updates.show', compact('id'));
    }

    /**
     * Gallery album page
     */
    public function eventGallery($id)
    {
        return view('user.events.gallery', compact('id'));
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