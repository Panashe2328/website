<?php
//get server host, name of user, password, name of database
//declare varibales for db connection
$hostname = "";
$username = "";
$password = "";
$database = "ClothingStore";

//create db connection variable
$dbConn = @new mysqli();

//check connection
if ($dbConn->connect_error) 
    $errorMgs[] = "The databse server is not available".
    "Connect Error is " . $mysqli->connect_errno . " " . $mysqli->connect_error . ".";
else
    echo "<p> Connection Established </p>";

/*
try {
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
    */
?>