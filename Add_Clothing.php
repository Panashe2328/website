
<?php
session_start();

//initialize the cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

//predefined clothing items array with image paths and descriptions
$clothing_items = [
    [
        'name' => 'Women',
        'image' => 'black_shirt.jpg',
        'size' => 'M',
        'price' => 125.00,
        'description' => 'Black t-shirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Men',
        'image' => 'men_pants_brown.jpg',
        'size' => 'S',
        'price' => 250.00,
        'description' => 'Brown formal pants',
        'condition' => 'new'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_dress1.jpg',
        'size' => 'S',
        'price' => 165.00,
        'description' => 'Colourful dress',
        'condition' => 'good'
    ],
    [
        'name' => 'Women',
        'image' => 'women_dress_blue.jpg',
        'size' => 'S',
        'price' => 185.00,
        'description' => 'Blue summer dress',
        'condition' => 'good'
    ],
    [
        'name' => 'Men',
        'image' => 'men_coca.jpg',
        'size' => 'M',
        'price' => 90.00,
        'description' => 'A white Coca-Cola t-shirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Women',
        'image' => 'women_dress_pink.jpg',
        'size' => 'S',
        'price' => 150.00,
        'description' => 'Pink summer dress',
        'condition' => 'new'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_shirt_grey.jpg',
        'size' => 'XS',
        'price' => 80.00,
        'description' => 'Grey t-shirt with animals',
        'condition' => 'new'
    ],
    [
        'name' => 'Women',
        'image' => 'women_skirt.jpg',
        'size' => 'S',
        'price' => 120.00,
        'description' => 'Red skirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Men',
        'image' => 'men_shirt_blue.jpg',
        'size' => 'M',
        'price' => 150.00,
        'description' => 'Blue buttoned shirt',
        'condition' => 'new'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_skirt_lines.jpg',
        'size' => 'S',
        'price' => 90.00,
        'description' => 'Black and white skirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Women',
        'image' => 'women_dress_dots.jpg',
        'size' => 'S',
        'price' => 250.00,
        'description' => 'Blue dotted dress',
        'condition' => 'new'
    ],
    [
        'name' => 'Men',
        'image' => 'men_jeans.jpg',
        'size' => 'M',
        'price' => 180.00,
        'description' => 'Blue jeans',
        'condition' => 'good'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_shirt_hearts.jpg',
        'size' => 'S',
        'price' => 95.00,
        'description' => 'Shirt with hearts',
        'condition' => 'new'
    ],
    [
        'name' => 'Women',
        'image' => 'women_shirt_orange.jpg',
        'size' => 'S',
        'price' => 300.00,
        'description' => 'Orange shirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_dress2.jpg',
        'size' => 'XS',
        'price' => 350.00,
        'description' => 'White dress',
        'condition' => 'good'
    ],
    [
        'name' => 'Men',
        'image' => 'men_jacket.jpg',
        'size' => 'L',
        'price' => 400.00,
        'description' => 'Green jacket',
        'condition' => 'new'
    ],
    [
        'name' => 'Women',
        'image' => 'women_skirt_pink.jpg',
        'size' => 'M',
        'price' => 140.00,
        'description' => 'Long skirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_shirt_red.jpg',
        'size' => 'S',
        'price' => 115.00,
        'description' => 'Long sleeve red shirt',
        'condition' => 'new'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_pants_green.jpg',
        'size' => 'S',
        'price' => 125.00,
        'description' => 'Green pants',
        'condition' => 'new'
    ],
    [
        'name' => 'Men',
        'image' => 'men_shirt_white.jpg',
        'size' => 'L',
        'price' => 150.00,
        'description' => 'White shirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_sirt_orange.jpg',
        'size' => 'M',
        'price' => 90.00,
        'description' => 'Orange skirt',
        'condition' => 'new'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_shirt_white.jpg',
        'size' => 'S',
        'price' => 200.00,
        'description' => 'Grey shirt',
        'condition' => 'new'
    ],
    [
        'name' => 'Women',
        'image' => 'women_jacket_brown.jpg',
        'size' => 'M',
        'price' => 250.00,
        'description' => 'Light brown jacket',
        'condition' => 'new'
    ],
    [
        'name' => 'Women',
        'image' => 'woman_shirt_white.jpg',
        'size' => 'L',
        'price' => 170.00,
        'description' => 'White shirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Women',
        'image' => 'women_shirt_lines.jpg',
        'size' => 'M',
        'price' => 120.00,
        'description' => 'Shirt with lines',
        'condition' => 'good'
    ],
    [
        'name' => 'Women',
        'image' => 'women_shirt_black.jpg',
        'size' => 'S',
        'price' => 85.00,
        'description' => 'Black shirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Men',
        'image' => 'men_jacket_purple.jpg',
        'size' => 'M',
        'price' => 450.00,
        'description' => 'Purple jacket',
        'condition' => 'new'
    ],
    [
        'name' => 'Women',
        'image' => 'women_shirt_grey.jpg',
        'size' => 'S',
        'price' => 60.00,
        'description' => 'Grey sirt',
        'condition' => 'good'
    ],
    [
        'name' => 'Kids',
        'image' => 'kids_shirt_blue.jpg',
        'size' => 'S',
        'price' => 95.00,
        'description' => 'Blue shirt',
        'condition' => 'new'
    ],
    [
        'name' => 'Women',
        'image' => 'women_shirt_white.jpg',
        'size' => 'L',
        'price' => 250.00,
        'description' => 'White shirt',
        'condition' => 'new'
    ]
];

//add an item to the cart using array_push() function
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
    <script>
        //show pop up message of price item
        function showPrice(price) {
            alert('Price: R ' + price.toFixed(2));
        }
    </script>
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
                <img src="_images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" height="150" width="140">
                <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
                <p>Price: R <?php echo number_format($item['price'], 2); ?></p>
                <p>Condition: <?php echo htmlspecialchars($item['condition']); ?></p>

                <form method="post" action="add_clothing.php" onsubmit="showPrice(<?php echo $item['price']; ?>);">
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