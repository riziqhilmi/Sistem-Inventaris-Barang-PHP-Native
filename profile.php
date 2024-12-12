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

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Ambil ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Sample data for the dashboard
$user_name = $_SESSION['username'] ?? 'Default Username';
$user_email = $_SESSION['user_email'] ?? 'email@example.com';
$user_photo = $_SESSION['user_photo'] ?? 'assets/img/default-user.png';
$user_description = $_SESSION['user_description'] ?? 'This is a default description about the user.';

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
        /* Background and overall styling */
        body {
            background: #f4f7fc;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .profile-container {
            background: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: flex-start;
            gap: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            animation: fadeIn 0.6s forwards;
        }

        .profile-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #6c63ff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-photo-section .edit-btn {
            margin-top: 10px;
            background: #6c63ff;
            border: none;
            padding: 12px 25px;
            font-weight: bold;
            color: white;
            border-radius: 25px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .profile-photo:hover {
            transform: scale(1.1);
        }

        .profile-photo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .profile-photo-section:hover .edit-btn {
            background-color: #4a42f5;
        }

        .profile-details {
            flex-grow: 1;
            padding-left: 20px;
        }

        .profile-details h2 {
            margin-bottom: 10px;
            font-size: 1.8rem;
            font-weight: 600;
            color: #2f2f2f;
        }

        .profile-details p {
            margin-top: 5px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .profile-details .edit-btn {
            background: #28a745;
            border-radius: 25px;
            padding: 12px 20px;
            font-weight: bold;
            text-decoration: none;
            margin-top: 20px;
            width: 160px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .profile-details .edit-btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .modal-footer form {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .modal-body input[type="file"] {
            padding: 10px;
            border-radius: 5px;
            background-color: #f0f4f8;
            border: 1px solid #ccc;
        }

        .modal-header {
            background: #6c63ff;
            color: white;
        }

        .description-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex-basis: 40%;
            opacity: 0;
            animation: fadeIn 0.6s forwards;
        }

        .description-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #2f2f2f;
        }

        .description-card p {
            font-size: 1rem;
            color: #6c757d;
        }

        .profile-container .card-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
                    <h1 class="mb-4" style="font-weight: bold; animation: fadeIn 0.6s forwards;">Profile</h1>
                    <div class="profile-container">
                        <!-- Foto Profil dan Tombol Pilih Foto Baru -->
                        <div class="profile-photo-section">
                            <img src="<?php echo $user_photo; ?>" alt="Profile Photo" class="profile-photo">
                            <button class="btn edit-btn" data-bs-toggle="modal" data-bs-target="#fileModal">
                                Pilih Foto Baru
                            </button>
                        </div>

                        <!-- Detail Pengguna -->
                        <div class="profile-details">
                            <h2><?php echo htmlspecialchars($user_name); ?></h2>
                            <p class="text-muted"><?php echo htmlspecialchars($user_email); ?></p>
                        </div>
                    </div>

                    <!-- Card Deskripsi Pengguna -->
                    <div class="description-card mt-4">
                        <h3>Deskripsi Pengguna</h3>
                        <p><?php echo htmlspecialchars($user_description); ?></p>
                    </div>

                    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

                     <!-- Tombol Update Profile -->
<button class="btn btn-primary" style="margin-top: 20px;" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Update Profile</button>

<!-- Modal Update Profile -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="fitur/update_profile.php" method="POST">
    <!-- Token CSRF -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" 
               class="form-control" 
               id="username" 
               name="username" 
               value="<?php echo htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
               required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control" 
               id="email" 
               name="email" 
               value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
               required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password (Optional)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-success">Save Changes</button>
</form>

            </div>
        </div>
    </div>
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
