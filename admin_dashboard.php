<?php
session_start(); // Start the session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// You can include additional functionality specific to the admin dashboard here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file here -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <!-- Add more navigation links as needed -->
                <li><a href="logout.php">Logout</a></li> <!-- Implement logout.php to destroy session -->
            </ul>
        </nav>
    </header>
    <main>
        <h1>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h1>
        <!-- Add admin dashboard content here -->
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>

<!--
<?php
// Start the session and ensure the user is an admin
session_start();
//$_SESSION['role'] = 'Admin';   // Set user role (e.g., Admin)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    // Redirect to login if not admin
   // header('Location: login.php');
    exit();
}

// Include database connection
include('DBConn.php');

// Fetch all users
$sql = "SELECT * FROM tblUsers";
$result = $dbConn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="_images/pastimes_logo.png" alt="" width="150px">
        </div>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="admin_user.php">Manage Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="admin-dashboard">
            <h1>Admin Dashboard</h1>

            <a href="admin_user.php" class="btn">Add New User</a>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['verified'] == 'true' ? 'Verified' : 'Pending'); ?></td>
                            <td>
                                <a href="edit_user.php?username=<?php echo urlencode($row['username']); ?>" class="edit-btn">Edit</a>
                                <a href="delete_user.php?username=<?php echo urlencode($row['username']); ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
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
