<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page after logout
header("Location: login.php");
exit();
?>

<!--
<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or home page
header('Location: index.php');
exit();
?>
-->
