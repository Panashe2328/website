<?php
session_start();
include 'dbconn.php'; // Correctly include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login']; // Can be username or admin_email
    $password = $_POST['password'];

    // Check if the user is in the tblUser table (user role)
    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $login, $login); // Bind for both username and email
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the password matches the hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id']; // Set session ID for user
            echo "User " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " is logged in.";

            // Display user details
            echo "<table>
                    <tr><td>First Name:</td><td>" . htmlspecialchars($row['first_name']) . "</td></tr>
                    <tr><td>Last Name:</td><td>" . htmlspecialchars($row['last_name']) . "</td></tr>
                    <tr><td>Username:</td><td>" . htmlspecialchars($row['username']) . "</td></tr>
                    <tr><td>City:</td><td>" . htmlspecialchars($row['city']) . "</td></tr>
                  </table>";
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        // Check if the user is in the tblAdmin table (admin role)
        $stmt = $conn->prepare("SELECT * FROM tblAdmin WHERE admin_email = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Check the password
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['admin_id']; // Set session ID for admin
                echo "Admin " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " is logged in.";
            } else {
                echo "Invalid admin password. Please try again.";
            }
        } else {
            echo "User does not exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="Login.php">
        <label for="login">Username or Email:</label>
        <input type="text" id="login" name="login" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="8">
        
        <button type="submit">Login</button>
    </form>
</body>
</html>
