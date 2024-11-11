
<?php
session_start();

//initialize the cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

//predefined clothing items array with image paths and descriptions
$clothing_items = [
    [
        'clothes_id' => 11011,
        'name' => 'Women',
        'image' => 'black_shirt.jpg',
        'size' => 'M',
        'price' => 125.00,
        'description' => 'Black t-shirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11012,
        'name' => 'Men',
        'image' => 'men_pants_brown.jpg',
        'size' => 'S',
        'price' => 250.00,
        'description' => 'Brown formal pants',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11013,
        'name' => 'Kids',
        'image' => 'kids_dress1.jpg',
        'size' => 'S',
        'price' => 165.00,
        'description' => 'Colourful dress',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11014,
        'name' => 'Women',
        'image' => 'women_dress_blue.jpg',
        'size' => 'S',
        'price' => 185.00,
        'description' => 'Blue summer dress',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11015,
        'name' => 'Men',
        'image' => 'men_coca.jpg',
        'size' => 'M',
        'price' => 90.00,
        'description' => 'A white Coca-Cola t-shirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11016,
        'name' => 'Women',
        'image' => 'women_dress_pink.jpg',
        'size' => 'S',
        'price' => 150.00,
        'description' => 'Pink summer dress',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11017,
        'name' => 'Kids',
        'image' => 'kids_shirt_grey.jpg',
        'size' => 'XS',
        'price' => 80.00,
        'description' => 'Grey t-shirt with animals',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11018,
        'name' => 'Women',
        'image' => 'women_skirt.jpg',
        'size' => 'S',
        'price' => 120.00,
        'description' => 'Red skirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11019,
        'name' => 'Men',
        'image' => 'men_shirt_blue.jpg',
        'size' => 'M',
        'price' => 150.00,
        'description' => 'Blue buttoned shirt',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11020,
        'name' => 'Kids',
        'image' => 'kids_skirt_lines.jpg',
        'size' => 'S',
        'price' => 90.00,
        'description' => 'Black and white skirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11021,
        'name' => 'Women',
        'image' => 'women_dress_dots.jpg',
        'size' => 'S',
        'price' => 250.00,
        'description' => 'Blue dotted dress',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11022,
        'name' => 'Men',
        'image' => 'men_jeans.jpg',
        'size' => 'M',
        'price' => 180.00,
        'description' => 'Blue jeans',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11023,
        'name' => 'Kids',
        'image' => 'kids_shirt_hearts.jpg',
        'size' => 'S',
        'price' => 95.00,
        'description' => 'Shirt with hearts',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11024,
        'name' => 'Women',
        'image' => 'women_shirt_orange.jpg',
        'size' => 'S',
        'price' => 300.00,
        'description' => 'Orange shirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11025,
        'name' => 'Kids',
        'image' => 'kids_dress2.jpg',
        'size' => 'XS',
        'price' => 350.00,
        'description' => 'White dress',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11026,
        'name' => 'Men',
        'image' => 'men_jacket.jpg',
        'size' => 'L',
        'price' => 400.00,
        'description' => 'Green jacket',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11027,
        'name' => 'Women',
        'image' => 'women_skirt_pink.jpg',
        'size' => 'M',
        'price' => 140.00,
        'description' => 'Long skirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11028,
        'name' => 'Kids',
        'image' => 'kids_shirt_red.jpg',
        'size' => 'S',
        'price' => 115.00,
        'description' => 'Long sleeve red shirt',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11029,
        'name' => 'Kids',
        'image' => 'kids_pants_green.jpg',
        'size' => 'S',
        'price' => 125.00,
        'description' => 'Green pants',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11030,
        'name' => 'Men',
        'image' => 'men_shirt_white.jpg',
        'size' => 'L',
        'price' => 150.00,
        'description' => 'White shirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11031,
        'name' => 'Kids',
        'image' => 'kids_sirt_orange.jpg',
        'size' => 'M',
        'price' => 90.00,
        'description' => 'Orange skirt',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11032,
        'name' => 'Kids',
        'image' => 'kids_shirt_white.jpg',
        'size' => 'S',
        'price' => 200.00,
        'description' => 'Grey shirt',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11033,
        'name' => 'Women',
        'image' => 'women_jacket_brown.jpg',
        'size' => 'M',
        'price' => 250.00,
        'description' => 'Light brown jacket',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11034,
        'name' => 'Women',
        'image' => 'woman_shirt_white.jpg',
        'size' => 'L',
        'price' => 170.00,
        'description' => 'White shirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11035,
        'name' => 'Women',
        'image' => 'women_shirt_lines.jpg',
        'size' => 'M',
        'price' => 120.00,
        'description' => 'Shirt with lines',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11036,
        'name' => 'Women',
        'image' => 'women_shirt_black.jpg',
        'size' => 'S',
        'price' => 85.00,
        'description' => 'Black shirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11037,
        'name' => 'Men',
        'image' => 'men_jacket_purple.jpg',
        'size' => 'M',
        'price' => 450.00,
        'description' => 'Purple jacket',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11038,
        'name' => 'Women',
        'image' => 'women_shirt_grey.jpg',
        'size' => 'S',
        'price' => 60.00,
        'description' => 'Grey sirt',
        'condition' => 'good'
    ],
    [
        'clothes_id' => 11040,
        'name' => 'Kids',
        'image' => 'kids_shirt_blue.jpg',
        'size' => 'S',
        'price' => 95.00,
        'description' => 'Blue shirt',
        'condition' => 'new'
    ],
    [
        'clothes_id' => 11041,
        'name' => 'Women',
        'image' => 'women_shirt_white.jpg',
        'size' => 'L',
        'price' => 250.00,
        'description' => 'White shirt',
        'condition' => 'new'
    ]
];

