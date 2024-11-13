<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header("Location: login.php"); 
    exit;
}

// User is logged in, generate order number and session ID
$orderNum = 'ORD' . strtoupper(uniqid()); // Generate a unique order number
$sessionId = session_id(); // Get the session ID

// You can save these details to the database or session as needed
$_SESSION['order_num'] = $orderNum;
$_SESSION['session_id'] = $sessionId;

// Redirect to checkout page
header("Location: checkout.php");
exit;
?>
