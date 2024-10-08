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
        'image' => 'black_shirt.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Woman Casual Wear',
        'image' => 'men_pants_brown.jpg',
        'price' => 400.00,
        'description' => 'Casual wear perfect for any occasion.'
    ],
    [
        'name' => 'Shirt',
        'image' => 'kids_dress1.jpg',
        'price' => 300.00,
        'description' => 'Stylish shirt for office or casual wear.'
    ],
    [
        'name' => 'Girls Outfit',
        'image' => 'women_dress_blue.jpg',
        'price' => 350.00,
        'description' => 'A perfect outfit for young girls.'
    ],
    [
        'name' => 'Dress',
        'image' => 'men_coca.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'women_dress_pink.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'kids_shirt_grey.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'women_skirt.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'men_shirt_blue.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'kids_skirt_lines.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'women_dress_dots.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'men_jeans.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Woman Casual Wear',
        'image' => 'kids_shirt_hearts.jpg',
        'price' => 400.00,
        'description' => 'Casual wear perfect for any occasion.'
    ],
    [
        'name' => 'Shirt',
        'image' => 'women_shirt_orange.jpg',
        'price' => 300.00,
        'description' => 'Stylish shirt for office or casual wear.'
    ],
    [
        'name' => 'Girls Outfit',
        'image' => 'kids_dress2.jpg',
        'price' => 350.00,
        'description' => 'A perfect outfit for young girls.'
    ],
    [
        'name' => 'Dress',
        'image' => 'men_jacket.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'women_skirt_pink.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'kids_shirt_red.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'kids_pants_green.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'men_shirt_white.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'kids_sirt_orange.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'kids_shirt_white.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Woman Casual Wear',
        'image' => 'women_jacket_brown.jpg',
        'price' => 400.00,
        'description' => 'Casual wear perfect for any occasion.'
    ],
    [
        'name' => 'Shirt',
        'image' => 'woman_shirt_white.jpg',
        'price' => 300.00,
        'description' => 'Stylish shirt for office or casual wear.'
    ],
    [
        'name' => 'Girls Outfit',
        'image' => 'women_shirt_lines.jpg',
        'price' => 350.00,
        'description' => 'A perfect outfit for young girls.'
    ],
    [
        'name' => 'Dress',
        'image' => 'women_shirt_black.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'men_jacket_purple.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'women_shirt_grey',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'kids_shirt_blue.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
    ],
    [
        'name' => 'Dress',
        'image' => 'women_shirt_white.jpg',
        'price' => 500.00,
        'description' => 'A beautiful summer dress.'
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
                <img src="_images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
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
