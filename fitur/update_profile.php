<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update data
    $query = "UPDATE `user` SET 
              `username` = '$username',
              `email` = '$email'
              WHERE `id` = '$id_user'";

    if (!empty($password)) {
        // Jika password diisi, hash password baru
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", `password` = '$hashed_password'";
    }

    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "<script>alert('Profil berhasil diubah'); window.location='../profile.php';</script>";
    } else {
        echo "<script>alert('Profil gagal diubah: " . mysqli_error($koneksi) . "'); window.location='../profile.php';</script>";
    }
}
?>