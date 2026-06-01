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
<<<<<<< HEAD
    }



    /**
     * Events page
     */
    public function eventsIndex()
    {
        return view('user.events.index');
    }

    /**
=======
    }

    /**
 * Resource Center / Downloads page with optional section parameter
 */
public function downloads($section = 'legal-framework')
{
    $validSections = [
        'legal-framework',
        'pre-qualified-advisors',
        'policies-regulations',
        'knowledge-hub'
    ];

    if (!in_array($section, $validSections)) {
        $section = 'legal-framework';
    }

    // Map URL sections to database category values
    $categoryMapping = [
        'legal-framework' => 'Legal Framework',
        'pre-qualified-advisors' => 'Prequalified Transaction Advisory',
        'policies-regulations' => 'Policies ,Regulations and Guidelines',
        'knowledge-hub' => 'Knowledge Hub'
    ];

    // Get the corresponding database category
    $category = $categoryMapping[$section];

    // Fetch downloads filtered by category
    $downloads = Download::where('category', $category)
        ->orderBy('date', 'desc')
        ->paginate(12);

    // Return the view with section and downloads
    return view('user.downloads', compact('section', 'downloads'));
}

    /**
     * Events page
     */
    public function eventsIndex()
    {
        return view('user.events.index');
    }

    /**
>>>>>>> b32403fc1fe7700c15202303dd81552e1a18f5cd
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