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
    $nip = $_POST['nip'];
    $kontak = $_POST['kontak'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    // Menyiapkan query untuk menambahkan data guru
    $query = "INSERT INTO guru (nama, NIP, kontak, tempat_lahir, tgl_lahir, alamat, status) 
              VALUES ('$nama', '$nip', '$kontak', '$tempat_lahir', '$tgl_lahir', '$alamat', '$status')";

    // Eksekusi query
    if (mysqli_query(mysql: $koneksi, $query)) {
        echo "<script>alert('Data guru berhasil ditambahkan'); window.location='../data_guru.php';</script>";
    } else {
        echo "<script>alert('Data guru gagal ditambahkan: " . mysqli_error($koneksi) . "'); window.location='../data_guru.php';</script>";
    }
}
?>
