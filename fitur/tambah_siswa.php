<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit();
}

include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $jenis_kelamin = $_POST['jenis_kelamin']; 
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO siswa (nama, NIS, NISN, jenis_kelamin, tempat_lahir, tgl_lahir, agama, alamat) 
              VALUES ('$nama', '$nis', '$nisn', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir', '$agama', '$alamat')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data siswa berhasil ditambahkan'); window.location='../data_siswa.php';</script>";
    } else {
        echo "<script>alert('Data siswa gagal ditambahkan: " . mysqli_error($koneksi) . "'); window.location='../data_siswa.php';</script>";
    }
}
?>
