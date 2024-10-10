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


<!--
<?php
// Include the DB connection script
include 'DBConn.php';

// Start by disabling foreign key checks
$dbConn->query("SET FOREIGN_KEY_CHECKS = 0;");

// SQL query to check if the table exists
$tableName = "tbluser";
$tableExistsQuery = "SHOW TABLES LIKE '$tableName'";
$result = $dbConn->query($tableExistsQuery);

if ($result && $result->num_rows > 0) {
    // If the table exists, drop it
    $dropTableQuery = "DROP TABLE `$tableName`";
    if ($dbConn->query($dropTableQuery) === TRUE) {
        echo "<p>Table $tableName dropped successfully.</p>";
    } else {
        echo "<p>Error dropping table: " . $dbConn->error . "</p>";
    }
}

// SQL to create the tbluser table
$createTableQuery = "
CREATE TABLE `$tableName` (
    `UserName` VARCHAR(50) NOT NULL,
    `Name` VARCHAR(50) DEFAULT NULL,
    `Surname` VARCHAR(50) DEFAULT NULL,
    `email` VARCHAR(50) DEFAULT NULL,
    `password` VARCHAR(100) DEFAULT NULL,
    `Verified` TINYINT(1) DEFAULT NULL,
    PRIMARY KEY (`UserName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

if ($dbConn->query($createTableQuery) === TRUE) {
    echo "<p>Table $tableName created successfully.</p>";
} else {
    echo "<p>Error creating table: " . $dbConn->error . "</p>";
}

// Load data from userData.txt
$dataFile = 'userData.txt';
if (file_exists($dataFile)) {
    $fileContent = file_get_contents($dataFile);
    
    // Split the content into lines and prepare for insertion
    $lines = explode(PHP_EOL, trim($fileContent));
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            $data = array_map('trim', explode(",", $line)); // Trim each element
            if (count($data) === 6) {
                $data[5] = ($data[5] === 'true') ? 1 : 0; // Convert boolean to integer
                $insertQuery = "INSERT INTO `$tableName` (`UserName`, `Name`, `Surname`, `email`, `password`, `Verified`) VALUES ('" . implode("', '", $data) . "')";
                
                if ($dbConn->query($insertQuery) === TRUE) {
                    echo "<p>Data inserted successfully: $insertQuery</p>";
                } else {
                    echo "<p>Error inserting data: " . $dbConn->error . "</p>";
                }
            } else {
                echo "<p>Invalid data format for line: $line</p>";
            }
        }
    }
} else {
    echo "<p>Data file $dataFile not found.</p>";
}

// Re-enable foreign key checks
$dbConn->query("SET FOREIGN_KEY_CHECKS = 1;");


?>

-->
