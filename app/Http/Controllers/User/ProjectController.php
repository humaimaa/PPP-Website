<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\OngoingProjectDetail;
use App\Models\CompletedProjectDetail;
use App\Models\PipelineProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{  
    /**
     * Helper function to convert cost string to numeric value in PKR
     */
    private function getRawCostValue($costString)
    {
        if (empty($costString)) return 0;
        
        if (is_numeric($costString)) {
            return (float)$costString;
        }
        
        $costString = strtolower(trim($costString));
        preg_match('/([\d,]+\.?\d*)/', $costString, $matches);
        $numericValue = isset($matches[1]) ? (float)str_replace(',', '', $matches[1]) : 0;
        
        if (strpos($costString, 'billion') !== false) {
            return $numericValue * 1000000000;
        }
        elseif (strpos($costString, 'million') !== false) {
            return $numericValue * 1000000;
        }
        elseif (strpos($costString, 'crore') !== false || strpos($costString, 'cr') !== false) {
            return $numericValue * 10000000;
        }
        else {
            return $numericValue;
        }
    }

    /**
     * Projects page with optional status parameter
     * Filtering by status field with specific values
     */
    public function index($status = 'all')
    {
        $validStatuses = ['all', 'pipeline', 'ongoing', 'operational', 'complete', 'private-partner', 'transaction-advisory', 'construction'];

        if (!in_array($status, $validStatuses)) {
            $status = 'all';
        }

        // Build query based on status field
        $query = Project::query();
        
        if ($status !== 'all') {
            // Map URL status to database status values
            switch ($status) {
                case 'pipeline':
                    $query->where('status', 'Pipeline');
                    break;
                case 'ongoing':
                    $query->where('status', 'Ongoing');
                    break;
                case 'operational':
                    $query->where('status', 'Operational');
                    break;
                case 'complete':
                    $query->where('status', 'Complete');
                    break;
                case 'private-partner':
                    $query->where('status', 'Private Partner Selection');
                    break;
                case 'transaction-advisory':
                    $query->where('status', 'Transaction Advisory');
                    break;
                case 'construction':
                    $query->where('status', 'Construction');
                    break;
                default:
                    $query->where('status', $status);
            }
        }
        
        // Get projects with pagination
        $projects = $query->orderBy('created_at', 'desc')->paginate(9);
        
        // Get statistics with proper cost conversion
        $allProjects = Project::all();
        $totalInvestmentRaw = 0;
        
        foreach ($allProjects as $project) {
            $totalInvestmentRaw += $this->getRawCostValue($project->cost);
        }
        
        $stats = [
            'pipeline' => Project::where('status', 'Pipeline')->count(),
            'ongoing' => Project::where('status', 'Ongoing')->count(),
            'operational' => Project::where('status', 'Operational')->count(),
            'complete' => Project::where('status', 'Complete')->count(),
            'private_partner' => Project::where('status', 'Private Partner Selection')->count(),
            'transaction_advisory' => Project::where('status', 'Transaction Advisory')->count(),
            'construction' => Project::where('status', 'Construction')->count(),
            'total_investment' => $totalInvestmentRaw
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
        if ($project->category === 'Pipeline') {
            $pipelineDetails = $project->pipelineDetail;
        }
        elseif ($project->category === 'Ongoing') {
            $ongoingDetails = OngoingProjectDetail::where('project_id', $project->id)->first();
        }
        elseif ($project->category === 'Completed') {
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
        $allProjects = Project::all();
        $totalProjects = $allProjects->count();
        
        // Calculate total investment
        $totalInvestmentRaw = 0;
        foreach ($allProjects as $proj) {
            $totalInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        $totalInvestment = $totalInvestmentRaw;
        
        // Get counts by status
        $pipelineCount = Project::where('status', 'Pipeline')->count();
        $ongoingCount = Project::where('status', 'Ongoing')->count();
        $operationalCount = Project::where('status', 'Operational')->count();
        $completeCount = Project::where('status', 'Complete')->count();
        $privatePartnerCount = Project::where('status', 'Private Partner Selection')->count();
        $transactionAdvisoryCount = Project::where('status', 'Transaction Advisory')->count();
        $constructionCount = Project::where('status', 'Construction')->count();
        
        // Get investment by status
        $pipelineInvestmentRaw = 0;
        $ongoingInvestmentRaw = 0;
        $operationalInvestmentRaw = 0;
        $completeInvestmentRaw = 0;
        $privatePartnerInvestmentRaw = 0;
        $transactionAdvisoryInvestmentRaw = 0;
        $constructionInvestmentRaw = 0;
        
        foreach (Project::where('status', 'Pipeline')->get() as $proj) {
            $pipelineInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('status', 'Ongoing')->get() as $proj) {
            $ongoingInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('status', 'Operational')->get() as $proj) {
            $operationalInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('status', 'Complete')->get() as $proj) {
            $completeInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('status', 'Private Partner Selection')->get() as $proj) {
            $privatePartnerInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('status', 'Transaction Advisory')->get() as $proj) {
            $transactionAdvisoryInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('status', 'Construction')->get() as $proj) {
            $constructionInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        
        $pipelineInvestment = $pipelineInvestmentRaw;
        $ongoingInvestment = $ongoingInvestmentRaw;
        $operationalInvestment = $operationalInvestmentRaw;
        $completeInvestment = $completeInvestmentRaw;
        $privatePartnerInvestment = $privatePartnerInvestmentRaw;
        $transactionAdvisoryInvestment = $transactionAdvisoryInvestmentRaw;
        $constructionInvestment = $constructionInvestmentRaw;
        
        // Define valid divisions
        $validDivisions = ['Peshawar', 'Mardan', 'Kohat', 'Bannu', 'Dera Ismail Khan', 'Malakand', 'Hazara'];
        
        // Initialize all divisions with zero values
        $projectsByDivision = [];
        foreach ($validDivisions as $division) {
            $projectsByDivision[$division] = [
                'total' => 0,
                'pipeline' => 0,
                'ongoing' => 0,
                'operational' => 0,
                'complete' => 0,
                'private_partner' => 0,
                'transaction_advisory' => 0,
                'construction' => 0,
                'investment' => 0,
                'projects' => []
            ];
        }
        
        // Add FATA as merged districts
        $projectsByDivision['FATA'] = [
            'total' => 0,
            'pipeline' => 0,
            'ongoing' => 0,
            'operational' => 0,
            'complete' => 0,
            'private_partner' => 0,
            'transaction_advisory' => 0,
            'construction' => 0,
            'investment' => 0,
            'projects' => [],
            'is_merged' => true,
            'merged_districts' => ['Bajaur', 'Khyber', 'Kurram', 'Mohmand', 'Orakzai', 'North Waziristan', 'South Waziristan']
        ];
        
        // Populate with actual data from database
        foreach ($allProjects as $project) {
            $division = $project->division;
            
            if ($division && isset($projectsByDivision[$division])) {
                $projectsByDivision[$division]['total']++;
                $projectsByDivision[$division]['investment'] += $this->getRawCostValue($project->cost);
                
                // Categorize by status
                if ($project->status === 'Pipeline') {
                    $projectsByDivision[$division]['pipeline']++;
                } elseif ($project->status === 'Ongoing') {
                    $projectsByDivision[$division]['ongoing']++;
                } elseif ($project->status === 'Operational') {
                    $projectsByDivision[$division]['operational']++;
                } elseif ($project->status === 'Complete') {
                    $projectsByDivision[$division]['complete']++;
                } elseif ($project->status === 'Private Partner Selection') {
                    $projectsByDivision[$division]['private_partner']++;
                } elseif ($project->status === 'Transaction Advisory') {
                    $projectsByDivision[$division]['transaction_advisory']++;
                } elseif ($project->status === 'Construction') {
                    $projectsByDivision[$division]['construction']++;
                }
                
                $projectsByDivision[$division]['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'status' => $project->status,
                    'category' => $project->category,
                    'cost' => $this->getRawCostValue($project->cost),
                    'cost_display' => $project->cost,
                    'sector' => $project->sector,
                    'description' => $project->overview,
                    'location' => $project->location
                ];
            }
        }
        
        // Prepare data for JSON (to pass to JavaScript)
        $divisionsDataForMap = [];
        foreach ($projectsByDivision as $divisionName => $data) {
            $totalProjectsCount = $data['total'];
            $avgCost = $totalProjectsCount > 0 ? ($data['investment'] / $totalProjectsCount) / 10000000 : 0;
            
            $divisionsDataForMap[$divisionName] = [
                'name' => $divisionName,
                'projects' => [
                    'pipeline' => $data['pipeline'],
                    'ongoing' => $data['ongoing'],
                    'operational' => $data['operational'],
                    'complete' => $data['complete'],
                    'private_partner' => $data['private_partner'],
                    'transaction_advisory' => $data['transaction_advisory'],
                    'construction' => $data['construction']
                ],
                'investment' => $data['investment'],
                'total_projects' => $totalProjectsCount,
                'avg_cost' => $avgCost,
                'projects_list' => array_slice($data['projects'], 0, 10)
            ];
            
            if ($divisionName === 'FATA') {
                $divisionsDataForMap[$divisionName]['is_merged'] = true;
                $divisionsDataForMap[$divisionName]['merged_districts'] = $data['merged_districts'];
            }
        }
        
        // Get sector data for charts
        $sectorCounts = [];
        foreach ($allProjects as $proj) {
            if (!empty($proj->sector)) {
                $sector = ucfirst(strtolower(trim($proj->sector)));
                if (!isset($sectorCounts[$sector])) {
                    $sectorCounts[$sector] = 0;
                }
                $sectorCounts[$sector]++;
            }
        }
        $sectorChartData = $sectorCounts;
        
        // Prepare divisions grid data
        $divisionsGrid = [];
        foreach ($validDivisions as $division) {
            $divisionsGrid[] = [
                'name' => $division,
                'total' => $projectsByDivision[$division]['total'] ?? 0,
                'pipeline' => $projectsByDivision[$division]['pipeline'] ?? 0,
                'ongoing' => $projectsByDivision[$division]['ongoing'] ?? 0,
                'operational' => $projectsByDivision[$division]['operational'] ?? 0,
                'complete' => $projectsByDivision[$division]['complete'] ?? 0,
                'private_partner' => $projectsByDivision[$division]['private_partner'] ?? 0,
                'transaction_advisory' => $projectsByDivision[$division]['transaction_advisory'] ?? 0,
                'construction' => $projectsByDivision[$division]['construction'] ?? 0,
                'investment' => $projectsByDivision[$division]['investment'] ?? 0
            ];
        }
        
        // Add FATA to grid
        $divisionsGrid[] = [
            'name' => 'FATA',
            'total' => $projectsByDivision['FATA']['total'] ?? 0,
            'pipeline' => $projectsByDivision['FATA']['pipeline'] ?? 0,
            'ongoing' => $projectsByDivision['FATA']['ongoing'] ?? 0,
            'operational' => $projectsByDivision['FATA']['operational'] ?? 0,
            'complete' => $projectsByDivision['FATA']['complete'] ?? 0,
            'private_partner' => $projectsByDivision['FATA']['private_partner'] ?? 0,
            'transaction_advisory' => $projectsByDivision['FATA']['transaction_advisory'] ?? 0,
            'construction' => $projectsByDivision['FATA']['construction'] ?? 0,
            'investment' => $projectsByDivision['FATA']['investment'] ?? 0
        ];
        
        // Sort divisions grid by name
        usort($divisionsGrid, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        
        return view('user.projects.projectStats', compact(
            'totalProjects',
            'totalInvestment',
            'pipelineCount',
            'ongoingCount',
            'operationalCount',
            'completeCount',
            'privatePartnerCount',
            'transactionAdvisoryCount',
            'constructionCount',
            'pipelineInvestment',
            'ongoingInvestment',
            'operationalInvestment',
            'completeInvestment',
            'privatePartnerInvestment',
            'transactionAdvisoryInvestment',
            'constructionInvestment',
            'projectsByDivision',
            'sectorChartData',
            'divisionsGrid',
            'divisionsDataForMap'
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
            
            $pipeline = $projects->where('status', 'Pipeline')->count();
            $ongoing = $projects->where('status', 'Ongoing')->count();
            $operational = $projects->where('status', 'Operational')->count();
            $complete = $projects->where('status', 'Complete')->count();
            $privatePartner = $projects->where('status', 'Private Partner Selection')->count();
            $transactionAdvisory = $projects->where('status', 'Transaction Advisory')->count();
            $construction = $projects->where('status', 'Construction')->count();
            
            $investment = 0;
            foreach ($projects as $proj) {
                $investment += $this->getRawCostValue($proj->cost);
            }
            
            $divisionsData[$division] = [
                'name' => $division,
                'projects' => [
                    'pipeline' => $pipeline,
                    'ongoing' => $ongoing,
                    'operational' => $operational,
                    'complete' => $complete,
                    'private_partner' => $privatePartner,
                    'transaction_advisory' => $transactionAdvisory,
                    'construction' => $construction
                ],
                'investment' => (float)$investment,
                'total_projects' => $projects->count(),
                'projects_list' => $projects->map(function($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'status' => $project->status,
                        'category' => $project->category,
                        'cost' => $this->getRawCostValue($project->cost),
                        'cost_display' => $project->cost,
                        'sector' => $project->sector,
                        'description' => $project->overview
                    ];
                })->toArray()
            ];
        }
        
        // Add FATA data
        $fataProjects = Project::where('division', 'FATA')->get();
        $fataInvestment = 0;
        foreach ($fataProjects as $proj) {
            $fataInvestment += $this->getRawCostValue($proj->cost);
        }
        
        $divisionsData['FATA'] = [
            'name' => 'FATA',
            'is_merged' => true,
            'merged_districts' => ['Bajaur', 'Khyber', 'Kurram', 'Mohmand', 'Orakzai', 'North Waziristan', 'South Waziristan'],
            'projects' => [
                'pipeline' => $fataProjects->where('status', 'Pipeline')->count(),
                'ongoing' => $fataProjects->where('status', 'Ongoing')->count(),
                'operational' => $fataProjects->where('status', 'Operational')->count(),
                'complete' => $fataProjects->where('status', 'Complete')->count(),
                'private_partner' => $fataProjects->where('status', 'Private Partner Selection')->count(),
                'transaction_advisory' => $fataProjects->where('status', 'Transaction Advisory')->count(),
                'construction' => $fataProjects->where('status', 'Construction')->count()
            ],
            'investment' => (float)$fataInvestment,
            'total_projects' => $fataProjects->count(),
            'projects_list' => $fataProjects->map(function($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'status' => $project->status,
                    'category' => $project->category,
                    'cost' => $this->getRawCostValue($project->cost),
                    'cost_display' => $project->cost,
                    'sector' => $project->sector,
                    'description' => $project->overview
                ];
            })->toArray()
        ];
        
        return response()->json($divisionsData);
    }
}