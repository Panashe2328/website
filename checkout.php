<?php
session_start();
include 'dbconn.php';

// Check if cart has items and calculate total
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "No items found in cart. <a href='cart.php'>Go back to cart</a>";
    exit();
}

// Initialize variables for checkout
$cartItems = $_SESSION['cart'];
$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['unit_price'] * $item['quantity'];
}

// Handle checkout action when the "Checkout" button is pressed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Generate unique order number
    $orderNum = uniqid('ORD-');
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in session after login
    $orderDate = date('Y-m-d'); // Current date as order date

    // Prepare the SQL statement once outside the loop
    $sql = "INSERT INTO tblOrder (order_number, user_id, clothes_id, clothes_purchased, order_date, status, quantity, total_price) 
    VALUES (:order_number, :user_id, :clothes_id, :clothes_purchased, :order_date, 'pending', :quantity, :total_price)";

    $stmt = $db->prepare($sql);

    foreach ($cartItems as $item) {
    // Bind the values for each iteration
    $stmt->bindValue(':order_number', $orderNum);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':clothes_id', $item['clothes_id'], PDO::PARAM_INT); // This line retrieves the actual clothes_id from the cart
    $stmt->bindValue(':clothes_purchased', $item['clothes_category'], PDO::PARAM_STR); // Assuming 'clothes_category' is item name
    $stmt->bindValue(':order_date', $orderDate);
    $stmt->bindValue(':quantity', $item['quantity'], PDO::PARAM_INT);
    $stmt->bindValue(':total_price', $item['unit_price'] * $item['quantity'], PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();
    }

    // Clear cart after checkout
    unset($_SESSION['cart']);
    $checkout_success = "Checkout successful! Your order number is: " . $orderNum;

}

// Handle "Finished" button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finished'])) {
    // Redirect to login page when the "Finished" button is pressed
    header("Location: login.php");
    exit(); // Ensure no further code is executed after the redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Pastimes Clothing Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="_images/Pastimes_logo.jpg" alt="Pastimes logo">
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.php">About</a></li>
            <li><a href="admin_dashboard.php" class="Current"> Dashboard</a></li>
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
<h1>Checkout</h1>

<?php if (isset($checkout_success)): ?>
    <p class="success"><?php echo $checkout_success; ?></p>
    <h2>Order Summary</h2>
    <p><strong>Order Number:</strong> <?php echo $orderNum; ?></p>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price Per Item</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['clothes_category']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>R <?php echo number_format($item['unit_price'], 2); ?></td>
                    <td>R <?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total Amount:</strong></td>
                <td>R <?php echo number_format($totalAmount, 2); ?></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <!-- Display Cart Summary before checkout -->
    <h2>Order Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price Per Item</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['clothes_category']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>R <?php echo number_format($item['unit_price'], 2); ?></td>
                    <td>R <?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total Amount:</strong></td>
                <td>R <?php echo number_format($totalAmount, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Checkout and Finished Buttons -->
    <form method="post">
        <button type="submit" name="checkout" class="button-style">Checkout</button>
        <button type="submit" name="finished" class="button-style">Finished</button>
    </form>
<?php endif; ?>
</main>

<footer>
<p>&copy; 2024 Pastimes. All Rights Reserved.</p>
</footer>

</body>
</html>
