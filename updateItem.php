<?php
session_start();
include 'DBConn.php'; // Database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: AdminLogin.php'); // Redirect to login page if not an admin
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clothes_id = $_POST['clothes_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $size = $_POST['size'];
    $condition = $_POST['condition'];

    // Check if a new image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageType = $_FILES['image']['type'];
        
        // Ensure the file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($imageType, $allowedTypes)) {
            // Move the uploaded image to the '_images' folder
            $imagePath = '_images/' . $imageName;
            if (move_uploaded_file($imageTmp, $imagePath)) {
                // File uploaded successfully
            } else {
                $error_message = "Error uploading the image.";
            }
        } else {
            $error_message = "Invalid image type. Please upload a JPEG, PNG, or GIF image.";
        }
    } else {
        // If no image is uploaded, keep the existing image
        $stmt = $db->prepare("SELECT image_url FROM tblClothes WHERE clothes_id = ?");
        $stmt->execute([$clothes_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $item['image_url'];
    }

    // Update the item in the database
    if (!isset($error_message)) {
        try {
            $stmt = $db->prepare("UPDATE tblClothes SET clothes_description = ?, price = ?, clothes_category = ?, size = ?, `condition` = ?, image_url = ? WHERE clothes_id = ?");
            $stmt->execute([$description, $price, $category, $size, $condition, $imagePath, $clothes_id]);

            // Redirect to the dashboard after update
            header('Location: admin_dashboard.php?item_updated=1');
            exit();
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>
