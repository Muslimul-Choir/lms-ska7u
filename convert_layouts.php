<?php
/**
 * Script untuk convert x-app-layout component ke @extends(@section format
 * Usage: php convert_layouts.php
 */

$viewsPath = __DIR__ . '/resources/views';
$convertedCount = 0;

function convertFile($filePath) {
    $content = file_get_contents($filePath);
    
    // Check if file uses x-app-layout
    if (strpos($content, '<x-app-layout>') === false) {
        return false;
    }
    
    // Extract header slot content
    preg_match('/<x-slot\s+name="header">(.*?)<\/x-slot>/s', $content, $headerMatch);
    $headerContent = $headerMatch[1] ?? '';
    
    // Extract main content (between closing header slot and closing x-app-layout)
    preg_match('/<\/x-slot>(.*?)<\/x-app-layout>/s', $content, $mainMatch);
    $mainContent = trim($mainMatch[1] ?? '');
    
    // Remove the old structure
    $content = preg_replace('/<x-app-layout>.*?<\/x-app-layout>/s', '', $content);
    
    // Build new structure
    $newContent = "@extends('layouts.app')\n\n";
    
    if (!empty(trim($headerContent))) {
        $newContent .= "@section('header')\n" . trim($headerContent) . "\n@endsection\n\n";
    }
    
    $newContent .= "@section('content')\n" . $mainContent . "\n@endsection";
    
    file_put_contents($filePath, $newContent);
    return true;
}

function scanDirectory($dir) {
    global $convertedCount;
    
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..' || $file === '.DS_Store') {
            continue;
        }
        
        $filePath = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($filePath)) {
            scanDirectory($filePath);
        } elseif (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
            if (convertFile($filePath)) {
                echo "✓ Converted: " . str_replace($viewsPath, '', $filePath) . "\n";
                $convertedCount++;
            }
        }
    }
}

echo "Starting conversion of x-app-layout to @extends...\n";
echo "========================================\n";

scanDirectory($viewsPath);

echo "\n========================================\n";
echo "Total files converted: {$convertedCount}\n";
echo "Done!\n";
