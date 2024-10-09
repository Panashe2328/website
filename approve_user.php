<?php
session_start();
include 'dbconn.php'; 

// Check if the user is logged in as an admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Approve user if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE users SET isApproved=1 WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error approving user.";
    }
} else {
    echo "No ID provided.";
    exit();
}
?>
