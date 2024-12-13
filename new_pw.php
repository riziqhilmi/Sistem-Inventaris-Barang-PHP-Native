<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $query = "UPDATE user SET password = '$hashed_password', otp = NULL, otp_expiration = NULL WHERE email = '$email'";
        if ($koneksi->query($query) === TRUE) {
            echo "Password updated successfully. You can now log in.";
            header("Location: login2.php");
            exit();
        } else {
            echo "Error updating password: " . $koneksi->error;
        }
    } else {
        echo "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/email.css">
    <title>Perbarui Kata Sandi</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
</head>
<body>
    <div class="card shadow" style="width: 53rem;">
        <div class="card-body">
            <h5 class="card-title"><strong>Perbarui Kata Sandi</strong></h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Masukkan Password Baru" id="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Masukkan Konfirmasi Password" id="confirm_password" required>
                </div>
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                    <label class="form-check-label" for="showPassword">Tampilkan password</label>
                </div>
                <button type="submit" class="btn btn-primary"><strong>Kirim</strong></button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            var newPasswordInput = document.getElementById("new_password");
            var confirmPasswordInput = document.getElementById("confirm_password");
            if (newPasswordInput.type === "password") {
                newPasswordInput.type = "text";
                confirmPasswordInput.type = "text";
            } else {
                newPasswordInput.type = "password";
                confirmPasswordInput.type = "password";
            }
        }
    </script>
</body>
</html>