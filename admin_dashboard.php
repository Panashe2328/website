<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to login page if not an admin
    exit();
}

// Fetch users needing approval and all customers
try {
    $stmt = $db->prepare("SELECT * FROM tblUser WHERE status = 'pending'"); // Users needing approval
    $stmt->execute();
    $pending_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $db->prepare("SELECT * FROM tblUser WHERE status = 'approved'"); // Approved users
    $stmt->execute();
    $approved_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 10px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        main {
            padding: 20px;
        }

        .error-message {
            color: red;
        }

        .user-list {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
            background-color: white;
        }

        .user-list th, .user-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .user-list th {
            background-color: #f2f2f2;
        }

        .approve-button,
        .edit-button,
        .delete-button,
        .add-button {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 5px;
        }

        .delete-button {
            background-color: red;
        }

        .approve-button:hover,
        .edit-button:hover,
        .delete-button:hover,
        .add-button:hover {
            opacity: 0.8;
        }

        .form-container {
            margin: 20px 0;
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
            <li><a href="admin_dashboard.php" class="Current">Dashboard</a></li>
            <li><a href="user_register.php">Register</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_email']); ?>!</h2>
    
    <!-- Display any error messages -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    
    <h3>Users Needing Approval</h3>
    <table class="user-list">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
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
                        <td>
                            <form method="post" action="approve_user.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="approve-button">Approve</button>
                            </form>
                            <form method="post" action="edit_user.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="edit-button">Edit</button>
                            </form>
                            <form method="post" action="delete_user.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users needing approval.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Approved Customers</h3>
    <table class="user-list">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($approved_users)): ?>
                <?php foreach ($approved_users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td>
                            <form method="post" action="edit_user.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="edit-button">Edit</button>
                            </form>
                            <form method="post" action="delete_user.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No approved customers.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="form-container">
        <h3>Add New Customer</h3>
        <form method="post" action="add_customer.php">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="add-button">Add Customer</button>
        </form>
    </div>
</main>
</body>
</html>