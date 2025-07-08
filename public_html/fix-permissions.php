<?php

function chmod_r($path) {
    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
        if ($item->isDot()) continue;
        
        $itemPath = $item->getPathname();
        
        if ($item->isDir()) {
            // Directories to 755
            chmod($itemPath, 0755);
            chmod_r($itemPath);
        } else {
            // Files to 644
            chmod($itemPath, 0644);
        }
    }
}

$base_path = '/home/sistemi4/inventaris-smk-sasmita';

// Set main directories to 755
$directories = [
    $base_path,
    $base_path . '/vendor',
    $base_path . '/bootstrap',
    $base_path . '/storage'
];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0755);
        chmod_r($dir);
    }
}

// Set storage and cache directories to 775
$writable_dirs = [
    $base_path . '/storage/framework',
    $base_path . '/storage/logs',
    $base_path . '/bootstrap/cache'
];

foreach ($writable_dirs as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0775);
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $item) {
            chmod($item->getPathname(), 0775);
        }
    }
}

echo "Permissions have been updated successfully!"; 