<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
        $completedCount = Project::where('category', 'Completed')->count();
        
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
        foreach (Project::where('category', 'Completed')->get() as $proj) {
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
        
        // Populate with actual data from database
        foreach ($allProjects as $project) {
            $division = $project->division;
            
            if ($division && isset($projectsByDivision[$division])) {
                $projectsByDivision[$division]['total']++;
                $projectsByDivision[$division]['investment'] += $this->getRawCostValue($project->cost);
                
                // Categorize by category
                if ($project->category === 'Ongoing') {
                    $projectsByDivision[$division]['active']++;
                } elseif ($project->category === 'Completed') {
                    $projectsByDivision[$division]['completed']++;
                } elseif ($project->category === 'Pipeline') {
                    $projectsByDivision[$division]['planned']++;
                }
                
                $projectsByDivision[$division]['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'category' => $project->category,
                    'cost' => $this->getRawCostValue($project->cost),
                    'cost_display' => $project->cost,
                    'sector' => $project->sector,
                    'description' => $project->overview,
                    'location' => $project->location,
                    'status' => $project->status
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
                    'pipeline' => $data['planned'],
                    'ongoing' => $data['active'],
                    'completed' => $data['completed']
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
                'pipeline' => $projectsByDivision[$division]['planned'] ?? 0,
                'ongoing' => $projectsByDivision[$division]['active'] ?? 0,
                'completed' => $projectsByDivision[$division]['completed'] ?? 0,
                'investment' => $projectsByDivision[$division]['investment'] ?? 0
            ];
        }
        
        // Add FATA to grid
        $divisionsGrid[] = [
            'name' => 'FATA',
            'total' => $projectsByDivision['FATA']['total'] ?? 0,
            'pipeline' => $projectsByDivision['FATA']['planned'] ?? 0,
            'ongoing' => $projectsByDivision['FATA']['active'] ?? 0,
            'completed' => $projectsByDivision['FATA']['completed'] ?? 0,
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
            'pipelineInvestment',
            'ongoingInvestment',
            'completedInvestment',
            'projectsByDivision',
            'sectorChartData',
            'divisionsGrid',
            'divisionsDataForMap'
        ));
    }
}