<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * Tenders page with optional section parameter and status filter
     */
    public function tenders(Request $request, $section = 'general-procurement')
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
        
        // Get status filter from request (default to 'active')
        $status = $request->get('status', 'active');
        
        // Fetch tenders based on status with pagination
        $query = Tender::where('category', $category)
            ->orderBy('closing_date', 'desc')
            ->with('additionalDocs'); // Eager load additional docs
        
        if ($status === 'active') {
            // Active: effective closing date is today or in future
            $query->where(function($q) {
                $q->whereDate('closing_date', '>=', now())
                  ->orWhereDate('extended_closing_date', '>=', now());
            });
        } elseif ($status === 'archived') {
            // Archived: effective closing date is in the past
            $query->where(function($q) {
                $q->whereDate('closing_date', '<', now())
                  ->where(function($sub) {
                      $sub->whereNull('extended_closing_date')
                          ->orWhereDate('extended_closing_date', '<', now());
                  });
            });
        }
        
        // Use paginate() to get a Paginator instance
        $tenders = $query->paginate(10);
        
        return view('user.tenders', compact('section', 'tenders', 'status', 'category'));
    }
}