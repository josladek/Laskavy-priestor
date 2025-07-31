<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'includes/auth.php';

// Debug session information
echo "<h1>Session Debug Information</h1>";
echo "<h2>Session Status:</h2>";
echo "Session Status: " . session_status() . " (1=disabled, 2=none, 3=active)<br>";
echo "Session ID: " . session_id() . "<br>";

echo "<h2>Session Data:</h2>";
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";

echo "<h2>isLoggedIn() result:</h2>";
echo isLoggedIn() ? "TRUE (logged in)" : "FALSE (not logged in)";

echo "<h2>getCurrentUser() result:</h2>";
$user = getCurrentUser();
echo "<pre>";
var_dump($user);
echo "</pre>";

echo "<h2>Available Courses:</h2>";
$courses = getCourses(true);
echo "Number of active courses: " . count($courses) . "<br>";
foreach ($courses as $course) {
    echo "Course ID: " . $course['id'] . " - " . $course['name'] . "<br>";
}

echo "<h2>Test Login Link:</h2>";
echo '<a href="pages/login.php">Go to Login Page</a><br>';
echo '<a href="pages/courses.php">Go to Courses Page</a>';
?>