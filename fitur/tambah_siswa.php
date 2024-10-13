<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: ../login.php');
    exit();
}

include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $jenis_kelamin = $_POST['jenis_kelamin']; // Menambahkan jenis kelamin
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];

    // Menyiapkan query untuk menambahkan data siswa
    $query = "INSERT INTO siswa (nama, NIS, NISN, jenis_kelamin, tempat_lahir, tgl_lahir, agama, alamat) 
              VALUES ('$nama', '$nis', '$nisn', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir', '$agama', '$alamat')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data siswa berhasil ditambahkan'); window.location='../data_siswa.php';</script>";
    } else {
        echo "<script>alert('Data siswa gagal ditambahkan: " . mysqli_error($koneksi) . "'); window.location='../data_siswa.php';</script>";
    }
}
?>
