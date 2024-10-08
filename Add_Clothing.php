<?php
session_start();

// Initialize the cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Predefined clothing items array with image paths
$clothing_items = [
    [
        'name' => 'Dress',
        'image' => 'dress-2565292_1280.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Woman Casual Wear',
        'image' => 'woman-6771288_1280.jpg',
        'price' => 400.00,
        'description' => 'Casual wear perfect for any occasion.'
    ],
    [
        'name' => 'Shirt',
        'image' => 'shirt-2650677_1280.jpg',
        'price' => 300.00,
        'description' => 'Stylish shirt for office or casual wear.'
    ],
    [
        'name' => 'Girls Outfit',
        'image' => 'girls-462072_1280.jpg',
        'price' => 350.00,
        'description' => 'A perfect outfit for young girls.'
    ]
];

// Add an item to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $item_index = $_POST['item_index'];
    
    if (isset($clothing_items[$item_index])) {
        $item = $clothing_items[$item_index];

        // Add the item to the cart
        array_push($_SESSION['cart'], $item);

        // Redirect to avoid form re-submission
        header("Location: add_clothing.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store - Add Clothing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">View Cart (<?php echo count($_SESSION['cart']); ?>)</a></li>
        </ul>
    </nav>
</header>

<main>
    <h1>Shop Clothing</h1>
    <div class="clothing-container">
        <?php foreach ($clothing_items as $index => $item): ?>
            <div class="clothing-item">
                <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
                <p>Price: R <?php echo number_format($item['price'], 2); ?></p>

                <form method="post" action="add_clothing.php">
                    <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                    <input type="submit" name="add_to_cart" value="Add to Cart" class="button-style">
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>&copy; 2024 Pastimes. All Rights Reserved.</p>
</footer>

</body>
</html>
