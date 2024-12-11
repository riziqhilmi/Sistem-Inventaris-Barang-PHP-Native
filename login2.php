<?php include('koneksi.php'); ?>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/login2.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <title>Sign in & Sign up Form</title>
  <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">

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
  color: #ffffff; /* Warna teks saat hover */
  transform: scale(1.1); /* Zoom in */
  box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3); /* Tambahkan bayangan */
}

  </style>
</head>

<body>

  <div class="containerr">
    <div class="forms-container">
      <div class="signin-signup">

      <form action="" method="POST" class="sign-in-form">
  <h2 class="title">Sign in</h2>
  <div class="input-field">
    <i class="fas fa-user"></i>
    <input type="text" name="username" id="username" placeholder="Username" required />
  </div>
  <div class="input-field">
    <i class="fas fa-lock"></i>
    <input type="password" name="password" id="login" placeholder="Password" required />
  </div>
  <input type="button" onclick="loginn()" value="Login" name="submit" class="input-btn-field input-field" />
  
  <!-- Tombol Lupa Password -->
  <div style="text-align: center; margin-top: 10px;">
    <a href="input_email.php" class="forgot" style="color: #4caf50; font-weight: bold; text-decoration: none;">
      Lupa Password?
    </a>
  </div>
</form>


        <form action="" class="sign-up-form" method="post">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="usernamee" id="usr" placeholder="Username" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="passwordd" id="psw" placeholder="Password" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" id="cpsw" placeholder="Confirm password" required />
          </div>
          <input type="button" onclick="reg()" name="sign_up" class="input-btn-field input-field" value="Sign up" />
        </form>

      </div>
    </div>

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
    <?php if (isset($_SESSION['error'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show position-absolute vw-100" style="z-index: 7;"
        role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error']);
    } 
    ?>
  </div>


  <script src="assets/js/login2.js"></script>
</body>

</html>