// Add an item to the cart when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $item_index = $_POST['item_index'];
    
    if (isset($clothing_items[$item_index])) {
        $item = $clothing_items[$item_index];
        $clothes_id = $item_index; // Use item index as product_id
        $price = $item['price']; // Use item price as product price
        $description = $item['description']; // Get the description
        $image_url = $item['image']; // Get the image URL

        // Check if item already exists in the cart
        $found = false; // Flag to check if item is already in the cart
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['clothes_id'] == $clothes_id) {
                // Item exists, increase quantity
                $cart_item['quantity'] += 1;
                $cart_item['total_price'] = $cart_item['quantity'] * $price;
                $found = true;
                break;
            }
        }

        // If item doesn't exist, use array_push to add it
        if (!$found) {
            array_push($_SESSION['cart'], [
                'clothes_id' => $item['clothes_id'],
                'clothes_category' => $item['name'], // Using category as name
                'quantity' => 1,
                'unit_price' => $price,
                'total_price' => $price,
                'description' => $description, // Add description here
                'image' => $image_url // Add image here
            ]);
        }

        // Redirect to avoid form re-submission
        header("Location: add_clothing.php");
        exit();
    }
}

// Calculate total cart value (optional)
$total_cart_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_cart_price += $item['total_price'];
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
        // Show pop up message of price item
        function showPrice(price) {
            alert('Price: R ' + price.toFixed(2));
        }

        function searchFunction() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let results = document.getElementById("results");
    results.innerHTML = ""; // Clear previous results

    // If the input is empty, show all clothing items
    const itemsToDisplay = input 
        ? clothing_items.filter(item =>
            item.name.toLowerCase().includes(input) ||
            item.description.toLowerCase().includes(input)
          )
        : clothing_items; // Show all items when input is empty

    itemsToDisplay.forEach(item => {
        let li = document.createElement("li");
        li.textContent = `${item.name} - ${item.description} - R ${item.price.toFixed(2)}`;
        results.appendChild(li);
    });
}

        // Sample clothing items data (can be dynamically generated from PHP)
        const clothing_items = <?php echo json_encode($clothing_items); ?>;
    </script>
</head>
<body>
<header>
    <!-- Navigation -->
    <div class="logo">
        <img src="_images/Pastimes_logo.jpg" alt="Pastimes logo">
    </div>
    
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">Show Cart (<?php echo count($_SESSION['cart']); ?>)</a></li>
            <li><a href="user_register.php">Register</a></li>
            <li><a href="login.php">Admin</a></li>
        </ul>
    </nav>
    <div class="header-icons">
        <i class="fas fa-search"></i>
        <i class="fas fa-heart"></i>
        <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
        <i class="fas fa-user"></i>
    </div>
</header>

<main>
    <h1>Shop Clothing</h1>

    <!-- Search Bar -->
    <div>
        <input type="text" id="searchInput" placeholder="Search clothing..." oninput="searchFunction()">
        <ul id="results"></ul>
    </div>

    <!-- Clothing Items Display -->
    <div class="clothing-container">
    <?php foreach ($clothing_items as $index => $item): ?>
    <div class="clothing-item">
        <img src="_images/<?php echo $item['image']; ?>" alt="<?php echo $item['description']; ?>" height="160" width="140">
        <h3><?php echo $item['description']; ?></h3>
        <p>Price: R <?php echo number_format($item['price'], 2); ?></p>
        <form action="add_clothing.php" method="POST">
            <input type="hidden" name="item_index" value="<?php echo $index; ?>">
            <button class="add-to-cart" type="submit" name="add_to_cart">Add to Cart</button>
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
