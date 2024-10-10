<?php
session_start();
include 'dbconn.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch item details if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM clothing_items WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "Item not found.";
        exit();
    }
} else {
    echo "No ID provided.";
    exit();
}

if (isset($_POST['update'])) {
    $itemName = $_POST['itemName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Update item details
    $stmt = $conn->prepare("UPDATE clothing_items SET itemName=?, description=?, price=?, quantity=? WHERE id=?");
    $stmt->bind_param("ssdii", $itemName, $description, $price, $quantity, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating item.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
</head>
<body>
<h2>Edit Item</h2>
<form method="post" action="edit_item.php?id=<?php echo $id; ?>">
    <input type="text" name="itemName" value="<?php echo htmlspecialchars($item['itemName']); ?>" required>
    <textarea name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea>
    <input type="number" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" step="0.01" required>
    <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
    <input type="submit"
