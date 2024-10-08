<?php
//get server host, name of user, password, name of database
//declare varibales for db connection
$hostname = "localhost";
$username = "root";
$password = "";
<<<<<<< HEAD
$database = "";
$database = "login";      // Database name
=======
$database = "ClothingStore";
>>>>>>> 34931d6d5a946c8b5e7c7f29c4691403e2899199

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