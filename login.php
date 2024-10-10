<?php
session_start();
include 'dbconn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login']; // Can be username or email
    $password = $_POST['password'];

    // Check if the role key exists in the POST array
    if (isset($_POST['role'])) {
        $role = $_POST['role']; // Get the role from the form

        if ($role === 'user') {
            // Check if the user is in the tblUser table (user role)
            $stmt = $conn->prepare("SELECT * FROM tbleuser WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $login, $login); // Bind for both username and email
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Check if the password matches the hash
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['user_id']; // Set session ID for user
                    echo "User " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " is logged in.";
                    header("Location: index.php"); // Redirect to user dashboard or profile page
                    exit();
                } else {
                    echo "Invalid password. Please try again.";
                }
            } else {
                echo "User does not exist.";
            }
        } elseif ($role === 'admin') {
            // Check if the user is in the tblAdmin table (admin role)
            $stmt = $conn->prepare("SELECT * FROM tbladmin WHERE admin_email = ?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Check the password
                if (password_verify($password, $row['password'])) {
                    $_SESSION['admin_id'] = $row['admin_id']; // Set session ID for admin
                    echo "Admin " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " is logged in.";
                    header("Location: admin_dashboard.php"); // Redirect to admin dashboard
                    exit();
                } else {
                    echo "Invalid admin password. Please try again.";
                }
            } else {
                echo "Admin does not exist.";
            }
        } else {
            echo "Invalid role selected.";
        }
    } else {
        echo "Role not selected.";
    }
}
?>
