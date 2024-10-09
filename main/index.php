<?php
session_start(); // Memulai sesi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include '../koneksi.php';

// Handle deletion of an item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_item'])) {
    $item_id = $_POST['item_id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Get the selected category if it exists
$selected_category = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Fetch items from the database based on the selected category
if ($selected_category) {
    $stmt = $conn->prepare("SELECT * FROM items WHERE kategori = ?");
    if ($stmt) {
        $stmt->bind_param("s", $selected_category);
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM items");
    if (!$stmt) {
        echo "Error: " . $conn->error;
    }
}

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihan Hari Ini</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->
</head>
<body>
    <div class="container mt-4">
        <div class="sidebar">
            <div class="profile">
                <h3>Profil</h3>
                <p>Nama: 
                <?php 
                if (isset($_SESSION['username'])) {
                    echo htmlspecialchars($_SESSION['username']);
                } else {
                    echo 'Guest';
                }
                ?>
                </p>
                <a href="../profile/edit_profile.php"><button>Edit Profil</button></a>
                <a href="logout.php"><button>Logout</button></a>
            </div>
            <h3>Kategori</h3>
            <ul>
                <li><button class="btn-12" onclick="window.location.href='index.php'"><span>All Items</span></button></li>
                <li><button class="btn-12" onclick="window.location.href='index.php?kategori=Elektronik'"><span>Elektronik</span></button></li>
                <li><button class="btn-12" onclick="window.location.href='index.php?kategori=Akun Game'"><span>Akun Game</span></button></li>
                <li><button class="btn-12" onclick="window.location.href='index.php?kategori=Kendaraan'"><span>Kendaraan</span></button></li>
                <li><button class="btn-12" onclick="window.location.href='index.php?kategori=Gadget'"><span>Gadget</span></button></li>
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

            <!-- Tambahkan tombol "Tambah Item" jika user adalah admin -->
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') { ?>
                <a href="../items/tambah.php" class="add-item-btn">
                    <button class="button">Tambah Item</button>
                </a>
            <?php } ?>

            <!-- Display items -->
            <div class="row">
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img alt="<?php echo htmlspecialchars($row["deskripsi"]); ?>" class="card-img-top" height="400" src="<?php echo htmlspecialchars($row["image_url"]); ?>" width="600"/>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row["harga"]); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($row["deskripsi"]); ?></p>
                                    <p class="location"><?php echo htmlspecialchars($row["lokasi"]); ?></p>

                                    <?php 
                                    // Jika user adalah admin, tampilkan tombol Edit dan Delete
                                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') { ?>
                                        <form method="POST" action="" style="display:inline;">
                                            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                            <button class="button" type="submit" name="delete_item" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                        </form>
                                        
                                        <form method="GET" action="../items/edit.php" style="display:inline;">
                                            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                            <button class="button" type="submit">Edit</button>
                                        </form>
                                    <?php 
                                    } else { 
                                        // Jika user adalah user biasa, tampilkan tombol Beli dan Chat
                                    ?>
                                        <form method="POST" action="../items/beli.php" style="display:inline;">
                                            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                            <button class="button" type="submit">Beli</button>
                                        </form>
                                        <button class="button" onclick="openChat('<?php echo $row['id']; ?>')">Chat</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } 
                } else { 
                    echo "<p>No items found</p>"; 
                }

                // Pastikan untuk hanya menutup statement jika query berhasil
                if ($stmt) {
                    $stmt->close();
                }

                // Menutup koneksi database
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="chat-container" style="display:none;">
        <div class="chat-header">
            <img alt="Profile picture of Lexus Pro" src="https://placehold.co/30x30"/>
            <div class="title">Chat</div>
            <div class="icons">
                <i class="fas fa-phone"></i>
                <i class="fas fa-video"></i>
            </div>
        </div>
        <div class="chat-body" id="chat-body">
            <!-- Chat messages will be loaded here dynamically -->
        </div>
        <div class="chat-footer">
            <form id="chat-form">
                <div class="input-container">
                    <input type="text" id="message" placeholder="Aa" required/>
                    <button type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load chat messages
            function loadMessages(itemId) {
                $.ajax({
                    url: 'load_chat.php?item_id=' + itemId,
                    method: 'GET',
                    success: function(data) {
                        $('#chat-body').html('');
                        data.forEach(msg => {
                            $('#chat-body').append('<div>' + msg.username + ': ' + msg.message + '</div>');
                        });
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // Open chat function
            window.openChat = function(itemId) {
                $('.chat-container').show();
                $('#message').val(''); // Clear input field
                loadMessages(itemId); // Load messages for the item
            };

            // Submit chat form
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                const message = $('#message').val();
                // Optionally, include item_id when sending a message
                const itemId = $('#chat-body').data('itemId');

                $.post('send_message.php', { message: message, item_id: itemId }, function(response) {
                    $('#message').val(''); // Clear input field after sending
                    loadMessages(itemId); // Reload messages after sending
                });
            });
        });
    </script>
</body>
</html>
