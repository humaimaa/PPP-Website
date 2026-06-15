<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Download;

class ResourceController extends Controller
{
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

        // Map URL sections to database category values (EXACT MATCH)
        $categoryMapping = [
            'legal-framework' => 'Legal Framework',
            'pre-qualified-advisors' => 'Prequalified Transaction Advisory',
            'policies-regulations' => 'Policies, Regulations and Guidelines', // Fixed: removed extra space
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
}