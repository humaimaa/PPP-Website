<?php

if (!function_exists('formatTitle')) {
    /**
     * Format title by uppercasing specific keywords
     * 
     * @param string|null $text
     * @return string|null
     */
    function formatTitle($text)
    {
        if (empty($text)) {
            return $text;
        }
        
        $keywords = ['ppp', 'kp' ,'kpha', 'ifm', 'arr', 'ii', 'di','itz'];
        $formattedText = $text;
        
        foreach ($keywords as $keyword) {
            $formattedText = str_ireplace($keyword, strtoupper($keyword), $formattedText);
        }
        
        return $formattedText;
    }
}