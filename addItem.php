<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to login page if not an admin
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $size = $_POST['size'];
    $condition = $_POST['condition'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageType = $_FILES['image']['type'];
        $imageSize = $_FILES['image']['size'];

        // Check if the file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($imageType, $allowedTypes)) {
            // Move the image to a desired folder
            $imagePath = '_images/' . $imageName;
            move_uploaded_file($imageTmp, $imagePath);
        } else {
            $error_message = "Invalid image type. Please upload a JPEG, PNG, or GIF image.";
        }
    } else {
        $error_message = "Error uploading the image.";
    }

    // Insert the clothing item into the database
    if (!isset($error_message)) {
        try {
            $stmt = $db->prepare("INSERT INTO tblClothes (clothes_description, price, clothes_category, size, `condition`, image_url) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$description, $price, $category, $size, $condition, $imagePath]);

            // Redirect to dashboard with success message
            header('Location: admin_dashboard.php?item_added=1');
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
    <title>Add Item</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Add New Clothing Item</h2>

        <!-- Display any error messages -->
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <!-- Form for adding clothing item -->
        <form method="post" action="addItem.php" enctype="multipart/form-data">
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
    </main>
</body>
</html>
