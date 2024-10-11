<?php
session_start(); // Memulai sesi

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

include '../koneksi.php'; // Menyertakan file koneksi database

// Proses ketika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat']; // Tambahkan alamat

    // Update data pengguna di database
    $stmt = $conn->prepare("UPDATE users SET username = ?, nomor_telepon = ?, alamat = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $nomor_telepon, $alamat, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman index
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error; // Tampilkan kesalahan jika ada
    }
    $stmt->close();
}

// Ambil data pengguna dari database
$stmt = $conn->prepare("SELECT username, nomor_telepon, alamat FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah pengguna ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->
</head>
<body>
    <div class="container">
        <h1>Edit Profil</h1>
        <form method="POST">
            <div>
                <label for="username">Nama Pengguna:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div>
                <label for="nomor_telepon">Telepon:</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" value="<?php echo htmlspecialchars($user['nomor_telepon']); ?>" required>
            </div>
            <div>
                <label for="alamat">Alamat:</label>
                <input type="text" name="alamat" id="alamat" value="<?php echo htmlspecialchars($user['alamat']); ?>" required> <!-- Tambahkan input untuk alamat -->
            </div>
            <button type="submit">Simpan</button>
            <a href="../main/index.php">Batal</a>
        </form>
        <form method="POST" action="../items/process_open_lapak.php">
            <button type="submit">Buka Lapak</button>
        </form>
    </div>
</body>
</html>
