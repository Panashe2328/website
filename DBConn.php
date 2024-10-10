<?php
// Database connection details
$hostname = "localhost"; // Use the IP address if localhost doesn't work
$username = "root";
$password = "";
$database = "clothingstore";

try {
    // Establish a connection using PDO
    $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    
    // Use PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Show connection success message
    echo "<p>Connection successful!</p>";

    // Check if the table 'tblUser' exists
    $query = $db->query("SHOW TABLES LIKE 'tblUser'");
    echo ($query->rowCount() > 0) ? "Table 'tblUser' exists in the database.<br>" : "Table 'tblUser' does not exist.<br>";

    // Check if the table 'tblAdmin' exists
    $query = $db->query("SHOW TABLES LIKE 'tblAdmin'");
    echo ($query->rowCount() > 0) ? "Table 'tblAdmin' exists in the database.<br>" : "Table 'tblAdmin' does not exist.<br>";

    // Check if the table 'tblClothes' exists
    $query = $db->query("SHOW TABLES LIKE 'tblClothes'");
    echo ($query->rowCount() > 0) ? "Table 'tblClothes' exists in the database.<br>" : "Table 'tblClothes' does not exist.<br>";

    // Check if the table 'tblOrder' exists
    $query = $db->query("SHOW TABLES LIKE 'tblOrder'");
    echo ($query->rowCount() > 0) ? "Table 'tblOrder' exists in the database.<br>" : "Table 'tblOrder' does not exist.<br>";

} catch (PDOException $e) {
    // Show the error message if the connection fails
    die("Error: " . htmlspecialchars($e->getMessage())); // Sanitize output for security
}
?>
