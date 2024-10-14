<?php
include('../koneksi.php');

$id = $_GET['id'];

$query = "DELETE FROM guru WHERE id_guru='$id'";

if (mysqli_query($koneksi, $query)) {
    header('Location: ../data_guru.php');
    exit();
} else {
    echo "<script>alert('Data gagal dihapus: " . mysqli_error($koneksi) . "'); window.location='../data_guru.php';</script>";
}
?>
