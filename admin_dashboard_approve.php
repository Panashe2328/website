<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to login page if not an admin
    exit();
}

// Fetch pending users from the database
try {
    $stmt = $db->prepare("SELECT * FROM tblUser WHERE status = 'pending'");
    $stmt->execute();
    $pending_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch approved users as well
    $stmt_approved = $db->prepare("SELECT * FROM tblUser WHERE status = 'active'");
    $stmt_approved->execute();
    $approved_users = $stmt_approved->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}

// Handle approval or rejection of a user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve_user'])) {
        $user_id = $_POST['user_id'];
        $status = 'active';

        try {
            $updateStmt = $db->prepare("UPDATE tblUser SET status = :status WHERE user_id = :user_id");
            $updateStmt->bindParam(':status', $status);
            $updateStmt->bindParam(':user_id', $user_id);
            $updateStmt->execute();
            header('Location: admin_dashboard_approve.php?user_approved=1');
            exit();
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }

    if (isset($_POST['reject_user'])) {
        $user_id = $_POST['user_id'];
        $status = 'inactive'; // Rejected users can be set to inactive if needed

        try {
            $updateStmt = $db->prepare("UPDATE tblUser SET status = :status WHERE user_id = :user_id");
            $updateStmt->bindParam(':status', $status);
            $updateStmt->bindParam(':user_id', $user_id);
            $updateStmt->execute();
            header('Location: admin_dashboard_approve.php?user_rejected=1');
            exit();
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard - User Approval</title>
    <style>
        .user-list th, .user-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .user-list th {
            background-color: #f2f2f2;
        }

        .approve-button,
        .reject-button {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 5px;
        }

        .reject-button {
            background-color: red;
        }

        .approve-button:hover,
        .reject-button:hover {
            opacity: 0.8;
        }

        .success-message {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="Pastimes" alt="">
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.php">About</a></li>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="user_register.php">Register</a></li>
            <li><a href="admin_dashboard_approve.php" class="Current">Users</a></li>
        </ul>
    </nav>
</header>

<main>
<h2>Welcome, <?php echo isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email']) : 'Admin'; ?>!</h2>

    <!-- Display success message if a user was approved -->
    <?php if (isset($_GET['user_approved']) && $_GET['user_approved'] == 1): ?>
        <div class="success-message">User approved successfully.</div>
    <?php endif; ?>

    <!-- Display success message if a user was rejected -->
    <?php if (isset($_GET['user_rejected']) && $_GET['user_rejected'] == 1): ?>
        <div class="success-message">User rejected successfully.</div>
    <?php endif; ?>

    <!-- Display any error messages -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <h3>Pending User Approvals</h3>
    <table class="user-list">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>City</th> <!-- Replaced email with city -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pending_users)): ?>
                <?php foreach ($pending_users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['city']); ?></td> <!-- Display city instead of email -->
                        <td>
                            <form method="post" action="admin_dashboard_approve.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" name="approve_user" class="approve-button">Approve</button>
                            </form>
                            <form method="post" action="admin_dashboard_approve.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" name="reject_user" class="reject-button">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users awaiting approval.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Approved Users</h3>
    <table class="user-list">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>City</th> <!-- Replaced email with city -->
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($approved_users)): ?>
                <?php foreach ($approved_users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['city']); ?></td> <!-- Display city instead of email -->
                        <td><?php echo ucfirst($user['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No approved users.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
