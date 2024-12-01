<?php
// cetak_riwayat_peminjaman.php

include('../koneksi.php'); // Koneksi ke database

require_once('../vendor/autoload.php'); // Memastikan TCPDF terinstall di direktori 'vendor'

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil tanggal dari form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $file_format = $_POST['file_format'];

    // Query untuk mengambil data peminjaman dalam rentang tanggal
    $query = "SELECT 
    p.id_peminjaman, 
    p.kode_peminjaman, 
    b.id_barang, 
    b.nama, 
    p.tanggal_pinjam, 
    p.tanggal_kembali, 
    p.jumlah_pinjam, 
    p.status, 
    p.keterangan
FROM peminjaman p
JOIN barang b ON p.id_barang = b.id_barang
WHERE DATE(p.tanggal_pinjam) = DATE(CURDATE())
ORDER BY p.tanggal_pinjam DESC" ;

    $result = $koneksi->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if ($file_format === 'PDF') {
        // Buat dokumen PDF baru
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nama Anda');
        $pdf->SetTitle('Riwayat Peminjaman');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Set Judul
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Riwayat Peminjaman - ' . date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date)), 0, 1, 'C');
        $pdf->Ln(5);

        // Judul Tabel
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Kode Pinjam', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tgl Pinjam', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tgl Kembali', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Status', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Keterangan', 1, 1, 'C');

        // Data Tabel
        $pdf->SetFont('helvetica', '', 12);
        $no = 1;
        foreach ($data as $row) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(30, 10, $row['kode_peminjaman'], 1, 0, 'L');
            $pdf->Cell(60, 10, $row['nama_barang'], 1, 0, 'L');
            $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal_pinjam'])), 1, 0, 'C');
            $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal_kembali'])), 1, 0, 'C');
            $pdf->Cell(20, 10, $row['jumlah_pinjam'], 1, 0, 'C');
            $pdf->Cell(30, 10, $row['status'], 1, 0, 'L');
            $pdf->Cell(50, 10, $row['keterangan'], 1, 1, 'L');
        }

        // Output PDF
        $pdf->Output('riwayat_peminjaman.pdf', 'I');
        exit; // Hentikan eksekusi setelah output PDF
    } elseif ($file_format === 'EXCEL') {
        // Logika untuk menghasilkan laporan dalam format Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=riwayat_peminjaman.xls");
        echo "<table border='1'>
                <tr>
                    <th>No</th>
                    <th>Kode Pinjam</th>
                    <th>Nama Barang</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>";
        $no = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['kode_peminjaman']}</td>
                    <td>{$row['nama_barang']}</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal_pinjam'])) . "</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal_kembali'])) . "</td>
                    <td>{$row['jumlah_pinjam']}</td>
                    <td>{$row['status']}</td>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Riwayat Peminjaman</title>
    <style>
        /* Modal overlay styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Modal box styling */
        .modal {
            background: #fff;
            width: 800px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            font-family: Arial, sans-serif;
        }

        /* Modal header */
        .modal h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            text-align: center;
        }

        /* Table styling */
        .modal table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .modal th, .modal td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .modal th {
            background-color: #f2f2f2;
        }

        /* Dropdown styling */
        .modal label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            color: #555;
        }

        .modal select {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }

        /* Button container styling */
        .modal .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /* Button styling */
        .modal button {
            padding: 10px 20px; /* Ukuran tombol */
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
        }

        .modal .print-btn {
             background-color: #0000FF; /* Warna biru untuk tombol cetak */
             color: #fff; 
        }

        .modal .cancel-btn {
            background-color: #FF0000; /* Warna merah untuk tombol batal */
            color: #fff;
        }

        /* Hover efek */
        .modal button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h2>Cetak Riwayat Peminjaman</h2>

        <form id="report_form" method="POST" action="cetak_riwayat_peminjaman.php">
            <input type="hidden" name="start_date" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="end_date" value="<?php echo date('Y-m-d'); ?>">
            
            <label for="file_format">Pilih Format File:</label>
            <select name="file_format" id="file_format" required>
                <option value="PDF">PDF</option>
                <option value="EXCEL">Excel</option>
            </select>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pinjam</th>
                        <th>Nama Barang</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['kode_peminjaman']; ?></td>
                            <td><?php echo $row['nama_barang']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_kembali'])); ?></td>
                            <td><?php echo $row['jumlah_pinjam']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['keterangan']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Tombol Cetak dan Cancel -->
            <div class="button-container">
                <button type="submit" class="btn print-btn">Cetak Laporan</button>
                <button type="button" class="btn btn-danger cancel-btn" id="cancelBtn">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modalOverlay = document.getElementById("modalOverlay");
        const cancelButton = document.getElementById("cancelBtn");

        // Tampilkan modal saat halaman dimuat
        modalOverlay.style.display = "flex";

        // Event untuk tombol Cancel
        cancelButton.addEventListener("click", function () {
            // Redirect ke file peminjaman.php
            window.location.href = "../inventaris/peminjaman.php";
        });
    });
</script>
