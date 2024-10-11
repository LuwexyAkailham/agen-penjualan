<?php
session_start(); // Memulai sesi
include '../koneksi.php'; // Menyertakan koneksi database

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to add items.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];

    // Menangani upload gambar
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../uploads/"; // Folder untuk menyimpan gambar
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        // Cek apakah file adalah gambar
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Memindahkan file ke folder yang ditentukan
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file; // Simpan path gambar untuk database
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
    
    $kategori = $_POST['kategori'];
    $user_id = $_SESSION['user_id']; // Menyimpan user_id dari sesi

    // Insert item ke dalam database
    $stmt = $conn->prepare("INSERT INTO items (name, harga, deskripsi, lokasi, image_url, kategori, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $name, $harga, $deskripsi, $lokasi, $image_url, $kategori, $user_id);

    if ($stmt->execute()) {
        echo "Item berhasil ditambahkan!";
    } else {
        echo "Terjadi kesalahan saat menambahkan item: " . $conn->error;
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
    <title>Tambah Item</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../main/style.css"> <!-- Link to CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .custom-select {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .select-selected {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .select-items {
            position: absolute;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            z-index: 99;
            display: none;
        }
        .select-items div {
            padding: 10px;
            cursor: pointer;
        }
        .select-items div:hover {
            background-color: #ddd;
        }
        .icon {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Item</h1>
        <form method="POST" action="" enctype="multipart/form-data"> <!-- Menambahkan enctype -->
            <input type="text" name="name" placeholder="Nama Item" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi" required>
            <input type="text" name="harga" placeholder="Harga" required>
            <input type="text" name="lokasi" placeholder="Lokasi" required>
            
            <!-- Input untuk upload gambar -->
            <input type="file" name="image" accept="image/*" required> <!-- Input file untuk gambar -->
            
            <!-- Custom dropdown for category -->
            <div class="custom-select">
                <div class="select-selected">Pilih Kategori</div>
                <div class="select-items">
                    <div data-value="Elektronik">
                        <i class="fas fa-plug icon"></i> Elektronik
                    </div>
                    <div data-value="Akun Game">
                        <i class="fas fa-gamepad icon"></i> Akun Game
                    </div>
                    <div data-value="Kendaraan">
                        <i class="fas fa-car icon"></i> Kendaraan
                    </div>
                    <div data-value="Gadget">
                        <i class="fas fa-mobile-alt icon"></i> Gadget
                    </div>
                </div>
                <input type="hidden" name="kategori" id="kategori">
            </div>

            <button type="submit" name="add_item">Tambah Item</button>
        </form>
    </div>

    <script>
        // Custom select script
        document.addEventListener("DOMContentLoaded", function() {
            const selected = document.querySelector(".select-selected");
            const items = document.querySelector(".select-items");
            const kategoriInput = document.getElementById("kategori");

            selected.addEventListener("click", function() {
                items.style.display = items.style.display === "block" ? "none" : "block";
            });

            items.querySelectorAll("div").forEach(item => {
                item.addEventListener("click", function() {
                    selected.textContent = this.textContent;
                    kategoriInput.value = this.getAttribute("data-value");
                    items.style.display = "none";
                });
            });

            document.addEventListener("click", function(e) {
                if (!e.target.matches('.custom-select, .custom-select *')) {
                    items.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
