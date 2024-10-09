<?php
session_start();
include '../koneksi.php';

$user_id = $_SESSION['user_id']; // Pastikan user sudah login

// Ambil semua pesan dari tabel chat
$sql = "SELECT c.message, u.username FROM chat c JOIN users u ON c.user_id = u.id ORDER BY c.id ASC";
$result = $conn->query($sql);

// Tampilkan pesan dalam format HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="chat-message"><p><strong>' . htmlspecialchars($row['username']) . ':</strong> ' . htmlspecialchars($row['message']) . '</p></div>';
    }
} else {
    echo '<p>No messages yet.</p>';
}

$conn->close();
?>
