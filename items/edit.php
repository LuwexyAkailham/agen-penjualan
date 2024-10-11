<?php
session_start(); // Memulai sesi
include '../koneksi.php'; // Menyertakan koneksi database

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to edit items.";
    exit();
}

$item_id = $_GET['item_id'];
$user_id = $_SESSION['user_id']; // Mengambil user_id dari sesi

// Cek apakah item tersebut dimiliki oleh user yang login
$stmt = $conn->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $item_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Anda tidak memiliki hak untuk mengedit item ini.";
    exit();
}

$item = $result->fetch_assoc(); // Mengambil data item untuk diedit

// Jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $image_url = $_POST['image_url'];
    $kategori = $_POST['kategori'];

    // Update item di database
    $stmt = $conn->prepare("UPDATE items SET name = ?, harga = ?, deskripsi = ?, lokasi = ?, image_url = ?, kategori = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssssssii", $name, $harga, $deskripsi, $lokasi, $image_url, $kategori, $item_id, $user_id);

    if ($stmt->execute()) {
        echo "Item berhasil diperbarui!";
    } else {
        echo "Terjadi kesalahan saat memperbarui item: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form method="POST" action="">
        Nama: <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>"><br>
        Harga: <input type="text" name="harga" value="<?php echo htmlspecialchars($item['harga']); ?>"><br>
        Deskripsi: <textarea name="deskripsi"><?php echo htmlspecialchars($item['deskripsi']); ?></textarea><br>
        Lokasi: <input type="text" name="lokasi" value="<?php echo htmlspecialchars($item['lokasi']); ?>"><br>
        Image URL: <input type="text" name="image_url" value="<?php echo htmlspecialchars($item['image_url']); ?>"><br>
        Kategori: <input type="text" name="kategori" value="<?php echo htmlspecialchars($item['kategori']); ?>"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
