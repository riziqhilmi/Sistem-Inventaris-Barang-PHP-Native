<?php
session_start();
include('koneksi.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login2.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";
$max_file_size = 2 * 1024 * 1024; // 2MB dalam bytes

// Fetch user data
$query = "SELECT username, email, photo FROM user WHERE id_user = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    
    $update_query = "UPDATE user SET username = ?, email = ? WHERE id_user = ?";
    $stmt = mysqli_prepare($koneksi, $update_query);
    mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $msg = "Profile updated successfully!";
        // Update session data
        $_SESSION['username'] = $username;
    } else {
        $msg = "Error updating profile!";
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    $check_query = "SELECT password FROM user WHERE id_user = ?";
    $stmt = mysqli_prepare($koneksi, $check_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_data = mysqli_fetch_assoc($result);
    
    if ($current_password === $user_data['password']) {
        if ($new_password === $confirm_password) {
            $update_query = "UPDATE user SET password = ?, c_password = ? WHERE id_user = ?";
            $stmt = mysqli_prepare($koneksi, $update_query);
            mysqli_stmt_bind_param($stmt, "ssi", $new_password, $new_password, $user_id);
            
            if (mysqli_stmt_execute($stmt)) {
                $msg = "Password changed successfully!";
            } else {
                $msg = "Error changing password!";
            }
        } else {
            $msg = "New passwords do not match!";
        }
    } else {
        $msg = "Current password is incorrect!";
    }
}

// Handle photo upload
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    
    // Check file size
    if ($_FILES['photo']['size'] > $max_file_size) {
        $msg = "File is too large! Maximum size allowed is 2MB.";
    } 
    // Check file type
    elseif (!in_array($_FILES['photo']['type'], $allowed_types)) {
        $msg = "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
    }
    else {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
        $update_query = "UPDATE user SET photo = ? WHERE id_user = ?";
        $stmt = mysqli_prepare($koneksi, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $photo, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Profile photo updated successfully!";
        } else {
            $msg = "Error updating profile photo!";
        }
    }
}
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
    <style>
        .profile-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .profile-photo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .file-size-info {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.5rem;
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
            <h2 class="mb-4">Profile Settings</h2>
            
            <?php if ($msg): ?>
                <div class="alert <?php echo strpos($msg, 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?>">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <!-- Profile Photo Section -->
            <div class="profile-photo-container">
                <?php if ($user['photo']): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($user['photo']); ?>" class="profile-photo" alt="Profile Photo">
                <?php else: ?>
                    <img src="img/default-profile.png" class="profile-photo" alt="Default Profile Photo">
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data" class="mt-3">
                    <div class="mb-3">
                        <input type="file" class="form-control" name="photo" accept="image/*">
                        <div class="file-size-info">
                            Maximum file size: 2MB. Allowed formats: JPEG, PNG, GIF
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Photo</button>
                </form>
            </div>

            <!-- Profile Information Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Profile Information</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card">
                <div class="card-header">
                    <h4>Change Password</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>