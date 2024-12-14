<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit();
}

include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $kontak = $_POST['kontak'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    // Validasi NIP
    if (strlen($nip) > 16) {
        echo "<script>alert('NIP tidak boleh lebih dari 16 karakter.'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO guru (nama, NIP, kontak, tempat_lahir, tgl_lahir, alamat, status) 
              VALUES ('$nama', '$nip', '$kontak', '$tempat_lahir', '$tgl_lahir', '$alamat', '$status')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data guru berhasil ditambahkan'); window.location='../data_guru.php';</script>";
    } else {
        echo "<script>alert('Data guru gagal ditambahkan: " . mysqli_error($koneksi) . "'); window.location='../data_guru.php';</script>";
    }
}
?>
