<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to login page if not an admin
    exit();
}

// Fetch all clothing items from the database
try {
    $stmt = $db->prepare("SELECT * FROM tblClothes");
    $stmt->execute();
    $clothes_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
    <style>
        .clothes-list th, .clothes-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .clothes-list th {
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
            <li><a href="admin_dashboard.php" class="Current">Dashboard</a></li>
            <li><a href="user_register.php">Register</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_email']); ?>!</h2>

    <!-- Display success message if an item was deleted -->
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <div class="success-message">Item deleted successfully.</div>
    <?php endif; ?>

    <!-- Display any error messages -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <h3>Clothing Items</h3>
    <table class="clothes-list">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Size</th>
                <th>Condition</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clothes_items)): ?>
                <?php foreach ($clothes_items as $item): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="Clothing Image" style="width: 50px;"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['clothes_description']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['clothes_category']); ?></td>
                        <td><?php echo htmlspecialchars($item['size']); ?></td>
                        <td><?php echo htmlspecialchars($item['condition']); ?></td>
                        <td>
                            <form method="post" action="editItem.php" style="display:inline;">
                                <input type="hidden" name="clothes_id" value="<?php echo $item['clothes_id']; ?>">
                                <button type="submit" class="edit-button">Edit</button>
                            </form>
                            <form method="post" action="removeItem.php" style="display:inline;">
                                <input type="hidden" name="clothes_id" value="<?php echo $item['clothes_id']; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No clothing items available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="form-container">
        <h3>Add New Clothing Item</h3>
        <form method="post" action="addItem.php" enctype="multipart/form-data">
            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required step="0.01">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="woman">Woman</option>
                <option value="men">Men</option>
                <option value="kids">Kids</option>
            </select>
            <label for="size">Size:</label>
            <input type="text" id="size" name="size" required>
            <label for="condition">Condition:</label>
            <select id="condition" name="condition" required>
                <option value="new">New</option>
                <option value="used">Used</option>
            </select>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit" class="add-button">Add Item</button>
        </form>
    </div>
</main>
</body>
</html>
