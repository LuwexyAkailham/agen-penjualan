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
}

// Handle deletion of an item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_item'])) {
    $item_id = $_POST['item_id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch items from database
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihan Hari Ini</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-direction: row;
            margin: 20px;
        }
        .sidebar {
            width: 25%;
            padding: 10px;
            background-color: #f8f9fa;
            border-right: 1px solid #ccc;
        }
        .sidebar h3 {
            margin-top: 0;
        }
        .main-content {
            width: 75%;
            padding: 10px;
        }
        .add-item-form {
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        .col-md-4 {
            flex: 1 0 30%;
            margin: 10px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .card-img-top {
            max-width: 100%;
            height: auto;
        }
        .card-body {
            padding: 10px;
        }
        .custom-select {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .custom-select select {
            display: none; /* Hide the original select */
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
    <div class="container mt-4">
        <div class="sidebar">
            <h3>Kategori</h3>
            <ul>
                <li><a href="#"><i class="fas fa-tv"></i> Elektronik</a></li>
                <li><a href="#"><i class="fas fa-gamepad"></i> Akun Game</a></li>
                <li><a href="#"><i class="fas fa-car"></i> Mobil & Motor</a></li>
                <li><a href="#"><i class="fas fa-mobile-alt"></i> Gadget</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Pilihan Hari Ini</h1>
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Depok - 65 km</span>
                </div>
            </div>

            <!-- Form to add a new item -->
            <div class="add-item-form">
                <h2>Tambah Item</h2>
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
                            <div data-value="Mobil & Motor">
                                <i class="fas fa-car icon"></i> Mobil & Motor
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

            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card">';
                        echo '<img alt="' . htmlspecialchars($row["deskripsi"]) . '" class="card-img-top" height="400" src="' . htmlspecialchars($row["image_url"]) . '" width="600"/>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row["harga"]) . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($row["deskripsi"]) . '</p>';
                        echo '<p class="location">' . htmlspecialchars($row["lokasi"]) . '</p>';
                        
                        // Form to delete an item
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="item_id" value="' . $row["id"] . '">';
                        echo '<button type="submit" name="delete_item" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</button>';
                        echo '</form>';

                        echo '</div></div></div>';
                    }
                } else {
                    echo "<p>No items found</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
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
