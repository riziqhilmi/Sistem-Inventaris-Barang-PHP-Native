<?php
include("../koneksi.php");
header('Content-Type: application/json');

$SqlQuery = "SELECT nama, jumlah_awal, jumlah_akhir FROM barang";

$result = mysqli_query($koneksi, $SqlQuery);

if (!$result) {
    echo json_encode(array("error" => mysqli_error($koneksi)));
    exit;
}

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'nama' => $row['nama'],
        'jumlah_awal' => (int)$row['jumlah_awal'],
        'jumlah_akhir' => (int)$row['jumlah_akhir']
    );
}

mysqli_close($koneksi);

echo json_encode($data);
?>