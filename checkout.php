<?php
session_start();

// Check if the order number is set (which means the user is logged in and has a session)
if (!isset($_SESSION['order_num']) || !isset($_SESSION['session_id'])) {
    // Redirect if something is missing
    header("Location: cart.php");
    exit;
}

$orderNum = $_SESSION['order_num'];
$sessionId = $_SESSION['session_id'];
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
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add_clothing.php">Shop More</a></li>
        </ul>
    </nav>
</header>

<main>
    <h1>Checkout</h1>

    <p>Your order number is: <strong><?php echo htmlspecialchars($orderNum); ?></strong></p>
    <p>Your session ID is: <strong><?php echo htmlspecialchars($sessionId); ?></strong></p>

    <!-- You can add more checkout steps here, such as payment options, delivery details, etc. -->
    
    <div class="checkout-summary">
        <a href="login.php" class="button-style">Login/Register</a>
    </div>
</main>

<footer>
    <p>&copy; 2024 Pastimes. All Rights Reserved.</p>
</footer>

</body>
</html>
