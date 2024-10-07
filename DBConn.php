<?php
//get server host, name of user, password, name of database
//declare varibales for db connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "ClothingStore";

//connect to mysql database using PDO connection
//try to create a new pdo connection using database credentials
try {
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    //error handling to throw exceptions, if error happens it will be caught
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //die function outputs message
    die("Error: " . $e->getMessage());
}

?>