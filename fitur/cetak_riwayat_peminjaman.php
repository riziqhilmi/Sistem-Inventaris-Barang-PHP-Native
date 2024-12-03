<?php
// cetak_riwayat_peminjaman.php

include('../koneksi.php'); // Database connection
require_once('../vendor/autoload.php'); // Make sure TCPDF is installed in the 'vendor' directory

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil tanggal dari form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $file_format = $_POST['file_format'];

    // Query untuk mengambil data peminjaman dalam rentang tanggal
    $query = "SELECT p.id_peminjaman, p.kode_peminjaman, p.nama_peminjam, p.tanggal_pinjam, p.tanggal_kembali, p.jumlah_pinjam, p.status, p.keterangan 
              FROM peminjaman p 
              WHERE p.tanggal_pinjam BETWEEN '$start_date' AND '$end_date' 
              ORDER BY p.tanggal_pinjam DESC;";

    $result = $koneksi->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if ($file_format === 'PDF') {
        // Create new PDF document
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Riwayat Peminjaman');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Set Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Riwayat Peminjaman - ' . date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date)), 0, 1, 'C');
        $pdf->Ln(5);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Kode Peminjaman', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Nama Peminjam', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tanggal Pinjam', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tanggal Kembali', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Status', 1, 1, 'C');

        // Table Data
        $pdf->SetFont('helvetica', '', 12);
        $no = 1;
        foreach ($data as $row) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(30, 10, $row['kode_peminjaman'], 1, 0, 'C');
            $pdf->Cell(60, 10, $row['nama_peminjam'], 1, 0, 'L');
            $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal_pinjam'])), 1, 0, 'C');
            $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal_kembali'])), 1, 0, 'C');
            $pdf->Cell(20, 10, $row['jumlah_pinjam'], 1, 0, 'C');
            $pdf->Cell(30, 10, $row['status'], 1, 1, 'C');
        }

        // Output the PDF
        $pdf->Output('riwayat_peminjaman.pdf', 'I');
        exit; // Hentikan eksekusi setelah output PDF
    } elseif ($file_format === 'EXCEL') {
        // Logika untuk menghasilkan laporan dalam format Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=riwayat_peminjaman.xls");
        echo "<table border='1'>
                <tr>
                    <th>No</th>
                    <th>Kode Peminjaman</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>";
        $no = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['kode_peminjaman']}</td>
                    <td>{$row['nama_peminjam']}</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal_pinjam'])) . "</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal_kembali'])) . "</td>
                    <td>{$row['jumlah_pinjam']}</td>
                    <td>{$row['status']}</td>
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
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .modal .print-btn {
                background-color: #007bff;
                color: #fff;
            }

            .modal .cancel-btn {
                background-color: #dc3545;
                color: #fff;
            }

            /* Close button styling */
            .modal .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                background: transparent;
                border: none;
                font-size: 20px;
                cursor: pointer;
                color: #888;
            }

            /* Additional styling for button hover */
            .modal button:hover {
                opacity: 0.9;
            }
        </style>
    </head>
    <body>

    <?php
    // Set today's date in 'Y-m-d' format
    $today = date("Y-m-d");

    // Query to get today's borrowing records
    $query = "SELECT p.*, b.nama 
              FROM peminjaman p 
              JOIN barang b ON p.id_barang = b.id_barang 
              WHERE DATE(p.tanggal_pinjam) = '$today' 
              ORDER BY p.tanggal_pinjam DESC;";
    $result = mysqli_query($koneksi, $query);

    // Save data to array
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    ?>

    <!-- Modal Overlay and Modal Content -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h2>Cetak Riwayat Peminjaman Harian</h2>

            <form id="report_form" method="POST" action="cetak_riwayat_peminjaman.php">
                <!-- Hidden inputs for today's date as the start and end date -->
                <input type="hidden" name="start_date" value="<?php echo $today; ?>">
                <input type="hidden" name="end_date" value="<?php echo $today; ?>">
                
                <label for="file_format">Pilih Format File:</label>
                <select name="file_format" id="file_format" required>
                    <option value="PDF">PDF</option>
                    <option value="EXCEL">Excel</option>
                </select>

                <!-- Table Preview -->
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Peminjaman</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row['kode_peminjaman']; ?></td>
                                <td><?php echo $row['nama_peminjam']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['tanggal_kembali'])); ?></td>
                                <td><?php echo $row['jumlah_pinjam']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Button Container for Print and Cancel Buttons -->
                <div class="button-container">
                    <button type="submit" class="print-btn">Cetak Laporan</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        // Automatically display the modal on page load
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("modalOverlay").style.display = "flex";
        });

        // Function to close the modal
        function closeModal() {
            window.close();
        }
    </script>

    </body>
    </html>