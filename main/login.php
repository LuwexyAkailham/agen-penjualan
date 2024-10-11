<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Determine if it's a login or sign-up action
    $action = $_POST['action'];

    // Login Action
    if ($action == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['user_role'] = $user['user_role'];
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Invalid password. Please try again.";
            }
        } else {
            $error_message = "No user found with this username.";
        }
    }

    // Signup Action
    if ($action == 'signup') {
        $name = $_POST['username'];
        $alamat = $_POST['alamat'];
        $nomer = $_POST['nomor_telepon'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Correct SQL query and bind the parameters
        $stmt = $conn->prepare("INSERT INTO users (username, password, alamat, nomor_telepon, user_role) VALUES (?, ?, ?, ?, 'user')");
        $stmt->bind_param("ssss", $name, $password, $alamat, $nomer);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $name;
            $_SESSION['user_role'] = 'user';
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Error during sign-up. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        /* Add the CSS provided in the design */
        .wrapper { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card-switch { position: relative; }
        .switch { position: relative; width: 300px; height: 200px; display: block; }
        .slider, .card-side, .flip-card__inner { transition: 0.4s ease; }
        .flip-card__inner { position: absolute; width: 100%; height: 100%; display: flex; }
        .flip-card__front, .flip-card__back { position: absolute; width: 100%; height: 100%; backface-visibility: hidden; padding: 20px; }
        .flip-card__front { background-color: #f1f1f1; z-index: 2; }
        .flip-card__back { background-color: #fff; transform: rotateY(180deg); }
        .switch input[type="checkbox"]:checked ~ .flip-card__inner { transform: rotateY(180deg); }
        .flip-card__input { width: 100%; margin: 10px 0; padding: 10px; }
        .flip-card__btn { width: 100%; padding: 10px; background-color: #007BFF; color: #fff; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card-switch">
            <label class="switch">
               <input class="toggle" type="checkbox">
               <span class="slider"></span>
               <span class="card-side"></span>
               <div class="flip-card__inner">
                  <!-- Login Form -->
                  <div class="flip-card__front">
                     <div class="title">Log in</div>
                     <form action="" method="POST" class="flip-card__form">
                        <input type="hidden" name="action" value="login">
                        <input type="text" placeholder="Username" name="username" class="flip-card__input" required>
                        <input type="password" placeholder="Password" name="password" class="flip-card__input" required>
                        <button type="submit" class="flip-card__btn">Let`s go!</button>
                     </form>
                  </div>
                  
                  <!-- Sign-up Form -->
                  <div class="flip-card__back">
                     <div class="title">Sign up</div>
                     <form action="" method="POST" class="flip-card__form">
                        <input type="hidden" name="action" value="signup">
                        <input type="text" placeholder="Username" name="username" class="flip-card__input" required>
                        <input type="password" placeholder="Password" name="password" class="flip-card__input" required>
                        <input type="text" placeholder="Alamat" name="alamat" class="flip-card__input" required>
                        <input type="text" placeholder="Nomor Telepon" name="nomor_telepon" class="flip-card__input" required>
                        <button type="submit" class="flip-card__btn">Confirm!</button>
                     </form>
                  </div>
               </div>
            </label>
        </div>   
    </div>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>
</html>
