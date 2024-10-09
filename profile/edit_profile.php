<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection file
include '../koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: main/login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data exists
if ($result->num_rows === 0) {
    echo "User not found!";
    exit();
}

$user = $result->fetch_assoc();

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // Make sure this matches with input form name
    $alamat = $_POST['alamat']; // Make sure this matches with input form name

    // Update user profile in the database
    $stmt = $conn->prepare("UPDATE users SET username = ?, alamat = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $alamat, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success_message = "Profile updated successfully!";
        // Refresh user data after the update
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    } else {
        $success_message = "No changes made to your profile.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        
        <!-- Show success message after update -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="form">
            <div class="field">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
            </div>
            <div class="field">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($user['alamat'] ?? ''); ?>" required>
            </div>
            <div class="form .btn">
                <button type="submit" class="button1">Update</button>
                <a href="../main/index.php" class="button2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
