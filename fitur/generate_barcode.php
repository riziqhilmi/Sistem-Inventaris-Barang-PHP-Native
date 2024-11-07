<?php
require '../vendor/autoload.php'; // Pastikan path ini sesuai dengan lokasi autoload.php

use Picqer\Barcode\BarcodeGeneratorPNG;

if (isset($_GET['id'])) {
    $id_barang = $_GET['id']; // Ambil ID barang dari parameter URL

    // Buat instance generator barcode
    $generator = new BarcodeGeneratorPNG();

    // Generate barcode
    header('Content-Type: image/png');
    echo $generator->getBarcode($id_barang, $generator::TYPE_CODE_128);
}

?>