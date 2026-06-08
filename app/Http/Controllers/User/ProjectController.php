<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Sector;
use App\Models\OngoingProjectDetail;
use App\Models\CompletedProjectDetail;
use Illuminate\Http\Request;

class ProjectController extends Controller
{  
    /**
     * Projects page with optional status parameter
     */
    public function index($status = 'pipeline')  // Changed from projectsIndex to index
    {
        $validStatuses = ['pipeline', 'ongoing', 'operational', 'complete', 'all'];

        if (!in_array($status, $validStatuses)) {
            $status = 'pipeline';
        }

        // Map 'complete' to 'operational' for consistency
        if ($status === 'complete') {
            $status = 'operational';
        }

        // Build query based on status
        $query = Project::query();
        
        if ($status !== 'all') {
            if ($status === 'operational') {
                $query->where('category', 'Completed');
            } else {
                $query->where('category', ucfirst($status));
            }
        }
        
        // Get projects with pagination
        $projects = $query->orderBy('created_at', 'desc')->paginate(9);
        
        // Get statistics
        $stats = [
            'pipeline' => Project::where('category', 'Pipeline')->count(),
            'ongoing' => Project::where('category', 'Ongoing')->count(),
            'operational' => Project::where('category', 'Completed')->count(),
            'total_investment' => Project::sum('cost')
        ];
        
        return view('user.projects.index', compact('projects', 'status', 'stats'));
    }

    /**
     * Project show page
     */
    public function show($id)  // Changed from projectShow to show
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
            
            // Dynamic achievements - you can add this to the completed_project_details table
            // For now, using sample achievements
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
}