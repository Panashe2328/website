<?php
session_start();
include 'DBConn.php';// Ensure you include your database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: '); // Redirect if not an admin
    exit();
}

$errors = [];
$success = false;
// Fetch unverified users
$users = [];
$result = $conn->query("SELECT * FROM tblUser WHERE status = 'pending'"); // Adjusted to your table name
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $errors[] = "Error fetching users: " . $conn->error;
}

// Handle user verification or deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    
    if (isset($_POST['verify'])) {
        $stmt = $conn->prepare("UPDATE tblUser SET status = 'verified' WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Error verifying user: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM tblUser WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Error deleting user: " . $conn->error;
        }
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