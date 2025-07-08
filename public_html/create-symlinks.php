<?php

$source_path = '/home/sistemi4/inventaris-smk-sasmita';
$public_path = '/home/sistemi4/public_html';

// Create vendor symlink
if (!file_exists($public_path . '/vendor')) {
    symlink($source_path . '/vendor', $public_path . '/vendor');
    echo "Vendor symlink created successfully<br>";
}

// Create storage symlink
if (!file_exists($public_path . '/storage')) {
    symlink($source_path . '/storage/app/public', $public_path . '/storage');
    echo "Storage symlink created successfully<br>";
}

// Create bootstrap symlink
if (!file_exists($public_path . '/bootstrap')) {
    symlink($source_path . '/bootstrap', $public_path . '/bootstrap');
    echo "Bootstrap symlink created successfully<br>";
}

echo "All symlinks have been created!"; 