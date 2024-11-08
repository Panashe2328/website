<?php
session_start();
include 'DBConn.php'; // Database connection

// Handle form submission to add new item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $size = $_POST['size'];
    $condition = $_POST['condition'];
    $image = $_FILES['image'];

    // Check if an image file was uploaded
    if ($image && $image['tmp_name']) {
        $imagePath = '_images/' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
    } else {
        $imagePath = null;
    }

    // Insert the new item into the database
    try {
        $stmt = $db->prepare("INSERT INTO tblClothes (clothes_description, price, clothes_category, size, `condition`, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$description, $price, $category, $size, $condition, $imagePath]);
        header("Location: sell.php?item_added=1");
        exit();
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sell Clothing Item</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .add-button {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
            border-radius: 5px;
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
            <li><a href="sell.php" class="Current">Sell</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Sell Clothing Items</h2>

    <!-- Display success message if an item was added -->
    <?php if (isset($_GET['item_added']) && $_GET['item_added'] == 1): ?>
        <div class="success-message">Item added successfully.</div>
    <?php endif; ?>

    <!-- Display any error messages -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form method="post" action="sell.php" enctype="multipart/form-data">
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
