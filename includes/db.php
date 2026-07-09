<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$dbname = 'childsafe';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");

session_start();

// Helper function to safely output data
function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
?>
