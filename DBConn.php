<?php
//get server host, name of user, password, name of database
//declare varibales for db connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "clothingstore";

try {
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if a specific table exists
    $query = $db->query("SHOW TABLES LIKE 'tblUser'");
    
    if ($query->rowCount() > 0) {
        echo "Table 'tblUser' exists in the database.";
    } else {
        echo "Table 'tblUser' does not exist.";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>