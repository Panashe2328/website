<?php
session_start();
 include 'dbconn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_email = $_POST['admin_email'];
    $password = $_POST['password'];

    // Prepare SQL to check admin_email in the tblAdmin table
    $stmt = $conn->prepare("SELECT * FROM tbladmin WHERE admin_email = ?");
    $stmt->bind_param("s", $admin_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password hash
        if (password_verify($password, $row['password'])) {
            // Admin login success
            $_SESSION['admin_id'] = $row['admin_id'];
            echo "Admin " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " is logged in.";
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "Admin account does not exist. Please check your email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="post" action="AdminLogin.php">
        <label for="admin_email">Admin Email:</label>
        <input type="email" id="admin_email" name="admin_email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="8">
        
        <button type="submit">Login as Admin</button>
    </form>
</body>
</html>

<!--
<?php
// Start the session and ensure the user is an admin
session_start();
$_SESSION['role'] = 'Admin';   // Set user role (e.g., Admin)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
   // header('Location: login.php');
    exit();
}

// Include database connection
include('DBConn.php');

$errors = [];
$success = false;

// Fetch users for verification
$users = [];
$result = $dbConn->query("SELECT * FROM tblUsers WHERE verified = 'false'");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $errors[] = "Error fetching users: " . $dbConn->error;
}

// Handle user verification, update, or deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['verify'])) {
        $username = trim($_POST['username']);
        $stmt = $dbConn->prepare("UPDATE tblUsers SET verified = 'true' WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Error verifying user: " . $dbConn->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $username = trim($_POST['username']);
        $stmt = $dbConn->prepare("DELETE FROM tblUsers WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Error deleting user: " . $dbConn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Users - Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="_images/pastimes_logo.png" alt="" width="150px">
        </div>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="user-verification">
            <h1>Verify New Users</h1>

            <?php if ($success): ?>
                <p class="success">User verified/deleted successfully!</p>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['surname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <form action="admin_user.php" method="POST">
                                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                                    <button type="submit" name="verify" class="btn">Verify</button>
                                    <button type="submit" name="delete" class="btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Pastimes. All rights reserved.</p>
    </footer>
</body>
</html>


-->
