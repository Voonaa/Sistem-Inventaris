<?php
// Set maximum execution time
set_time_limit(300);

// Define paths
$sourcePath = realpath(__DIR__ . '/../public/assets');
$targetPath = __DIR__ . '/assets';

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

    // Create images directory
    if (!is_dir($targetPath . '/images')) {
        if (mkdir($targetPath . '/images', 0755, true)) {
            output("Created directory: " . $targetPath . '/images');
        } else {
            throw new Exception("Failed to create images directory");
        }
    }

    // Copy logo file
    $sourceFile = $sourcePath . '/images/logosmk.png';
    $targetFile = $targetPath . '/images/logosmk.png';
    
    if (file_exists($sourceFile)) {
        if (copy($sourceFile, $targetFile)) {
            output("Successfully copied logo to: " . $targetFile);
            // Set correct permissions
            chmod($targetFile, 0644);
            output("Set permissions to 644");
        } else {
            throw new Exception("Failed to copy logo file");
        }
    } else {
        throw new Exception("Source logo file not found at: " . $sourceFile);
    }

    output("Asset copying process completed successfully!");
    
} catch (Exception $e) {
    output("Error: " . $e->getMessage());
}
?> 