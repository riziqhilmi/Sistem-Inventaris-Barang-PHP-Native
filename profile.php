<?php
session_start();

// Menyertakan koneksi database
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login2.php');
    exit();
}

// Sample data for the dashboard
$user_name = $_SESSION['username']; // Username from the session
$user_email = $_SESSION['user_email'] ?? "email@example.com";
$user_photo = $_SESSION['user_photo'] ?? "assets/img/default-user.png"; // Gambar default jika tidak ada
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>

    <style>
        .profile-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
        }

        .profile-details {
            flex-grow: 1; /* Membuat kontainer informasi mengambil sisa ruang */
        }

        .buttons-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .edit-btn {
            color: white;
            background: #007bff;
            border-radius: 5px;
            padding: 8px 15px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .edit-photo-btn {
            margin-top: 10px;
        }

        .edit-btn:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        .profile-details h2 {
            margin-bottom: 5px;
        }

        .profile-details p {
            margin-top: 5px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'partials/sidebar.php'; ?>
            
            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="container">
                    <h1 class="mb-4">Profile</h1>
                    <div class="profile-container">
                        <!-- Foto Profil -->
                        <img src="<?php echo $user_photo; ?>" alt="Profile Photo" class="profile-photo">
                        <div class="profile-details">
                            <!-- Nama Pengguna dan Email -->
                            <h2><?php echo htmlspecialchars($user_name); ?></h2> <!-- Menggunakan htmlspecialchars -->
                            <p class="text-muted"><?php echo htmlspecialchars($user_email); ?></p> <!-- Menggunakan htmlspecialchars -->
                        </div>
                        <!-- Tombol Edit Foto -->
                        <button class="btn btn-primary edit-photo-btn" data-bs-toggle="modal" data-bs-target="#fileModal">
                            Pilih Foto Baru
                        </button>
                    </div>

                    <!-- Modal untuk memilih file -->
                    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fileModalLabel">Pilih Foto Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Input File -->
                                    <input type="file" id="profilePhotoInput" class="form-control" accept="image/*">
                                    <p id="fileName" class="mt-3">Belum ada file yang dipilih</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="update_photo.php" method="POST" enctype="multipart/form-data">
                                        <input type="file" name="profile_photo" id="profilePhoto" class="d-none" accept="image/*" required>
                                        <button type="submit" class="btn btn-success">Update Foto</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Menampilkan nama file yang dipilih
        document.getElementById("profilePhotoInput").addEventListener("change", function(event) {
            var fileName = event.target.files[0].name;
            document.getElementById("fileName").textContent = "File yang dipilih: " + fileName;

            // Transfer file yang dipilih ke form yang akan dikirimkan
            document.getElementById("profilePhoto").files = event.target.files;
        });
    </script>
</body>

</html>
