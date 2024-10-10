<?php

session_start(); // Start the session
 include 'dbconn.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch user details if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "No ID provided.";
    exit();
}

if (isset($_POST['update'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user details
    $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("ssssi", $fName, $lName, $email, $role, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
<h2>Edit User</h2>
<form method="post" action="edit_user.php?id=<?php echo $id; ?>">
    <input type="text" name="fName" value="<?php echo htmlspecialchars($user['firstName']); ?>" required>
    <input type="text" name="lName" value="<?php echo htmlspecialchars($user['lastName']); ?>" required>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <select name="role" required>
        <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
        <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
    </select>
    <input type="submit" name="update" value="Update User">
</form>
</body>
</html>
