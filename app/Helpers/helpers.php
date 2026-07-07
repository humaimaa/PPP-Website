<?php

use App\Models\Acronym;
use Illuminate\Support\Facades\Cache;

if (!function_exists('formatTitle')) {
    /**
     * Format title by uppercasing acronyms from database
     * 
     * @param string|null $text
     * @return string|null
     */
    function formatTitle($text)
    {
        if (empty($text)) {
            return $text;
        }
        
        // Get acronyms from database with caching (24 hours)
        try {
            $acronyms = Cache::remember('acronyms_list', 86400, function () {
                return Acronym::pluck('acronym')->toArray();
            });
            
            // Convert to lowercase for case-insensitive matching
            $acronyms = array_map('strtolower', $acronyms);
            
            // Remove duplicates
            $acronyms = array_unique($acronyms);
            
            // Sort by length descending to handle multi-word acronyms correctly
            usort($acronyms, function($a, $b) {
                return strlen($b) - strlen($a);
            });
        } catch (\Exception $e) {
            // If database query fails, return original text
            return $text;
        }
        
        $formattedText = $text;
        
        foreach ($acronyms as $acronym) {
            // Using word boundaries for exact matches
            $pattern = '/\b' . preg_quote($acronym, '/') . '\b/i';
            $formattedText = preg_replace($pattern, strtoupper($acronym), $formattedText);
        }
        
        return $formattedText;
    }
}