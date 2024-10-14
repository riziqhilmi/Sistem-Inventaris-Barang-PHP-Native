<?php
include('../koneksi.php');

$id = $_GET['id'];

$query = "DELETE FROM siswa WHERE id_siswa='$id'";

if (mysqli_query($koneksi, $query)) {
    header('Location: ../data_siswa.php');
    exit();
} else {
    echo "<script>alert('Data gagal dihapus: " . mysqli_error($koneksi) . "'); window.location='../data_siswa.php';</script>";
}
?>