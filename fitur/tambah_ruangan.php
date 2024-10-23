<?php
session_start(); 


if (!isset($_SESSION['user_id'])) {

    header('Location: ../login.php');
    exit();
}

include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = $_POST['nama_ruangan'];
    $keterangan = $_POST['keterangan'];
    

    $query = "INSERT INTO ruangan (nama_ruangan, keterangan) 
              VALUES ('$nama', '$keterangan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data kelas berhasil ditambahkan'); window.location='../data_kelas.php';</script>";
    } else {
        echo "<script>alert('Data kelas gagal ditambahkan: " . mysqli_error($koneksi) . "'); window.location='../data_kelas.php';</script>";
    }
}
?>
