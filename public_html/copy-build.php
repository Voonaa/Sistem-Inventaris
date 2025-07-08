<?php
// Set maximum execution time
set_time_limit(300);

// Define paths
$sourcePath = realpath(__DIR__ . '/build');
$targetPath = __DIR__ . '/build';

// Function to output messages
function output($message) {
    echo $message . "<br>";
    flush();
    ob_flush();
}

try {
    // Create target directory if it doesn't exist
    if (!is_dir($targetPath)) {
        if (mkdir($targetPath, 0755, true)) {
            output("Created directory: " . $targetPath);
        } else {
            throw new Exception("Failed to create directory: " . $targetPath);
        }
    }

    // List all files in source directory
    $files = glob($sourcePath . '/*');
    
    foreach ($files as $file) {
        $filename = basename($file);
        $targetFile = $targetPath . '/' . $filename;
        
        if (copy($file, $targetFile)) {
            output("Successfully copied: " . $filename);
            // Set correct permissions
            chmod($targetFile, 0644);
            output("Set permissions to 644 for: " . $filename);
        } else {
            throw new Exception("Failed to copy file: " . $filename);
        }
    }

    output("Build files copying process completed successfully!");
    
    // Output the contents of manifest.json for verification
    $manifestFile = $targetPath . '/manifest.json';
    if (file_exists($manifestFile)) {
        $manifest = json_decode(file_get_contents($manifestFile), true);
        output("<br>Manifest contents:");
        echo "<pre>";
        print_r($manifest);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    output("Error: " . $e->getMessage());
}
?> 