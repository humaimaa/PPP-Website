<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Tender;
use App\Models\Event;
use App\Models\News;
use App\Models\Download;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards Data
        $totalProjects = Project::count();
        
        // Get open tenders using effective closing date (extended if exists)
        $openTenders = Tender::whereRaw('COALESCE(extended_closing_date, closing_date) >= ?', [now()])
            ->where('opening_date', '<=', now())
            ->count();
            
        $newsItems = News::count();
        $publicDocuments = Download::count();
        $totalEvents = Event::count();
        $teamMembers = Team::count();
        $totalUsers = User::count();
        
        // Get upcoming tenders (closing soon using effective closing date)
        $upcomingTenders = Tender::whereRaw('COALESCE(extended_closing_date, closing_date) >= ?', [now()])
            ->whereRaw('COALESCE(extended_closing_date, closing_date) <= ?', [now()->addDays(30)])
            ->orderByRaw('COALESCE(extended_closing_date, closing_date) asc')
            ->limit(5)
            ->get();
        
        // Get recent events
        $recentEvents = Event::with('gallery')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Get recent news
        $recentNews = News::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Get recent documents
        $recentDocuments = Download::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Get recent projects
        $recentProjects = Project::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Get recent tenders (all for activity)
        $latestTenders = Tender::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Combine recent activities
        $recentActivities = collect();
        
        // Add recent tenders
        foreach ($latestTenders as $tender) {
            $recentActivities->push((object)[
                'type' => 'tender',
                'title' => $tender->name,
                'action' => $tender->created_at->diffForHumans(),
                'time' => $tender->created_at,
                'icon' => 'file-signature',
                'icon_color' => 'blue',
                'link' => route('admin.tenders.show', $tender),
                'status' => $tender->status,
            ]);
        }
        
        // Add recent events
        foreach ($recentEvents as $event) {
            $recentActivities->push((object)[
                'type' => 'event',
                'title' => $event->title,
                'action' => 'New event added',
                'time' => $event->created_at,
                'icon' => 'calendar-alt',
                'icon_color' => 'green',
                'link' => route('admin.events.show', $event),
                'location' => $event->location,
            ]);
        }
        
        // Add recent news
        foreach ($recentNews as $news) {
            $recentActivities->push((object)[
                'type' => 'news',
                'title' => $news->title,
                'action' => 'News published',
                'time' => $news->created_at,
                'icon' => 'newspaper',
                'icon_color' => 'yellow',
                'link' => '#',
                'type_badge' => $news->type,
            ]);
        }
        
        // Add recent documents
        foreach ($recentDocuments as $doc) {
            $recentActivities->push((object)[
                'type' => 'document',
                'title' => $doc->title,
                'action' => 'Document uploaded',
                'time' => $doc->created_at,
                'icon' => 'folder-open',
                'icon_color' => 'purple',
                'link' => route('admin.downloads.edit', $doc),
                'category' => $doc->category,
            ]);
        }
        
        // Add recent projects
        foreach ($recentProjects as $project) {
            $recentActivities->push((object)[
                'type' => 'project',
                'title' => $project->name,
                'action' => 'Project added',
                'time' => $project->created_at,
                'icon' => 'project-diagram',
                'icon_color' => 'emerald',
                'link' => route('admin.projects.show', $project),
                'status' => $project->status,
            ]);
        }
        
        // Sort activities by time (most recent first)
        $recentActivities = $recentActivities->sortByDesc('time')->take(10);
        
        // Get statistics by month for chart (last 6 months)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M Y');
            
            $monthlyStats[$monthName] = [
                'projects' => Project::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'tenders' => Tender::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'events' => Event::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'documents' => Download::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }
        
        // Get category distribution for documents
        $documentCategories = Download::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();
        
        // Get project status distribution
        $projectStatuses = Project::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalProjects',
            'openTenders',
            'newsItems',
            'publicDocuments',
            'totalEvents',
            'teamMembers',
            'totalUsers',
            'recentActivities',
            'monthlyStats',
            'upcomingTenders',
            'documentCategories',
            'projectStatuses'
        ));
    }
}