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
     * Helper function to convert cost string to numeric value in PKR (actual rupees)
     * Handles various formats: "34 billion", "34B", "34 B", "34 million", "34M", "34 M", 
     * "34 crore", "34 Cr", "34cr", "34", "34,00,00,000", etc.
     */
    private function getRawCostValue($costString)
    {
        if (empty($costString)) return 0;
        
        // If it's already numeric
        if (is_numeric($costString)) {
            return (float)$costString;
        }
        
        $costString = strtolower(trim($costString));
        
        // Extract numeric value (handles commas and spaces)
        preg_match('/([\d,]+\.?\d*)/', $costString, $matches);
        $numericValue = isset($matches[1]) ? (float)str_replace(',', '', $matches[1]) : 0;
        
        // Check for billion (1 Billion = 1,000,000,000)
        if (strpos($costString, 'billion') !== false || strpos($costString, 'b') === 0 || 
            (strpos($costString, 'b') !== false && strlen($costString) < 5)) {
            // Check if it's like "34B" or "34 B"
            if (preg_match('/(\d+)\s*b$/i', $costString) || preg_match('/(\d+)\s*billion/i', $costString)) {
                return $numericValue * 1000000000;
            }
            if (strpos($costString, 'b') !== false && !strpos($costString, 'billion')) {
                return $numericValue * 1000000000;
            }
            return $numericValue * 1000000000;
        }
        // Check for million (1 Million = 1,000,000)
        elseif (strpos($costString, 'million') !== false || strpos($costString, 'm') === 0 ||
            (strpos($costString, 'm') !== false && strlen($costString) < 5)) {
            if (preg_match('/(\d+)\s*m$/i', $costString) || preg_match('/(\d+)\s*million/i', $costString)) {
                return $numericValue * 1000000;
            }
            if (strpos($costString, 'm') !== false && !strpos($costString, 'million')) {
                return $numericValue * 1000000;
            }
            return $numericValue * 1000000;
        }
        // Check for crore (1 Crore = 10,000,000)
        elseif (strpos($costString, 'crore') !== false || strpos($costString, 'cr') !== false) {
            return $numericValue * 10000000;
        }
        // Check for lakh (1 Lakh = 100,000)
        elseif (strpos($costString, 'lakh') !== false || strpos($costString, 'lac') !== false) {
            return $numericValue * 100000;
        }
        // Assume it's in rupees
        else {
            return $numericValue;
        }
    }
    
    /**
     * Helper function to format cost for display
     */
    private function formatCostForDisplay($costString)
    {
        if (empty($costString)) return 'N/A';
        
        // If it's already a formatted string, return as is
        if (!is_numeric($costString) && (strpos($costString, 'billion') !== false || 
            strpos($costString, 'million') !== false || 
            strpos($costString, 'crore') !== false ||
            strpos($costString, 'lakh') !== false)) {
            return ucfirst($costString);
        }
        
        // Get raw value and format
        $rawValue = $this->getRawCostValue($costString);
        
        if ($rawValue >= 1000000000) {
            return number_format($rawValue / 1000000000, 2) . ' Billion';
        } elseif ($rawValue >= 10000000) {
            return number_format($rawValue / 10000000, 2) . ' Crore';
        } elseif ($rawValue >= 1000000) {
            return number_format($rawValue / 1000000, 2) . ' Million';
        } elseif ($rawValue >= 100000) {
            return number_format($rawValue / 100000, 2) . ' Lakh';
        } else {
            return number_format($rawValue) . ' PKR';
        }
    }
    
    /**
     * Helper function to get cost in crores for display in cards
     */
    private function getCostInCrores($costString)
    {
        $rawValue = $this->getRawCostValue($costString);
        return $rawValue / 10000000;
    }

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
        
        // Get statistics with proper cost conversion
        $allProjects = Project::all();
        $totalInvestmentRaw = 0;
        
        foreach ($allProjects as $project) {
            $totalInvestmentRaw += $this->getRawCostValue($project->cost);
        }
        
        $stats = [
            'pipeline' => Project::where('category', 'pipeline')->count(),
            'ongoing' => Project::where('category', 'ongoing')->count(),
            'completed' => Project::where('category', 'completed')->count(),
            'total_investment' => $totalInvestmentRaw
        ];
        
        return view('user.projects.index', compact('projects', 'status', 'stats'));
    }

    /**
     * Project show page
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        
        $pipelineDetails = null;
        $ongoingDetails = null;
        $completedDetails = null;
        $achievements = [];
        
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
        
        // Calculate total investment properly from cost strings
        $allProjectsForInvestment = Project::all();
        $totalInvestmentRaw = 0;
        foreach ($allProjectsForInvestment as $proj) {
            $totalInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        $totalInvestment = $totalInvestmentRaw;
        
        // Get counts by category
        $pipelineCount = Project::where('category', 'pipeline')->count();
        $ongoingCount = Project::where('category', 'ongoing')->count();
        $completedCount = Project::where('category', 'completed')->count();
        
        // Get investment by category with proper conversion
        $pipelineInvestmentRaw = 0;
        $ongoingInvestmentRaw = 0;
        $completedInvestmentRaw = 0;
        
        foreach (Project::where('category', 'pipeline')->get() as $proj) {
            $pipelineInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('category', 'ongoing')->get() as $proj) {
            $ongoingInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        foreach (Project::where('category', 'completed')->get() as $proj) {
            $completedInvestmentRaw += $this->getRawCostValue($proj->cost);
        }
        
        $pipelineInvestment = $pipelineInvestmentRaw;
        $ongoingInvestment = $ongoingInvestmentRaw;
        $completedInvestment = $completedInvestmentRaw;
        
        // Get projects by division from database
        $validDivisions = ['Peshawar', 'Mardan', 'Kohat', 'Bannu', 'Dera Ismail Khan', 'Malakand', 'Hazara'];
        
        // Initialize all divisions with zero values
        $projectsByDivision = [];
        foreach ($validDivisions as $division) {
            $projectsByDivision[$division] = [
                'total' => 0,
                'pipeline' => 0,
                'ongoing' => 0,
                'completed' => 0,
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
            
            // Normalize division name
            $normalizedDivision = $division;
            if ($division === 'Dera Ismail Khan') {
                $normalizedDivision = 'Dera Ismail Khan';
            }
            
            if ($normalizedDivision && isset($projectsByDivision[$normalizedDivision])) {
                $projectsByDivision[$normalizedDivision]['total']++;
                $projectsByDivision[$normalizedDivision]['investment'] += $this->getRawCostValue($project->cost);
                
                // Categorize by status
                if ($project->category === 'ongoing') {
                    $projectsByDivision[$normalizedDivision]['ongoing']++;
                } elseif ($project->category === 'completed') {
                    $projectsByDivision[$normalizedDivision]['completed']++;
                } elseif ($project->category === 'pipeline') {
                    $projectsByDivision[$normalizedDivision]['pipeline']++;
                }
                
                $projectsByDivision[$normalizedDivision]['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'category' => $project->category,
                    'cost_raw' => $this->getRawCostValue($project->cost),
                    'cost_display' => $this->formatCostForDisplay($project->cost),
                    'cost_original' => $project->cost,
                    'sector' => $project->sector,
                    'description' => $project->overview ?? $project->description ?? null,
                    'location' => $project->location,
                    'status' => $project->status
                ];
            } elseif ($normalizedDivision === 'FATA' && isset($projectsByDivision['FATA'])) {
                $projectsByDivision['FATA']['total']++;
                $projectsByDivision['FATA']['investment'] += $this->getRawCostValue($project->cost);
                
                if ($project->category === 'ongoing') {
                    $projectsByDivision['FATA']['ongoing']++;
                } elseif ($project->category === 'completed') {
                    $projectsByDivision['FATA']['completed']++;
                } elseif ($project->category === 'pipeline') {
                    $projectsByDivision['FATA']['pipeline']++;
                }
                
                $projectsByDivision['FATA']['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'category' => $project->category,
                    'cost_raw' => $this->getRawCostValue($project->cost),
                    'cost_display' => $this->formatCostForDisplay($project->cost),
                    'cost_original' => $project->cost,
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
                $avgCost = $totalProjectsCount > 0 ? ($data['investment'] / $totalProjectsCount) / 10000000 : 0;
                
                $divisionsDataForMap[$divisionName] = [
                    'name' => $divisionName,
                    'projects' => [
                        'pipeline' => $data['pipeline'],
                        'ongoing' => $data['ongoing'],
                        'completed' => $data['completed']
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
                        'pipeline' => $data['pipeline'],
                        'ongoing' => $data['ongoing'],
                        'completed' => $data['completed']
                    ],
                    'investment' => $data['investment'],
                    'total_projects' => $data['total'],
                    'avg_cost' => $data['total'] > 0 ? ($data['investment'] / $data['total']) / 10000000 : 0,
                    'projects_list' => array_slice($data['projects'], 0, 10)
                ];
            }
        }
        
        // Get sector data for charts
        $sectorCounts = [];
        $allProjs = Project::whereNotNull('sector')->where('sector', '!=', '')->get();
        foreach ($allProjs as $proj) {
            $sector = trim($proj->sector);
            if (!empty($sector)) {
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
                'investment' => $projectsByDivision[$division]['investment'] ?? 0
            ];
        }
        
        // Add FATA to grid
        $divisionsGrid[] = [
            'name' => 'FATA (Merged Districts)',
            'total' => $projectsByDivision['FATA']['total'] ?? 0,
            'pipeline' => $projectsByDivision['FATA']['pipeline'] ?? 0,
            'ongoing' => $projectsByDivision['FATA']['ongoing'] ?? 0,
            'completed' => $projectsByDivision['FATA']['completed'] ?? 0,
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
            
            $pipeline = $projects->where('category', 'pipeline')->count();
            $ongoing = $projects->where('category', 'ongoing')->count();
            $completed = $projects->where('category', 'completed')->count();
            $investment = 0;
            foreach ($projects as $proj) {
                $investment += $this->getRawCostValue($proj->cost);
            }
            
            $divisionsData[$division] = [
                'name' => $division,
                'projects' => [
                    'pipeline' => $pipeline,
                    'ongoing' => $ongoing,
                    'completed' => $completed
                ],
                'investment' => (float)$investment,
                'total_projects' => $projects->count(),
                'projects_list' => $projects->map(function($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'category' => $project->category,
                        'cost_raw' => $this->getRawCostValue($project->cost),
                        'cost_display' => $this->formatCostForDisplay($project->cost),
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
                'pipeline' => $fataProjects->where('category', 'pipeline')->count(),
                'ongoing' => $fataProjects->where('category', 'ongoing')->count(),
                'completed' => $fataProjects->where('category', 'completed')->count()
            ],
            'investment' => (float)$fataInvestment,
            'total_projects' => $fataProjects->count(),
            'projects_list' => $fataProjects->map(function($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'category' => $project->category,
                    'cost_raw' => $this->getRawCostValue($project->cost),
                    'cost_display' => $this->formatCostForDisplay($project->cost),
                    'sector' => $project->sector,
                    'description' => $project->overview
                ];
            })->toArray()
        ];
        
        return response()->json($divisionsData);
    }
}