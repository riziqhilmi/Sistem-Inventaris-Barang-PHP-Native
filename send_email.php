<?php
session_start();
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Cek apakah email ada di database
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika email ditemukan, tampilkan form untuk mengubah password
        $_SESSION['email'] = $email; // Simpan email di session
        header('Location: reset_password.php');
    } else {
        $_SESSION['error'] = 'Email tidak ditemukan!';
        header('Location: input_email.php');
    }
}
?>