<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include '../koneksi.php';

// Handle form submission for adding a new item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $lokasi = $_POST['lokasi'];
    $image_url = $_POST['image_url'];
    $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : ''; // Check if 'kategori' exists

    // Prepare and execute insert statement
    $stmt = $conn->prepare("INSERT INTO items (deskripsi, harga, lokasi, image_url, kategori) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $deskripsi, $harga, $lokasi, $image_url, $kategori);
    $stmt->execute();
    $stmt->close();
    // Redirect back to main page after adding
    header("Location: ../main/index.php");
    exit;
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
        <form method="POST" action="">
            <input type="text" name="deskripsi" placeholder="Deskripsi" required>
            <input type="text" name="harga" placeholder="Harga" required>
            <input type="text" name="lokasi" placeholder="Lokasi" required>
            <input type="text" name="image_url" placeholder="Image URL" required>
            
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
