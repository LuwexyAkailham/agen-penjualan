<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}

// Cek jika metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $user_id = $_SESSION['user_id'];
    $jumlah = 1;

    // Simpan transaksi
    $stmt = $conn->prepare("INSERT INTO transaksi (item_id, user_id, jumlah) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $item_id, $user_id, $jumlah);

    $stmt->close();
}
$conn->close();
?>

<div class="chat-box">
    <form method="POST" action="../chat/chat.php">
        <textarea name="message" placeholder="Tanya kepada admin..." required></textarea>
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <button type="submit">Kirim</button>
    </form>
</div>

