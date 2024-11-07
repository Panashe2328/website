<?php
session_start();
include 'DBConn.php'; // Include the database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to login page if not an admin
    exit();
}

// Check if a valid item ID is passed
if (isset($_POST['clothes_id'])) {
    $clothes_id = $_POST['clothes_id'];

    // Prepare the SQL query to delete the item
    $query = "DELETE FROM tblClothes WHERE clothes_id = :clothes_id";
    $stmt = $db->prepare($query);

    // Bind the clothes_id to the statement and execute
    $stmt->bindParam(':clothes_id', $clothes_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // If the deletion was successful, redirect to the admin dashboard with a success message
        header('Location: admin_dashboard.php?deleted=1');
        exit();
    } else {
        // If there was an error, you can redirect to the dashboard with an error message
        header('Location: admin_dashboard.php?deleted=0');
        exit();
    }
} else {
    // If no clothes_id was provided, you can redirect with an error
    header('Location: admin_dashboard.php?deleted=0');
    exit();
}
?>
