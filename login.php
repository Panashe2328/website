<?php
session_start();
include 'dbconn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login']; // Can be username or email
    $password = $_POST['password'];

    // Check if the user is in the tblUser table (user role)
    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $login, $login); // Bind for both username and email
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the password matches the hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id']; // Set session ID for user
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            header("Location: index.php"); // Redirect to user dashboard or profile page
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "User does not exist.";
    }
}
?>


<!--
<?php
// Include the createTable.php script to ensure the table is created
include 'createTable.php';

// Initialize variables for sticky form
$email = '';
$password = '';
$message = '';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Include database connection
    include 'DBConn.php'; // Make sure this file contains your DB connection logic

    // Prepare and execute the query to check for the user
    $query = "SELECT UserName, Name, Surname, password, Verified FROM tbluser WHERE email = ? OR UserName = ?";
    $stmt = $dbConn->prepare($query);
    $stmt->bind_param("ss", $email, $email); // Bind both email and username to the same parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (hash('sha256', $password) === $user['password']) { // Use hash('sha256', $password) for comparison
            // Password is correct
            $message = "User " . $user['Name'] . " " . $user['Surname'] . " is logged in.";
            // You can redirect to another page or set session variables here
        } else {
            // Password is incorrect
            $message = "Incorrect password. Please try again.";
        }
    } else {
        // User not found
        $message = "No user found with that email or username.";
    }
}

// Close database connection
$dbConn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pastimes - Login</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="_images/pastimes_logo.png" alt="" width="150px">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="our_mission.php">Our Mission</a></li>
                <li><a href="browse.php">Browse Clothing</a></li>
                <li><a href="my_account.php">Account</a></li>
                <li><a href="sell_clothes.php">Sell Clothing</a></li>
                <li><a href="countact_us.php">Get in Touch</a></li>
            </ul>
        </nav>
    </header>

    <section class="login-form">
        <h2>Log into your account</h2>
        <?php if ($message) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="email">Email or Username:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <p>Don't have an account? <a href="user_registration.php">Sign up here</a>.</p>
    </section>

    <footer>
        <p>&copy; 2024 Pastimes. All rights reserved.</p>
    </footer>
</body>

</html>

-->