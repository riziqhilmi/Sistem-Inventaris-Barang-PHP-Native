<?php
include('../koneksi.php');
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM guru WHERE id_guru='$id'") or die(mysqli_error($koneksi));
header("location:../data_guru.php");
?>