<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\OngoingProjectDetail;
use App\Models\CompletedProjectDetail;
use App\Models\Sector; // Add this import
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Convert cost string to numeric value (in PKR)
     */
    private function getRawCostValue($costString)
    {
        if (empty($costString)) return 0;
        if (is_numeric($costString)) return (float)$costString;

        $costString = strtolower(trim($costString));
        preg_match('/([\d,]+\.?\d*)/', $costString, $matches);
        $numericValue = isset($matches[1]) ? (float)str_replace(',', '', $matches[1]) : 0;

        if (strpos($costString, 'billion') !== false) {
            return $numericValue * 1000000000;
        } elseif (strpos($costString, 'million') !== false) {
            return $numericValue * 1000000;
        } elseif (strpos($costString, 'crore') !== false || strpos($costString, 'cr') !== false) {
            return $numericValue * 10000000;
        }
        return $numericValue;
    }

    /**
     * Helper function to get divisions array from project
     */
    private function getProjectDivisions($project)
    {
        if (empty($project->division)) {
            return [];
        }
        
        // If division is stored as JSON
        if ($this->isJson($project->division)) {
            return json_decode($project->division, true) ?? [];
        }
        
        // If division is stored as comma-separated string (SET column)
        return array_map('trim', explode(',', $project->division));
    }
    
    /**
     * Check if string is JSON
     */
    private function isJson($string)
    {
        if (!is_string($string)) return false;
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Display projects with category, status, and sector filters
     */
    public function index($category = 'all', $status = 'all')
    {
        // Allowed slugs – must match route constraints AND your view's dropdown values
        $validCategories = ['all', 'pipeline', 'ongoing', 'construction-operational'];
        $validStatuses = ['all', 'private-partner', 'transaction-advisory', 'construction', 'operational'];

        // Validate and sanitize inputs
        if (!in_array($category, $validCategories)) $category = 'all';
        if (!in_array($status, $validStatuses)) $status = 'all';
        
        // Get sector from query parameter
        $sectorFilter = request()->query('sector');
        $sectorData = null;
        
        // If sector filter is applied, get the sector data
        if ($sectorFilter) {
            $sectorData = Sector::where('name', $sectorFilter)->first();
        }

        $query = Project::query();

        // ---- Category filter (slug → DB value) ----
        if ($category !== 'all') {
            switch ($category) {
                case 'pipeline':
                    $query->where('category', 'Pipeline');
                    break;
                case 'ongoing':
                    $query->where('category', 'Ongoing');
                    break;
                case 'construction-operational':
                    $query->where('category', 'Construction & Operational');
                    break;
                default:
                    $query->where('category', $category);
            }
        }

        // ---- Status filter (slug → DB value) ----
        if ($status !== 'all') {
            switch ($status) {
                case 'private-partner':
                    $query->where('status', 'Private Partner Selection');
                    break;
                case 'transaction-advisory':
                    $query->where('status', 'Transaction Advisory');
                    break;
                case 'construction':
                    $query->where('status', 'Construction');
                    break;
                case 'operational':
                    $query->where('status', 'Operational');
                    break;
                default:
                    $query->where('status', $status);
            }
        }

        // ---- Sector filter ----
        if ($sectorFilter) {
            $query->where('sector', $sectorFilter);
        }

        // ---- Custom ordering: Ongoing first, then Pipeline, then Construction & Operational ----
        // Paginate results (9 per page)
        $projects = $query->orderByRaw("FIELD(category, 'Ongoing', 'Pipeline', 'Construction & Operational') ASC")
                          ->orderBy('created_at', 'desc')   // secondary sort within each category
                          ->paginate(9);

        // ---- Statistics (optional) ----
        $allProjects = Project::all();
        $totalInvestmentRaw = 0;
        foreach ($allProjects as $project) {
            $totalInvestmentRaw += $this->getRawCostValue($project->cost);
        }

        $stats = [
            'pipeline' => Project::where('category', 'Pipeline')->count(),
            'ongoing'  => Project::where('category', 'Ongoing')->count(),
            'construction_operational' => Project::where('category', 'Construction & Operational')->count(),
            'private_partner'     => Project::where('status', 'Private Partner Selection')->count(),
            'transaction_advisory'=> Project::where('status', 'Transaction Advisory')->count(),
            'construction'        => Project::where('status', 'Construction')->count(),
            'operational'         => Project::where('status', 'Operational')->count(),
            'total_investment'    => $totalInvestmentRaw,
            'total_projects'      => $allProjects->count()
        ];

        return view('user.projects.index', compact('projects', 'category', 'status', 'stats', 'sectorFilter', 'sectorData'));
    }

    /**
     * Display projects filtered by sector
     */
    public function indexBySector($sector)
    {
        // Get sector data
        $sectorData = Sector::where('name', $sector)->first();
        
        $query = Project::query();
        
        // Filter by sector
        $query->where('sector', $sector);
        
        // ---- Custom ordering: Ongoing first, then Pipeline, then Construction & Operational ----
        // Paginate results (9 per page)
        $projects = $query->orderByRaw("FIELD(category, 'Ongoing', 'Pipeline', 'Construction & Operational') ASC")
                          ->orderBy('created_at', 'desc')
                          ->paginate(9);
        
        // Get statistics for this sector
        $allProjects = Project::all();
        $totalInvestmentRaw = 0;
        foreach ($allProjects as $project) {
            $totalInvestmentRaw += $this->getRawCostValue($project->cost);
        }
        
        $stats = [
            'pipeline' => Project::where('category', 'Pipeline')->count(),
            'ongoing'  => Project::where('category', 'Ongoing')->count(),
            'construction_operational' => Project::where('category', 'Construction & Operational')->count(),
            'private_partner'     => Project::where('status', 'Private Partner Selection')->count(),
            'transaction_advisory'=> Project::where('status', 'Transaction Advisory')->count(),
            'construction'        => Project::where('status', 'Construction')->count(),
            'operational'         => Project::where('status', 'Operational')->count(),
            'total_investment'    => $totalInvestmentRaw,
            'total_projects'      => $allProjects->count()
        ];
        
        // Pass sector filter to view
        $sectorFilter = $sector;
        $category = 'all';
        $status = 'all';
        
        return view('user.projects.index', compact('projects', 'category', 'status', 'stats', 'sectorFilter', 'sectorData'));
    }

    /**
     * Show a single project
     */
    public function show(Project $project)
{
    $pipelineDetails = null;
    $ongoingDetails = null;
    $completedDetails = null;
    $achievements = [];

    if ($project->category === 'Pipeline') {
        $pipelineDetails = $project->pipelineDetail;
    } elseif ($project->category === 'Ongoing') {
        $ongoingDetails = OngoingProjectDetail::where('project_id', $project->id)->first();
    } elseif ($project->category === 'Construction & Operational') {
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
        
        // Get counts by category
        $pipelineCount = Project::where('category', 'Pipeline')->count();
        $ongoingCount = Project::where('category', 'Ongoing')->count();
        $completedCount = Project::where('category', 'Construction & Operational')->count();
        
        // Get counts by status
        $privatePartnerCount = Project::where('status', 'Private Partner Selection')->count();
        $transactionAdvisoryCount = Project::where('status', 'Transaction Advisory')->count();
        $constructionCount = Project::where('status', 'Construction')->count();
        $operationalCount = Project::where('status', 'Operational')->count();
        
        // Get investment by category
        $pipelineInvestmentRaw = 0;
        $ongoingInvestmentRaw = 0;
        $completedInvestmentRaw = 0;
        
        foreach (Project::where('category', 'Pipeline')->get() as $proj) {
            $pipelineInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('category', 'Ongoing')->get() as $proj) {
            $ongoingInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('category', 'Construction & Operational')->get() as $proj) {
            $completedInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        
        $pipelineInvestment = $pipelineInvestmentRaw;
        $ongoingInvestment = $ongoingInvestmentRaw;
        $completedInvestment = $completedInvestmentRaw;
        
        // Define valid divisions
        $validDivisions = ['Peshawar', 'Mardan', 'Kohat', 'Bannu', 'Dera Ismail Khan', 'Malakand', 'Hazara'];
        
        // Initialize all divisions with zero values
        $projectsByDivision = [];
        foreach ($validDivisions as $division) {
            $projectsByDivision[$division] = [
                'total' => 0,
                'pipeline' => 0,
                'ongoing' => 0,
                'completed' => 0,
                'private_partner' => 0,
                'transaction_advisory' => 0,
                'construction' => 0,
                'operational' => 0,
                'investment' => 0,
                'projects' => []
            ];
        }
        
        // Add FATA as merged districts
        $projectsByDivision['FATA'] = [
            'total' => 0,
            'pipeline' => 0,
            'ongoing' => 0,
            'completed' => 0,
            'private_partner' => 0,
            'transaction_advisory' => 0,
            'construction' => 0,
            'operational' => 0,
            'investment' => 0,
            'projects' => [],
            'is_merged' => true,
            'merged_districts' => ['Bajaur', 'Khyber', 'Kurram', 'Mohmand', 'Orakzai', 'North Waziristan', 'South Waziristan']
        ];
        
        // Populate with actual data from database - handle multiple divisions
        foreach ($allProjects as $project) {
            // Get all divisions for this project
            $divisions = $this->getProjectDivisions($project);
            
            // If no divisions, skip
            if (empty($divisions)) continue;
            
            // For each division, add the project data
            foreach ($divisions as $division) {
                // Check if division exists in our data structure
                if (!isset($projectsByDivision[$division])) continue;
                
                $projectsByDivision[$division]['total']++;
                $projectsByDivision[$division]['investment'] += $this->getRawCostValue($project->cost);
                
                // Categorize by category
                if ($project->category === 'Pipeline') {
                    $projectsByDivision[$division]['pipeline']++;
                } elseif ($project->category === 'Ongoing') {
                    $projectsByDivision[$division]['ongoing']++;
                } elseif ($project->category === 'Construction & Operational') {
                    $projectsByDivision[$division]['completed']++;
                }
                
                // Categorize by status
                if ($project->status === 'Private Partner Selection') {
                    $projectsByDivision[$division]['private_partner']++;
                } elseif ($project->status === 'Transaction Advisory') {
                    $projectsByDivision[$division]['transaction_advisory']++;
                } elseif ($project->status === 'Construction') {
                    $projectsByDivision[$division]['construction']++;
                } elseif ($project->status === 'Operational') {
                    $projectsByDivision[$division]['operational']++;
                }
                
                // Add project to division's project list (avoid duplicates)
                $projectExists = false;
                foreach ($projectsByDivision[$division]['projects'] as $existingProject) {
                    if ($existingProject['id'] === $project->id) {
                        $projectExists = true;
                        break;
                    }
                }
                
                if (!$projectExists) {
                    $projectsByDivision[$division]['projects'][] = [
                        'id' => $project->id,
                        'name' => $project->name,
                        'category' => $project->category,
                        'status' => $project->status,
                        'cost' => $this->getRawCostValue($project->cost),
                        'cost_display' => $project->cost,
                        'sector' => $project->sector,
                        'description' => $project->overview,
                        'location' => $project->location
                    ];
                }
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
                    'completed' => $data['completed'],
                    'private_partner' => $data['private_partner'],
                    'transaction_advisory' => $data['transaction_advisory'],
                    'construction' => $data['construction'],
                    'operational' => $data['operational']
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
                'completed' => $projectsByDivision[$division]['completed'] ?? 0,
                'private_partner' => $projectsByDivision[$division]['private_partner'] ?? 0,
                'transaction_advisory' => $projectsByDivision[$division]['transaction_advisory'] ?? 0,
                'construction' => $projectsByDivision[$division]['construction'] ?? 0,
                'operational' => $projectsByDivision[$division]['operational'] ?? 0,
                'investment' => $projectsByDivision[$division]['investment'] ?? 0
            ];
        }
        
        // Add FATA to grid
        $divisionsGrid[] = [
            'name' => 'FATA',
            'total' => $projectsByDivision['FATA']['total'] ?? 0,
            'pipeline' => $projectsByDivision['FATA']['pipeline'] ?? 0,
            'ongoing' => $projectsByDivision['FATA']['ongoing'] ?? 0,
            'completed' => $projectsByDivision['FATA']['completed'] ?? 0,
            'private_partner' => $projectsByDivision['FATA']['private_partner'] ?? 0,
            'transaction_advisory' => $projectsByDivision['FATA']['transaction_advisory'] ?? 0,
            'construction' => $projectsByDivision['FATA']['construction'] ?? 0,
            'operational' => $projectsByDivision['FATA']['operational'] ?? 0,
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
            'completedCount',
            'privatePartnerCount',
            'transactionAdvisoryCount',
            'constructionCount',
            'operationalCount',
            'pipelineInvestment',
            'ongoingInvestment',
            'completedInvestment',
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
        $allProjects = Project::all();
        
        $divisionsData = [];
        
        foreach ($validDivisions as $division) {
            // Find projects that belong to this division
            $projects = [];
            foreach ($allProjects as $project) {
                $divisions = $this->getProjectDivisions($project);
                if (in_array($division, $divisions)) {
                    $projects[] = $project;
                }
            }
            
            $pipeline = 0;
            $ongoing = 0;
            $completed = 0;
            $privatePartner = 0;
            $transactionAdvisory = 0;
            $construction = 0;
            $operational = 0;
            $investment = 0;
            
            foreach ($projects as $proj) {
                if ($proj->category === 'Pipeline') $pipeline++;
                elseif ($proj->category === 'Ongoing') $ongoing++;
                elseif ($proj->category === 'Construction & Operational') $completed++;
                
                if ($proj->status === 'Private Partner Selection') $privatePartner++;
                elseif ($proj->status === 'Transaction Advisory') $transactionAdvisory++;
                elseif ($proj->status === 'Construction') $construction++;
                elseif ($proj->status === 'Operational') $operational++;
                
                $investment += $this->getRawCostValue($proj->cost);
            }
            
            $divisionsData[$division] = [
                'name' => $division,
                'projects' => [
                    'pipeline' => $pipeline,
                    'ongoing' => $ongoing,
                    'completed' => $completed,
                    'private_partner' => $privatePartner,
                    'transaction_advisory' => $transactionAdvisory,
                    'construction' => $construction,
                    'operational' => $operational
                ],
                'investment' => (float)$investment,
                'total_projects' => count($projects),
                'projects_list' => array_map(function($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'category' => $project->category,
                        'status' => $project->status,
                        'cost' => $this->getRawCostValue($project->cost),
                        'cost_display' => $project->cost,
                        'sector' => $project->sector,
                        'description' => $project->overview,
                        'location' => $project->location
                    ];
                }, $projects)
            ];
        }
        
        // Add FATA data
        $fataProjects = [];
        foreach ($allProjects as $project) {
            $divisions = $this->getProjectDivisions($project);
            if (in_array('FATA', $divisions)) {
                $fataProjects[] = $project;
            }
        }
        
        $fataInvestment = 0;
        foreach ($fataProjects as $proj) {
            $fataInvestment += $this->getRawCostValue($proj->cost);
        }
        
        $fataPipeline = 0;
        $fataOngoing = 0;
        $fataCompleted = 0;
        $fataPrivatePartner = 0;
        $fataTransactionAdvisory = 0;
        $fataConstruction = 0;
        $fataOperational = 0;
        
        foreach ($fataProjects as $proj) {
            if ($proj->category === 'Pipeline') $fataPipeline++;
            elseif ($proj->category === 'Ongoing') $fataOngoing++;
            elseif ($proj->category === 'Construction & Operational') $fataCompleted++;
            
            if ($proj->status === 'Private Partner Selection') $fataPrivatePartner++;
            elseif ($proj->status === 'Transaction Advisory') $fataTransactionAdvisory++;
            elseif ($proj->status === 'Construction') $fataConstruction++;
            elseif ($proj->status === 'Operational') $fataOperational++;
        }
        
        $divisionsData['FATA'] = [
            'name' => 'FATA',
            'is_merged' => true,
            'merged_districts' => ['Bajaur', 'Khyber', 'Kurram', 'Mohmand', 'Orakzai', 'North Waziristan', 'South Waziristan'],
            'projects' => [
                'pipeline' => $fataPipeline,
                'ongoing' => $fataOngoing,
                'completed' => $fataCompleted,
                'private_partner' => $fataPrivatePartner,
                'transaction_advisory' => $fataTransactionAdvisory,
                'construction' => $fataConstruction,
                'operational' => $fataOperational
            ],
            'investment' => (float)$fataInvestment,
            'total_projects' => count($fataProjects),
            'projects_list' => array_map(function($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'category' => $project->category,
                    'status' => $project->status,
                    'cost' => $this->getRawCostValue($project->cost),
                    'cost_display' => $project->cost,
                    'sector' => $project->sector,
                    'description' => $project->overview,
                    'location' => $project->location
                ];
            }, $fataProjects)
        ];
        
        return response()->json($divisionsData);
    }
}