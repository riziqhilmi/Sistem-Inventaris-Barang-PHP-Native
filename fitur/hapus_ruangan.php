<?php
include('../koneksi.php');

$id = $_GET['id'];

$query = "DELETE FROM ruangan WHERE id_ruangan='$id'";

if (mysqli_query($koneksi, $query)) {
    header('Location: ../data_kelas.php');
    exit();
} else {
    echo "<script>alert('Data gagal dihapus: " . mysqli_error($koneksi) . "'); window.location='../data_kelas.php';</script>";
}
?>
