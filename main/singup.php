<?php
session_start(); // Memulai sesi
include '../koneksi.php'; // Menyertakan koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Siapkan statement untuk menambahkan pengguna baru
    $stmt = $conn->prepare("INSERT INTO users (username, password, user_role, alamat, nomor_telepon) VALUES (?, ?, 'user', ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $alamat, $nomor_telepon);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil. Silakan login.";
        // Redirect ke halaman login jika perlu
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS file -->
</head>
<body>
<div class="card">
    <div class="card2">
        <form class="form" method="POST" action="">
            <p id="heading">Sign Up</p>
            <div class="field">
                <input type="text" name="username" class="input-field" placeholder="Username" required>
            </div>
            <div class="field">
                <input type="password" name="password" class="input-field" placeholder="Password" required>
            </div>
            <div class="field">
                <input type="text" name="alamat" class="input-field" placeholder="Alamat" required>
            </div>
            <div class="field">
                <input type="text" name="nomor_telepon" class="input-field" placeholder="Nomor Telepon" required>
            </div>
            <div class="btn">
                <button type="submit" class="button1">Sign Up</button>
                <a href="login.php" class="button2">Login</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
