<?php

$links = [
    'vendor' => __DIR__ . '/vendor',
    'storage' => __DIR__ . '/storage',
    'bootstrap' => __DIR__ . '/bootstrap'
];

foreach ($links as $name => $path) {
    echo "Checking $name: ";
    if (is_link($path)) {
        echo "Is Symlink - Points to: " . readlink($path) . "<br>";
        echo "Exists: " . (file_exists($path) ? "YES" : "NO") . "<br>";
        echo "Readable: " . (is_readable($path) ? "YES" : "NO") . "<br>";
    } else {
        echo "Not a symlink<br>";
    }
    echo "<br>";
}

// Check autoload.php
$autoload = __DIR__ . '/vendor/autoload.php';
echo "Checking autoload.php:<br>";
echo "Path: $autoload<br>";
echo "Exists: " . (file_exists($autoload) ? "YES" : "NO") . "<br>";
echo "Readable: " . (is_readable($autoload) ? "YES" : "NO") . "<br>"; 