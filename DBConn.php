<?php
//database connection details
$hostname = "localhost"; // Use the IP address if localhost doesn't work
$username = "root";
$password = "";
$database = "clothingstore";

try {
    //establish a connection using PDO
    $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    
    //use PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //show connection success message
    echo "<p>Connection successful!</p>";

    //check if the table 'tblUser' exists
    $query = $db->query("SHOW TABLES LIKE 'tblUser'");
    
    if ($query->rowCount() > 0) {
        echo "Table 'tblUser' exists in the database.<br>";
    } else {
        echo "Table 'tblUser' does not exist.<br>";
    }

    //check if the table 'tblAdmin' exists
    $query = $db->query("SHOW TABLES LIKE 'tblAdmin'");
    if ($query->rowCount() > 0) {
        echo "Table 'tblAdmin' exists in the database.<br>";
    } else {
        echo "Table 'tblAdmin' does not exist.<br>";
    }

    //check if the table 'tblClothes' exists
    $query = $db->query("SHOW TABLES LIKE 'tblClothes'");
    if ($query->rowCount() > 0) {
        echo "Table 'tblClothes' exists in the database.<br>";
    } else {
        echo "Table 'tblClothes' does not exist.<br>";
    }

    //check if the table 'tblOrder' exists
    $query = $db->query("SHOW TABLES LIKE 'tblOrder'");
    if ($query->rowCount() > 0) {
        echo "Table 'tblOrder' exists in the database.<br>";
    } else {
        echo "Table 'tblOrder' does not exist.<br>";
    }

} catch (PDOException $e) {
    //Show the error message if the connection fails
    die("Error: " . $e->getMessage());
}

?>
