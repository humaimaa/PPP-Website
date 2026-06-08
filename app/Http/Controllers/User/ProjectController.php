<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Sector;
use App\Models\OngoingProjectDetail;
use App\Models\CompletedProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{  
    /**
     * Projects page with optional status parameter
     */
    public function index($status = 'pipeline')
    {
        $validStatuses = ['pipeline', 'ongoing', 'operational', 'complete', 'all'];

        if (!in_array($status, $validStatuses)) {
            $status = 'pipeline';
        }

        // Build query based on status
        $query = Project::query();
        
        if ($status !== 'all') {
            // Map status to database values
            switch ($status) {
                case 'pipeline':
                    $query->where('category', 'pipeline');
                    break;
                case 'ongoing':
                    $query->where('category', 'ongoing');
                    break;
                case 'operational':
                case 'complete':
                    $query->where('category', 'completed');
                    break;
                default:
                    $query->where('category', $status);
            }
        }
        
        // Get projects with pagination
        $projects = $query->orderBy('created_at', 'desc')->paginate(9);
        
        // Get statistics
        $stats = [
            'pipeline' => Project::where('category', 'pipeline')->count(),
            'ongoing' => Project::where('category', 'ongoing')->count(),
            'operational' => Project::where('category', 'completed')->count(),
            'total_investment' => Project::sum('cost')
        ];
        
        return view('user.projects.index', compact('projects', 'status', 'stats'));
    }

    /**
     * Project show page
     */
    public function show($id)
    {
        // Fetch the project with its details based on category
        $project = Project::findOrFail($id);
        
        $pipelineDetails = null;
        $ongoingDetails = null;
        $completedDetails = null;
        $achievements = [];
        
        // Fetch category-specific details
        if ($project->category === 'pipeline') {
            $pipelineDetails = $project->pipelineDetail;
        }
        elseif ($project->category === 'ongoing') {
            $ongoingDetails = OngoingProjectDetail::where('project_id', $project->id)->first();
        }
        elseif ($project->category === 'completed') {
            $completedDetails = CompletedProjectDetail::where('project_id', $project->id)->first();
            
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
     * Show project statistics page
     */
    public function projectStats()
    {
        // Get all projects
        $totalProjects = Project::count();
        $totalInvestment = Project::sum('cost');
        
        // Get counts by category
        $pipelineCount = Project::where('category', 'pipeline')->count();
        $ongoingCount = Project::where('category', 'ongoing')->count();
        $completedCount = Project::where('category', 'completed')->count();
        
        // Get investment by category
        $pipelineInvestment = Project::where('category', 'pipeline')->sum('cost');
        $ongoingInvestment = Project::where('category', 'ongoing')->sum('cost');
        $completedInvestment = Project::where('category', 'completed')->sum('cost');
        
        // Get projects by division from database
        $validDivisions = ['Peshawar', 'Mardan', 'Kohat', 'Bannu', 'Dera Ismail Khan', 'Malakand', 'Hazara'];
        
        // Initialize all divisions with zero values
        $projectsByDivision = [];
        foreach ($validDivisions as $division) {
            $projectsByDivision[$division] = [
                'total' => 0,
                'active' => 0,
                'completed' => 0,
                'planned' => 0,
                'investment' => 0,
                'projects' => []
            ];
        }
        
        // Add FATA as merged districts
        $projectsByDivision['FATA'] = [
            'total' => 0,
            'active' => 0,
            'completed' => 0,
            'planned' => 0,
            'investment' => 0,
            'projects' => [],
            'is_merged' => true,
            'merged_districts' => ['Bajaur', 'Khyber', 'Kurram', 'Mohmand', 'Orakzai', 'North Waziristan', 'South Waziristan']
        ];
        
        // Fetch all projects with their details
        $allProjects = Project::select('id', 'name', 'category', 'cost', 'division', 'sector', 'location', 'overview', 'status')
            ->get();
        
        // Populate with actual data from database
        foreach ($allProjects as $project) {
            $division = $project->division;
            
            // Handle FATA projects (if any project has division = 'FATA')
            if ($division && isset($projectsByDivision[$division])) {
                $projectsByDivision[$division]['total']++;
                $projectsByDivision[$division]['investment'] += (float)($project->cost ?? 0);
                
                // Categorize by status (using category field)
                if ($project->category === 'ongoing') {
                    $projectsByDivision[$division]['active']++;
                } elseif ($project->category === 'completed') {
                    $projectsByDivision[$division]['completed']++;
                } elseif ($project->category === 'pipeline') {
                    $projectsByDivision[$division]['planned']++;
                }
                
                $projectsByDivision[$division]['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'category' => $project->category,
                    'cost' => (float)($project->cost ?? 0),
                    'sector' => $project->sector,
                    'description' => $project->overview ?? $project->description ?? null,
                    'location' => $project->location,
                    'status' => $project->status
                ];
            }
        }
        
        // Prepare data for JSON (to pass to JavaScript)
        $divisionsDataForMap = [];
        foreach ($projectsByDivision as $divisionName => $data) {
            if ($divisionName !== 'FATA') {
                $totalProjectsCount = $data['total'];
                $avgCost = $totalProjectsCount > 0 ? $data['investment'] / $totalProjectsCount : 0;
                
                $divisionsDataForMap[$divisionName] = [
                    'name' => $divisionName,
                    'projects' => [
                        'active' => $data['active'],
                        'completed' => $data['completed'],
                        'planned' => $data['planned']
                    ],
                    'investment' => $data['investment'],
                    'total_projects' => $totalProjectsCount,
                    'avg_cost' => $avgCost,
                    'projects_list' => array_slice($data['projects'], 0, 10)
                ];
            } else {
                // FATA data
                $divisionsDataForMap['FATA'] = [
                    'name' => 'FATA',
                    'is_merged' => true,
                    'merged_districts' => $data['merged_districts'],
                    'projects' => [
                        'active' => $data['active'],
                        'completed' => $data['completed'],
                        'planned' => $data['planned']
                    ],
                    'investment' => $data['investment'],
                    'total_projects' => $data['total'],
                    'avg_cost' => $data['total'] > 0 ? $data['investment'] / $data['total'] : 0,
                    'projects_list' => array_slice($data['projects'], 0, 10)
                ];
            }
        }
        
        // Get sector data for charts
        $sectorData = Project::select('sector', DB::raw('count(*) as count'), DB::raw('sum(cost) as investment'))
            ->whereNotNull('sector')
            ->groupBy('sector')
            ->get();
        
        $sectorChartData = [];
        foreach ($sectorData as $sector) {
            $sectorChartData[$sector->sector] = $sector->count;
        }
        
        // Prepare divisions grid data
        $divisionsGrid = [];
        foreach ($validDivisions as $division) {
            $divisionsGrid[] = [
                'name' => $division,
                'count' => $projectsByDivision[$division]['total'] ?? 0,
                'investment' => $projectsByDivision[$division]['investment'] ?? 0
            ];
        }
        
        // Add FATA to grid
        $divisionsGrid[] = [
            'name' => 'FATA (Merged Districts)',
            'count' => $projectsByDivision['FATA']['total'] ?? 0,
            'investment' => $projectsByDivision['FATA']['investment'] ?? 0
        ];
        
        // Sort divisions grid by name
        usort($divisionsGrid, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        
        // Calculate total statistics for the page
        $totalStats = [
            'total_projects' => $totalProjects,
            'total_investment' => $totalInvestment,
            'total_divisions' => count($validDivisions) + 1
        ];
        
        // Get recent projects
        $recentProjects = Project::latest()->take(10)->get();
        
        return view('user.projects.projectStats', compact(
            'totalProjects',
            'totalInvestment',
            'pipelineCount',
            'ongoingCount',
            'completedCount',
            'pipelineInvestment',
            'ongoingInvestment',
            'completedInvestment',
            'recentProjects',
            'allProjects',
            'projectsByDivision',
            'sectorChartData',
            'divisionsGrid',
            'divisionsDataForMap',
            'totalStats'
        ));
    }
    
    /**
     * API endpoint to get divisions data for the map
     */
    public function getDivisionsData()
    {
        $validDivisions = ['Peshawar', 'Mardan', 'Kohat', 'Bannu', 'Dera Ismail Khan', 'Malakand', 'Hazara'];
        
        $divisionsData = [];
        
        foreach ($validDivisions as $division) {
            $projects = Project::where('division', $division)->get();
            
            $active = $projects->where('category', 'ongoing')->count();
            $completed = $projects->where('category', 'completed')->count();
            $planned = $projects->where('category', 'pipeline')->count();
            $investment = $projects->sum('cost');
            
            $divisionsData[$division] = [
                'name' => $division,
                'projects' => [
                    'active' => $active,
                    'completed' => $completed,
                    'planned' => $planned
                ],
                'investment' => (float)$investment,
                'total_projects' => $projects->count(),
                'projects_list' => $projects->map(function($project) {
                    return [
                        'name' => $project->name,
                        'type' => $project->category,
                        'cost' => (float)$project->cost,
                        'sector' => $project->sector,
                        'description' => $project->overview
                    ];
                })->toArray()
            ];
        }
        
        // Add FATA data
        $fataProjects = Project::where('division', 'FATA')->get();
        $divisionsData['FATA'] = [
            'name' => 'FATA',
            'is_merged' => true,
            'merged_districts' => ['Bajaur', 'Khyber', 'Kurram', 'Mohmand', 'Orakzai', 'North Waziristan', 'South Waziristan'],
            'projects' => [
                'active' => $fataProjects->where('category', 'ongoing')->count(),
                'completed' => $fataProjects->where('category', 'completed')->count(),
                'planned' => $fataProjects->where('category', 'pipeline')->count()
            ],
            'investment' => (float)$fataProjects->sum('cost'),
            'total_projects' => $fataProjects->count(),
            'projects_list' => $fataProjects->map(function($project) {
                return [
                    'name' => $project->name,
                    'type' => $project->category,
                    'cost' => (float)$project->cost,
                    'sector' => $project->sector,
                    'description' => $project->overview
                ];
            })->toArray()
        ];
        
        return response()->json($divisionsData);
    }
}