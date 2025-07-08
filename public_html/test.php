<?php

$paths = [
    '/home/sistemi4/inventaris-smk-sasmita/vendor/autoload.php',
    '/home/sistemi4/inventaris-smk-sasmita/bootstrap/app.php',
    '/home/sistemi4/inventaris-smk-sasmita/storage/framework'
];

echo "<h2>Path Verification</h2>";
foreach ($paths as $path) {
    echo "Checking: " . $path . "<br>";
    echo "Exists: " . (file_exists($path) ? "YES" : "NO") . "<br>";
    echo "Readable: " . (is_readable($path) ? "YES" : "NO") . "<br>";
    echo "File Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "<br><br>";
}

// Show include path
echo "<h2>Include Path</h2>";
echo get_include_path() . "<br>";

// Show current working directory
echo "<h2>Current Directory</h2>";
echo getcwd() . "<br>";

// Show file owner
echo "<h2>File Ownership</h2>";
echo "Owner: " . posix_getpwuid(fileowner($paths[0]))['name'] . "<br>";
echo "Group: " . posix_getgrgid(filegroup($paths[0]))['name'] . "<br>"; 