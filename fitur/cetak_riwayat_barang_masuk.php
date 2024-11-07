<?php
// cetak_riwayat_barang_masuk.php

include('../koneksi.php'); // Database connection
require_once('../vendor/autoload.php'); // Make sure TCPDF is installed in the 'vendor' directory

// Fetch data from the database
// Ambil tanggal hari ini
$tanggal_hari_ini = date('Y-m-d');

// Query untuk mengambil data barang masuk hari ini
$query = "SELECT bm.id_barang_masuk, b.nama, bm.tanggal, bm.jumlah, bm.keterangan 
          FROM barang_masuk bm 
          JOIN barang b ON bm.id_barang = b.id_barang 
          WHERE DATE(bm.tanggal) = '$tanggal_hari_ini' 
          ORDER BY bm.tanggal DESC LIMIT 25;";

$result = $koneksi->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Riwayat Barang Masuk Harian');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Set Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Riwayat Barang Masuk Harian - ' . date('d-m-Y'), 0, 1, 'C');
$pdf->Ln(5);

// Table Header
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(40, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(20, 10, 'Jumlah', 1, 0, 'C');
$pdf->Cell(50, 10, 'Keterangan', 1, 1, 'C');

// Table Data
$pdf->SetFont('helvetica', '', 12);
$no = 1;
foreach ($data as $row) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['tanggal'])), 1, 0, 'C');
    $pdf->Cell(60, 10, $row['nama'], 1, 0, 'L');
    $pdf->Cell(20, 10, $row['jumlah'], 1, 0, 'C');
    $pdf->Cell(50, 10, $row['keterangan'], 1, 1, 'L');
}

// Output the PDF
$pdf->Output('riwayat_barang_masuk_harian.pdf', 'I');
?>
