<?php
session_start();
include 'dbconn.php'; // Include your database connection

// Check if the user is logged in as an admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Delete user if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error deleting user.";
    }
} else {
    echo "No ID provided.";
    exit();
}
?>
