<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: admin_dashboard.php'); // Redirect to login page if not an admin
    exit();
}

// Check if user_id is set and valid
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Update user status to approved
    try {
        $stmt = $db->prepare("UPDATE tblUser SET status = 'approved' WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        // Redirect back to the dashboard with success message
        $_SESSION['message'] = "User approved successfully.";
        header('Location: admin_dashboard.php');
        exit();
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}

// Redirect back to the dashboard if no user_id was set
header('Location: admin_dashboard.php');
exit();
?>
