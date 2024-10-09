<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id']; // Pastikan user sudah login

    // Simpan pesan ke dalam tabel chat
    $stmt = $conn->prepare("INSERT INTO chat (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $message);

    if ($stmt->execute()) {
        echo "Pesan berhasil dikirim!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
