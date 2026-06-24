<?php

if (!function_exists('formatTitle')) {
    function formatTitle($text) {
        if (!$text) return $text;
        
        $keywords = ['ppp', 'kp'];
        foreach ($keywords as $keyword) {
            $text = str_ireplace($keyword, strtoupper($keyword), $text);
        }
        return $text;
    }
}