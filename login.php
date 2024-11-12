<?php
session_start(); // Mulai session
include('koneksi.php');

if (isset($_POST['submit'])) {
  $usr = $_POST['username'];
  $pass = $_POST['password'];

  if (!empty(trim($usr)) && !empty(trim($pass))) {
    // Query untuk mendapatkan user berdasarkan username atau email
    $query = "SELECT * FROM user WHERE username = '$usr' OR email = '$usr'";
    $result = mysqli_query($koneksi, $query);
    $num = mysqli_num_rows($result);

    if ($num != 0) {
      while ($row = mysqli_fetch_array($result)) {
        $id = $row['id_user'];
        $userVal = $row['username'];
        $passVal = $row['password'];
        $userName = $row['email'];
      }

      // Cek apakah username/email dan password cocok
      if (($userVal == $usr || $userName == $usr) && $passVal == $pass) {
        // Simpan data user di session
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $userVal;

        // Redirect ke halaman dashboard
        header('Location: dashboard.php');
        exit();
      } else {
        // Jika user atau password salah
        $_SESSION['error'] = 'User atau password salah!!!';
        header('Location: login.php');
        exit();
      }
    } else {
      // Jika user tidak ditemukan
      $_SESSION['error'] = 'User tidak ditemukan!!!';
      header('Location: login.php');
      exit();
    }
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Login Page | SDN Pasarejo 1</title>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
      <a class="navbar-brand" href="#">Login Siswa</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
          <a class="nav-item nav-link active"
            href="login.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
              class="sr-only">(current)</span></a>
          <!-- <a class="nav-item nav-link" href="registration.php">Daftar</a> -->
          <!-- <a class="nav-item nav-link" href="admin-login.php">Admin</a> -->
        </div>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->






  <div class="row">
    <div class="col-11 wrapper mx-auto">
      <div class="row mx-auto my-auto">
        <div class="col-md-6">
          <center><img src="img/logo_sd.png" class="" alt=""></center>

        </div>
        <div class="col-md-6 mx-auto "><br> <br>
          <p class="txtlogin">Log-in Sekarang!</p>

          <form method="POST" action="login.php">
            <div class="form-group">
              <label for="Username" class="txtlogin2">Username atau Email.</label>
              <input type="text" required="required" class="form-control" id="username" name="username"
                placeholder="Enter username or email.">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="txtlogin2">Password.</label>
              <input type="password" required="required" class="form-control" name="password" id="login"
                placeholder="Password">
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" onclick="showpassword()" id="show-password">
              <label class="form-check-label" for="show-password">Lihat Password</label>
            </div>
            <button type="submit" name="submit" class="btn btnlogin btn-block">Submit</button>
            <div style="margin-top: 10px;">
              <label for="akun">Tidak Punya Akun? <a href="register.php">Daftar disini!!</a></label>
            </div>
          </form>

          <script>
            function showpassword() {
              var x = document.getElementById("login");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
          </script>

        </div>
      </div>
    </div>
  </div>
  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>