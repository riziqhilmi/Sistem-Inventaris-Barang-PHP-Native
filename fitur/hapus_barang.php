<?php
include('../koneksi.php');

$id = $_GET['id'];

$query = "DELETE FROM barang WHERE id_barang='$id'";

if (mysqli_query($koneksi, $query)) {
    header('Location: ../inventaris/barang.php');
    exit();
} else {
    echo "<script>alert('Data gagal dihapus: " . mysqli_error($koneksi) . "'); window.location='../inventaris/barang.php';</script>";
}
?>
