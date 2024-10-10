<?php
// Include the database connection (DBConn.php)
include 'DBConn.php';

try {
    // Disable foreign key checks
    $db->exec("SET FOREIGN_KEY_CHECKS = 0;");

    // Check if the tblUser table exists
    $checkTable = $db->query("SHOW TABLES LIKE 'tblUser'");
    
    if ($checkTable->rowCount() > 0) {
        // Drop the tblUser table if it exists
        $db->exec("DROP TABLE tblUser");
        echo "<p>tblUser table dropped.</p>";
    }

    // Create the tblUser table
    $createTableSQL = "
        CREATE TABLE tblUser (
            user_id INT PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            city VARCHAR(100),
            code VARCHAR(10),
            status VARCHAR(20)
        )";
    $db->exec($createTableSQL);
    echo "<p>tblUser table created.</p>";

    // Load data from userData.txt file
    $file = fopen('userData.txt', 'r');
    
    while (($line = fgetcsv($file)) !== FALSE) {
        // Each line corresponds to a user record (assumed to be CSV format)
        $user_id = $line[0];
        $first_name = $line[1];
        $last_name = $line[2];
        $username = $line[3];
        $password = password_hash($line[4], PASSWORD_BCRYPT); // Securely hash the password
        $city = $line[5];
        $code = $line[6];
        $status = $line[7];

        // Insert data into tblUser table
        $insertSQL = "INSERT INTO tblUser (user_id, first_name, last_name, username, password, city, code, status) 
                      VALUES (:user_id, :first_name, :last_name, :username, :password, :city, :code, :status)";
        $stmt = $db->prepare($insertSQL);
        $stmt->execute([
            ':user_id' => $user_id,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':username' => $username,
            ':password' => $password,
            ':city' => $city,
            ':code' => $code,
            ':status' => $status
        ]);
    }

    fclose($file);
    echo "<p>Data successfully loaded from userData.txt into tblUser.</p>";

    // Re-enable foreign key checks
    $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
