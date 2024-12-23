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
    // Check if the user is logged in
   
    //generate unique order number starting with ORD
    $orderNum = uniqid('ORD-');
    $userId = $_SESSION['user_id']; 
    $orderDate = date('Y-m-d'); 

    //prepare the SQL statement once outside the loop
    $sql = "INSERT INTO tblOrder (order_number, user_id, clothes_id, clothes_purchased, order_date, status, quantity, total_price) 
    VALUES (:order_number, :user_id, :clothes_id, :clothes_purchased, :order_date, 'pending', :quantity, :total_price)";

    $stmt = $db->prepare($sql);

    foreach ($cartItems as $item) {
        //bind the values for each iteration
        $stmt->bindValue(':order_number', $orderNum);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':clothes_id', $item['clothes_id'], PDO::PARAM_INT);
        $stmt->bindValue(':clothes_purchased', $item['clothes_category'], PDO::PARAM_STR);
        $stmt->bindValue(':order_date', $orderDate);
        $stmt->bindValue(':quantity', $item['quantity'], PDO::PARAM_INT);
        $stmt->bindValue(':total_price', $item['unit_price'] * $item['quantity'], PDO::PARAM_STR);

        //execute the statement
        $stmt->execute();
    }

    //clear cart after checkout (zeroed)
    unset($_SESSION['cart']);
    $checkout_success = "Checkout successful! Your order number is: " . $orderNum;
}

//show login message required
if (isset($_SESSION['login_message'])) {
    echo "<script>alert('" . $_SESSION['login_message'] . "');</script>";
    unset($_SESSION['login_message']); 
}

// Handle "AddMoreItems" button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['more'])) {
    // Redirect to add clothing page when the "AddMoreItems" button is pressed
    header("Location: add_clothing.php");
    exit();
}

// Handle "Finished" button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finished'])) {
    // Redirect to login page when the "Finished" button is pressed
    header("Location: login.php");
    exit(); 
}

// Handle Show Report action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show_report'])) {
    // Fetch user's purchase history
    $userId = $_SESSION['user_id']; 
    $sql = "SELECT * FROM tblOrder WHERE user_id = :user_id ORDER BY order_date DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $purchaseHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Pastimes Clothing Store</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .button-style {
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button-style[name="checkout"] {
            background-color: salmon;
            color: black;
        }

        .button-style[name="more"] {
            background-color: lightgreen;
            color: black;
        }

        .button-style[name="finished"] {
            background-color: lightskyblue;
            color: black;
        }

        .button-style[name="show_report"] {
            background-color: black;
            color: white;
        }

        .button-style:hover {
            opacity: 0.8;
        }

    </style>

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

<?php
//login required message 
if (isset($_SESSION['login_message'])) {
    echo "<div class='alert-message'>" . $_SESSION['login_message'] . "</div>";
    unset($_SESSION['login_message']); // Clear the session variable after showing the message
}
?>

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
        <button type="submit" name="more" class="button-style">AddMoreItems</button>
        <button type="submit" name="finished" class="button-style">Finished</button>
    </form>
<?php endif; ?>

<!-- Show Report Button -->
<form method="post">
    <button type="submit" name="show_report" class="button-style">Show Report</button>
</form>

<?php if (isset($purchaseHistory)): ?>
    <h2>Your Purchase History</h2>
    <table>
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Clothes Purchased</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseHistory as $history): ?>
                <tr>
                    <td><?php echo htmlspecialchars($history['order_number']); ?></td>
                    <td><?php echo htmlspecialchars($history['clothes_purchased']); ?></td>
                    <td><?php echo $history['quantity']; ?></td>
                    <td>R <?php echo number_format($history['total_price'], 2); ?></td>
                    <td><?php echo $history['order_date']; ?></td>
                    <td><?php echo ucfirst($history['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</main>

<footer>
<p>&copy; 2024 Pastimes. All Rights Reserved.</p>
</footer>

</body>
</html>
