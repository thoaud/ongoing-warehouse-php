<?php

/**
 * Simple autoloader for Ongoing Warehouse API PHP Client
 * 
 * This file provides a basic autoloader for manual installation.
 * For Composer installations, use vendor/autoload.php instead.
 */

spl_autoload_register(function ($class) {
    // Only handle OngoingAPI namespace
    if (strpos($class, 'OngoingAPI\\') !== 0) {
        return;
    }
    
    // Convert namespace to file path
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    
    // Load the file if it exists
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load dependencies if not using Composer
if (!class_exists('GuzzleHttp\Client')) {
    // Check if Guzzle is available
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
    } else {
        throw new RuntimeException(
            'Guzzle HTTP client is required but not found. ' .
            'Please install dependencies with: composer install'
        );
    }
} 