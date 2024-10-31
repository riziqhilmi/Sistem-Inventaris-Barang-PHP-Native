<?php
include("koneksi.php");
header('Content-Type: application/json');

$SqlQuery = "SELECT nama, jumlah_akhir FROM barang";
$result = mysqli_query($koneksi, $SqlQuery) or die(mysqli_error($koneksi));

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($koneksi);

echo json_encode($data);
?>
