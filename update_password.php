<?php
session_start();
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Update password di database
        $query = "UPDATE user SET password = '$new_password' WHERE email = '$email'";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Password berhasil diubah!'); window.location.href='login2.php';</script>";
        }else {
            echo "<script>alert('Gagal mengubah password!'); window.location.href='reset_password.php';</script>";
        }
    } else {
        echo "<script>alert('Password dan Konfirmasi Password tidak cocok!'); window.location.href='reset_password.php';</script>";
    }
} else {
    header('Location: input_email.php');
    exit();
}
?>