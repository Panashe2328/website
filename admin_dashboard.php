<?php
session_start();
include 'dbconn.php'; // Include your database connection

// Check if the user is logged in as an admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Fetch clothing items from the database
$items_sql = "SELECT * FROM clothing_items";
$items_result = $conn->query($items_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<main>
    <h2>User Management</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['firstName']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastName']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td><?php echo $row['isApproved'] ? 'Approved' : 'Pending'; ?></td>
                        <td>
                            <?php if (!$row['isApproved']): ?>
                                <a href="approve_user.php?id=<?php echo $row['id']; ?>">Approve</a>
                            <?php endif; ?>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Clothing Items Management</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items_result->num_rows > 0): ?>
                <?php while ($item = $items_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo htmlspecialchars($item['itemName']); ?></td>
                        <td><?php echo htmlspecialchars($item['description']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>
                            <a href="edit_item.php?id=<?php echo $item['id']; ?>">Edit</a>
                            <a href="delete_item.php?id=<?php echo $item['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No clothing items found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
