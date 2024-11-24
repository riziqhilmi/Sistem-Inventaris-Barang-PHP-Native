<?php
session_start();
include('koneksi.php');

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
        // header('Location: dashboard.php');
        echo json_encode(array('status'=> 'success','message'=> 'Login berhasil'));
        unset($_SESSION['error']);
      } else {
        // Jika user atau password salah
        $_SESSION['error'] = '';
        // header('Location: login2.php');
        echo json_encode(array('status'=> 'error1','message'=> 'User atau password salah!!!'));
      }
    } else {
      // Jika user tidak ditemukan
      $_SESSION['error'] = '';
      echo json_encode(array('status'=> 'error2','message'=> 'User tidak ditemukan!!!'));
    }
  }
