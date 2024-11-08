<?php
session_start();
 include 'dbconn.php';


//Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart_empty = true;
} else {
    $cart_empty = false;
}

//remove an item from the cart 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    $item_index = $_POST['item_index'];

    if (isset($_SESSION['cart'][$item_index])) {
        unset($_SESSION['cart'][$item_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); 
    }

    // Redirect to avoid form re-submission
    header("Location: cart.php");
    exit();
}
// Increase item quantity
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['increaseQuantity'])) {
    $item_index = $_POST['item_index'];

    if (isset($_SESSION['cart'][$item_index])) {
        // Increase the quantity of the item by 1 (or another logic based on your needs)
        $_SESSION['cart'][$item_index]['quantity'] += 1;
    }

    // Redirect to avoid form re-submission
    header("Location: cart.php");
    exit();
}
// Decrease item quantity
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decreaseQuantity'])) {
    $item_index = $_POST['item_index'];

    if (isset($_SESSION['cart'][$item_index]) && $_SESSION['cart'][$item_index]['quantity'] > 1) {
        // Decrease the quantity of the item by 1 (but prevent going below 1)
        $_SESSION['cart'][$item_index]['quantity'] -= 1;
    }

    // Redirect to avoid form re-submission
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Pastimes Clothing Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add_clothing.php">Shop More</a></li>
        </ul>
    </nav>
</header>

<main>
    <h1>Your Cart</h1>

    <?php if ($cart_empty): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price Per Item</th>
                    <th>Quantity</th>
                    <th>New Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $index => $item): 
                    $new_price = $item['unit_price'] * $item['quantity']; // Calculate new price using 'price' from add_clothing
                    $total += $new_price;  // Add the new price to total
                ?>
                    <tr>
                        <td>Item ID: <?= $item['clothes_id'] ?></td>
                        <td><img src="_images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['clothes_category']); ?>" width="150" height="150"></td>
                        <td><?php echo htmlspecialchars($item['clothes_category']); ?></td>
                        <td><?php echo isset($item['description']) ? htmlspecialchars($item['description']) : 'No description available'; ?></td>
                        <td>R <?php echo number_format($item['unit_price'], 2); ?></td> <!-- Updated to use 'price' -->
                        <td>
                            <?php echo $item['quantity']; ?>  <!-- Display current quantity -->
                        </td>
                        <td>R <?php echo number_format($new_price, 2); ?>  <!-- Display new price (price * quantity) -->
                        </td>
                        <td>
                            <form method="post" action="cart.php">
                                <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                <input type="submit" name="remove_item" value="Remove Item" class="button-style">
                                <input type="submit" name="increaseQuantity" value="+" class="button-style">
                                <input type="submit" name="decreaseQuantity" value="-" class="button-style">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <h3>Total: R <?php echo number_format($total, 2); ?></h3>
            <a href="checkout_redirect.php" class="button-style">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2024 Pastimes. All Rights Reserved.</p>
</footer>

</body>
</html>
