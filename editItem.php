<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to login page if not an admin
    exit();
}

// Fetch the item details based on the item ID passed in the URL
if (isset($_POST['clothes_id'])) {
    $clothes_id = $_POST['clothes_id'];
    
    try {
        $stmt = $db->prepare("SELECT * FROM tblClothes WHERE clothes_id = ?");
        $stmt->execute([$clothes_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$item) {
            $error_message = "Item not found!";
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
} else {
    $error_message = "No item selected for editing!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="style.css">
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
        </ul>
    </nav>
</header>

<main>
    <h2>Edit Item</h2>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <?php if (isset($item)): ?>
        <form method="post" action="updateItem.php" enctype="multipart/form-data">
            <input type="hidden" name="clothes_id" value="<?php echo $item['clothes_id']; ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($item['clothes_description']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required step="0.01" value="<?php echo htmlspecialchars($item['price']); ?>">

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="woman" <?php echo $item['clothes_category'] === 'woman' ? 'selected' : ''; ?>>Woman</option>
                <option value="men" <?php echo $item['clothes_category'] === 'men' ? 'selected' : ''; ?>>Men</option>
                <option value="kids" <?php echo $item['clothes_category'] === 'kids' ? 'selected' : ''; ?>>Kids</option>
            </select>

            <label for="size">Size:</label>
            <input type="text" id="size" name="size" required value="<?php echo htmlspecialchars($item['size']); ?>">

            <label for="condition">Condition:</label>
            <select id="condition" name="condition" required>
                <option value="new" <?php echo $item['condition'] === 'new' ? 'selected' : ''; ?>>New</option>
                <option value="used" <?php echo $item['condition'] === 'used' ? 'selected' : ''; ?>>Used</option>
            </select>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <br>
            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="Current Image" style="width: 100px; height: auto;">
            <br>

            <button type="submit" class="add-button">Update Item</button>
        </form>
    <?php endif; ?>
</main>
</body>
</html>
