<?php

if (!function_exists('createSlug')) {
    function createSlug($text) {
        // Convert all characters to lowercase
        $text = strtolower($text);

        // Replace non-letter or non-digit characters with hyphens
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);

        // Trim hyphens from the beginning and end
        $text = trim($text, '-');

        return $text;
    }
}