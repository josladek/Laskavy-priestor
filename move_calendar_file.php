<?php
// Script to move the uploaded calendar file to correct location on production server
// This runs once on the server to move the file from root to pages/ directory

$sourceFile = 'online-calendar-outlook.php';
$targetFile = 'pages/online-calendar-outlook.php';

if (file_exists($sourceFile)) {
    if (copy($sourceFile, $targetFile)) {
        echo "SUCCESS: File moved from root to pages/ directory\n";
        // Remove the temporary file from root
        if (unlink($sourceFile)) {
            echo "SUCCESS: Temporary file removed from root\n";
        } else {
            echo "WARNING: Could not remove temporary file from root\n";
        }
    } else {
        echo "ERROR: Failed to copy file to pages/ directory\n";
    }
} else {
    echo "ERROR: Source file not found in root directory\n";
}
?>