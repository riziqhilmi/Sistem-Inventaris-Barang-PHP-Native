<?php
include("../koneksi.php");
header('Content-Type: application/json');

$SqlQuery = "SELECT kondisi, COUNT(*) as jumlah FROM barang WHERE kondisi IN ('Baik', 'Rusak Ringan', 'Rusak Berat') GROUP BY kondisi";

$result = mysqli_query($koneksi, $SqlQuery);

if (!$result) {
    echo json_encode(array("error" => mysqli_error($koneksi)));
    exit;
}

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($koneksi);

echo json_encode($data);
?>