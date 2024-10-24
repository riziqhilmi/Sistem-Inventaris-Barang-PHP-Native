<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit();
}

include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_barang'];
    $merk = $_POST['merk'];
    $kategori = $_POST['kategori'];
    $ruangan = $_POST['ruangan'];
    $kondisi = $_POST['kondisi'];
    $jml_a = $_POST['jml_a'];
    $jml_ak = $_POST['jml_ak'];
    $tgl = $_POST['tgl'];
    $ket = $_POST['ket'];

    $query = "INSERT INTO barang (nama, merek, kategori, ruangan, kondisi, jumlah_awal, jumlah_akhir, tgl, keterangan) 
              VALUES ('$nama', '$merk', '$kategori', '$ruangan', '$kondisi', '$jml_a', '$jml_ak', '$tgl', '$ket')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data barang berhasil ditambahkan'); window.location='../inventaris/barang.php';</script>";
    } else {
        echo "<script>alert('Data barang gagal ditambahkan: " . mysqli_error($koneksi) . "'); window.location='../inventaris/barang.php';</script>";
    }
}
?>
