<?php

// Get all blade files with x-app-layout
function getAllBladeFiles($dir) {
    $files = [];
    $it = new RecursiveDirectoryIterator($dir);
    foreach (new RecursiveIteratorIterator($it) as $file) {
        if ($file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
            $files[] = $file->getPathname();
        }
    }
    return $files;
}

$files = getAllBladeFiles('resources/views');

$fixed = 0;
$failed = [];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Only process files that have x-app-layout
    if (strpos($content, '<x-app-layout>') === false) {
        continue;
    }
    
    // Fix: Replace </x-slot> followed by extra whitespace and content with proper formatting
    // Pattern: </x-slot> followed by newlines/spaces then <div or other tags
    $original = $content;
    
    // Replace multiple newlines after </x-slot> with exactly one newline and proper indentation
    $content = preg_replace(
        '/(<\/x-slot>)\s*\n\s*\n\s*(<div|<form|<section|<main|\{|\@|<table)/m',
        '$1' . "\n\n    " . '$2',
        $content
    );
    
    if ($original !== $content) {
        file_put_contents($file, $content);
        $fixed++;
        echo "✓ Fixed indentation: $file\n";
    }
}

echo "\n=== Whitespace Fix Summary ===\n";
echo "Fixed: $fixed files\n";
