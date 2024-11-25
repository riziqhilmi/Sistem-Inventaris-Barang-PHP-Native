<?php
// cetak_riwayat_peminjaman.php

include('../koneksi.php'); // Koneksi ke database
require_once('../vendor/autoload.php'); // Pastikan TCPDF telah diinstal di direktori 'vendor'

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil tanggal dari form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $file_format = $_POST['file_format'];

    // Query untuk mengambil data peminjaman barang dalam rentang tanggal
    $query = "SELECT p.id_peminjaman, p.nama_peminjam, b.nama AS nama_barang, 
                     p.tanggal_pinjam, p.tanggal_kembali, p.jumlah_pinjam, p.keterangan 
              FROM peminjaman p 
              JOIN barang b ON p.id_barang = b.id_barang 
              WHERE p.tanggal_pinjam BETWEEN '$start_date' AND '$end_date' 
              ORDER BY p.tanggal_pinjam DESC;";

    $result = $koneksi->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if ($file_format === 'PDF') {
        // Buat dokumen PDF baru
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Admin SD Pasarejo 1');
        $pdf->SetTitle('Riwayat Peminjaman Barang');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Set Judul
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Riwayat Peminjaman Barang - ' . date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date)), 0, 1, 'C');
        $pdf->Ln(5);

        // Header Tabel
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Nama Peminjam', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tgl Pinjam', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tgl Kembali', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Keterangan', 1, 1, 'C');

        // Isi Tabel
        $pdf->SetFont('helvetica', '', 12);
        $no = 1;
        foreach ($data as $row) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(30, 10, $row['nama_peminjam'], 1, 0, 'L');
            $pdf->Cell(40, 10, $row['nama_barang'], 1, 0, 'L');
            $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal_pinjam'])), 1, 0, 'C');
            $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal_kembali'])), 1, 0, 'C');
            $pdf->Cell(20, 10, $row['jumlah_pinjam'], 1, 0, 'C');
            $pdf->Cell(50, 10, $row['keterangan'], 1, 1, 'L');
        }

        // Output PDF
        $pdf->Output('riwayat_peminjaman_barang.pdf', 'I');
        exit; // Hentikan eksekusi setelah output PDF
    } elseif ($file_format === 'EXCEL') {
        // Logika untuk menghasilkan laporan dalam format Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=riwayat_peminjaman_barang.xls");
        echo "<table border='1'>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>";
        $no = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_peminjam']}</td>
                    <td>{$row['nama_barang']}</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal_pinjam'])) . "</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal_kembali'])) . "</td>
                    <td>{$row['jumlah_pinjam']}</td>
                    <td>{$row['keterangan']}</td>
                  </tr>";
            $no++;
        }
        echo "</table>";
        exit; // Hentikan eksekusi setelah output Excel
    } else {
        echo "Format tidak dikenali. Silakan pilih PDF atau Excel.";
    }
} else {
    // Jika form belum disubmit, inisialisasi $data sebagai array kosong
    $data = [];
}
?>
