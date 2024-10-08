<?php
//include the database connection (DBConn.php)
include 'dbconn.php';

try {
    //First -> Check if the tblUser table exists
    $checkTable = $db->query("SHOW TABLES LIKE 'tblUser'");
    if ($checkTable->rowCount() > 0) 
    {
        //Second -> Drop the tblUser table if it exists
        $db->exec("DROP TABLE tblUser");
        echo "<p>tblUser table dropped.</p>";
    }

    //Third -> Create the tblUser table
    $createTableSQL = "
        CREATE TABLE tblUser (
            user_id INT PRIMARY KEY,
            first_name VARCHAR(50),
            last_name VARCHAR(50),
            username VARCHAR(50),
            password VARCHAR(255),
            address VARCHAR(255),
            city VARCHAR(100),
            code VARCHAR(10),
            status VARCHAR(20)
        )";
    $db->exec($createTableSQL);
    echo "<p>tblUser table created.</p>";

    //Fourth -> Load data from userData.txt file
    $file = fopen('userData.txt', 'r');
    
    while (($line = fgetcsv($file)) !== FALSE) 
    {
        // Each line corresponds to a user record
        // Extract user data from the CSV (adjusting indices as necessary)
        //array
        $user_id = $line[0];
        $first_name = $line[1];
        $last_name = $line[2];
        $username = $line[3];
        $password = $line[4]; 
        $address = $line[5];
        $city = $line[6];
        $code = $line[7];
        $status = $line[8];

        //insert data into tblUser table
        $insertSQL = "INSERT INTO tblUser (user_id, first_name, last_name, username, password, address, city, code, status) 
                      VALUES (:user_id, :first_name, :last_name, :username, :password, :address, :city, :code, :status)";
        $stmt = $db->prepare($insertSQL);
        $stmt->execute([
            ':user_id' => $user_id,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':username' => $username,
            ':password' => $password,
            ':address' => $address,
            ':city' => $city,
            ':code' => $code,
            ':status' => $status
        ]);
    }

    fclose($file);
    echo "<p>Data successfully loaded from userData.txt into tblUser.</p>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
