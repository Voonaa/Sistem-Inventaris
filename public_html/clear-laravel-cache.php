<?php
// Set maximum execution time to 300 seconds (5 minutes)
set_time_limit(300);

// Define the base path (update this to match your actual path)
$basePath = '/home/sistemi4/inventaris-smk-sasmita';

// Function to output messages
function output($message) {
    echo $message . "<br>";
    flush();
    ob_flush();
}

try {
    output("Starting cache clear process...");
    
    // Clear framework cache directories manually
    $cacheDirs = [
        '/bootstrap/cache/',
        '/storage/framework/cache/',
        '/storage/framework/views/',
        '/storage/framework/sessions/',
    ];
    
    foreach ($cacheDirs as $dir) {
        $fullPath = $basePath . $dir;
        if (is_dir($fullPath)) {
            output("Clearing directory: " . $fullPath);
            $files = glob($fullPath . '*');
            foreach ($files as $file) {
                if (is_file($file) && basename($file) !== '.gitignore') {
                    if (unlink($file)) {
                        output("Deleted: " . basename($file));
                    } else {
                        output("Failed to delete: " . basename($file));
                    }
                }
            }
        } else {
            output("Directory not found: " . $fullPath);
        }
    }

    // Clear Laravel cache using artisan
    $artisanCommands = [
        'cache:clear',
        'config:clear',
        'view:clear',
        'route:clear'
    ];

    foreach ($artisanCommands as $command) {
        output("Executing: php " . $basePath . "/artisan " . $command);
        $result = shell_exec("php " . $basePath . "/artisan " . $command . " 2>&1");
        output("Result: " . ($result ?: "Command executed"));
    }
    
    output("Cache clearing process completed successfully!");
    
} catch (Exception $e) {
    output("Error: " . $e->getMessage());
}
?> 