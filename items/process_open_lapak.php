<?php
session_start(); // Memulai sesi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include '../koneksi.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../main/login.php'); // Redirect to login if not logged in
    exit();
}

// Update user role to admin
$username = $_SESSION['username'];
$stmt = $conn->prepare("UPDATE users SET user_role = 'admin' WHERE username = ?");
if ($stmt) {
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        // Role updated successfully
        $_SESSION['user_role'] = 'admin'; // Set the session role to admin
        header('Location: ../profile/edit_profile.php?success=Role updated to admin');
        exit();
    } else {
        echo "Error updating role: " . $stmt->error;
    }
} else {
    echo "Error: " . $conn->error;
}

// Menutup koneksi database
$conn->close();
?>
