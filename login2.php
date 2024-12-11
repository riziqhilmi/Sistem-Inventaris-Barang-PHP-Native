<?php 
include('koneksi.php'); 
session_start();

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi login (contoh sederhana)
    if ($username === 'admin' && $password === '12345') {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/login2.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Sign in & Sign up Form</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png" />

    <style>
        /* Tambahkan transisi halus ke semua tombol */
        .input-btn-field, 
        .btnn {
            transition: all 0.3s ease-in-out;
            transform: scale(1);
        }

        /* Efek hover pada tombol */
        .input-btn-field:hover, 
        .btnn:hover {
            background-color: #4caf50; /* Ganti warna sesuai preferensi */
            color: #ffffff;
            transform: scale(1.1);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Checkbox & Forgot Password */
        .checkbox-remember {
            font-size: 14px;
            cursor: pointer;
        }

        .forgot-password {
            font-size: 14px;
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="containerr">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- FORM LOGIN -->
                <form action="" method="POST" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <!-- Input Username -->
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <!-- Input Password -->
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <!-- Checkbox "Remember Me" dan Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 10px; font-size: 16px;">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="ingatSaya" name="ingatSaya" />
                      <label class="form-check-label text-secondary" for="ingatSaya" style="font-size: 18px;">Ingat Saya</label>
                    </div>
                      <a href="input_email.php" class="text-decoration-none" style="color: #007bff; font-size: 18px; font-weight: 500; margin-left: 100px;">
                        Lupa Password?
                      </a>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="btn btn-primary w-50" style="height: 50px; border-radius: 25px; font-size: 16px; font-weight: bold;">
                      LOG IN
                    </button>

                </form>
            </div>
        </div>

        <!-- PANEL -->
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <button class="btnn transparentt" id="sign-up-btn">Daftar</button>
                </div>
                <img src="img/logo_sd.png" class="image" alt="png" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <button class="btnn transparentt" id="sign-in-btn">Log In</button>
                </div>
                <img src="img/logo_sd.png" class="image" alt="png" />
            </div>
        </div>

        <!-- ALERT ERROR -->
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show position-absolute vw-100" style="z-index: 7;"
                role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']);
        } ?>
    </div>

    <script src="assets/js/login2.js"></script>
</body>

</html>
