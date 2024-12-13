<?php
include('../koneksi.php');
try {
    // Ambil data dari POST
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_id = $_POST['id_user']; // Asumsi Anda menggunakan user_id untuk mengupdate data

    // Query menggunakan prepared statement
    $stmt = $koneksi->prepare("UPDATE `user` SET `username` = ?, `password` = ? WHERE `id_user` = ?");
    $stmt->bind_param("ssi", $username, $password, $user_id);

    // Eksekusi query
    $result = $stmt->execute();

    // Berikan alert dan arahkan ke halaman tertentu
    if ($result) {
        echo "<script>alert('Profil berhasil diperbarui'); window.location='../profile.php';</script>";
    } else {
        echo "<script>alert('Profil gagal diperbarui: " . $stmt->error . "'); window.location='../profile.php';</script>";
    }

    $stmt->close();
} catch (Exception $e) {
    echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location='../profile.php';</script>";
}

$koneksi->close();
?>
