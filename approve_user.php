<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to admin login page if not an admin
    exit();
}

// Check if user_id is set and valid
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Update user status to 'approved'
    try {
        $stmt = $db->prepare("UPDATE tblUser SET status = 'approved' WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Set success message in session and redirect to dashboard
        $_SESSION['message'] = "User approved successfully.";
        header('Location: admin_dashboard.php');
        exit();
    } catch (PDOException $e) {
        // Set error message in session and redirect to dashboard
        $_SESSION['error_message'] = "Database error: " . $e->getMessage();
        header('Location: admin_dashboard.php');
        exit();
    }
} else {
    // If user_id is not set or invalid, redirect to dashboard with error
    $_SESSION['error_message'] = "Invalid user ID.";
    header('Location: admin_dashboard.php');
    exit();
}
?>
