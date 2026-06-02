<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\TenderAdditionalDoc;
use Illuminate\Http\Request;

class TenderController extends Controller
{
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
}