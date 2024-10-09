<?php
// Database connection details
$hostname = "127.0.0.1"; // Use the IP address if localhost doesn't work
$username = "root";
$password = "";
$database = "clothingstore";

try {
    // Establish a connection using PDO
    $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    
    // Set PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Display connection success message
    echo "<p>Connection successful!</p>";

    // Check if the table 'tblUser' exists
    $query = $db->query("SHOW TABLES LIKE 'tblUser'");
    
    if ($query->rowCount() > 0) {
        echo "Table 'tblUser' exists in the database.";
    } else {
        echo "Table 'tblUser' does not exist.";
    }

} catch (PDOException $e) {
    // Output the error message if the connection fails
    die("Error: " . $e->getMessage());
}

?>
