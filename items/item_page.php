<?php
session_start();
include '../koneksi.php'; // Koneksi ke database

$item_id = $_GET['id']; // Ambil ID item dari URL

// Ambil pesan dari database
$stmt = $conn->prepare("SELECT * FROM chat WHERE user_id = ? ORDER BY timestamp DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="chat-history">';
while ($row = $result->fetch_assoc()) {
    echo '<div class="chat-message">';
    echo '<p><strong>' . htmlspecialchars($row['message']) . '</strong></p>';
    echo '<small>' . $row['timestamp'] . '</small>';
    echo '</div>';
}
echo '</div>';

$stmt->close();
$conn->close();
?>
