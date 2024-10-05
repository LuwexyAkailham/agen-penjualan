<?php
// Database connection settings
$servername = "localhost"; // Update this if necessary
$username = "root";        // Update this if necessary
$password = "";            // Update this if necessary
$dbname = "agenpenjualan_db"; // Update this if necessary

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>