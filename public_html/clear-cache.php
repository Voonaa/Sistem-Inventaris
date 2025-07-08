<?php

// Definisikan path ke direktori cache
$storage_path = __DIR__.'/../inventaris-smk-sasmita/storage/framework/';
$bootstrap_path = __DIR__.'/../inventaris-smk-sasmita/bootstrap/cache/';

function clearDirectory($directory) {
    if (is_dir($directory)) {
        $files = glob($directory . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        return true;
    }
    return false;
}

try {
    // Clear framework cache directories
    $cache_cleared = [
        'Views' => clearDirectory($storage_path . 'views'),
        'Cache' => clearDirectory($storage_path . 'cache'),
        'Sessions' => clearDirectory($storage_path . 'sessions'),
        'Bootstrap' => clearDirectory($bootstrap_path)
    ];

    echo "<h2>Cache Clearing Results:</h2>";
    foreach ($cache_cleared as $type => $success) {
        echo "$type cache: " . ($success ? "Cleared successfully" : "No directory found or error") . "<br>";
    }

    // Create fresh .gitignore files to maintain directory structure
    $directories = [
        $storage_path . 'views',
        $storage_path . 'cache',
        $storage_path . 'sessions'
    ];

    foreach ($directories as $dir) {
        if (is_dir($dir)) {
            file_put_contents($dir . '/.gitignore', "*\n!.gitignore\n");
        }
    }

    echo "<br>Cache clearing process completed!";
    echo "<br><br>Note: If you still experience issues, please check file permissions and ensure the storage directory is writable.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Hapus file ini setelah dijalankan untuk keamanan
// Uncomment baris di bawah jika Anda ingin file ini terhapus otomatis setelah dijalankan
// unlink(__FILE__); 