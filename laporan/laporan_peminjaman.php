<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}

require_once '../koneksi.php';
require_once '../vendor/autoload.php'; // Pastikan ini sesuai dengan path Anda

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Mengambil tanggal dari query string
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : null;
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : null;

// Mengambil data peminjaman berdasarkan rentang tanggal
$transactions = [];
if ($tanggal_mulai && $tanggal_selesai) {
    $query = "SELECT p.*, b.nama AS nama_barang 
              FROM peminjaman p 
              JOIN barang b ON p.id_barang = b.id_barang 
              WHERE p.tanggal_pinjam BETWEEN ? AND ? 
              ORDER BY p.tanggal_pinjam ASC";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $tanggal_mulai, $tanggal_selesai);
    $stmt->execute();
    $result = $stmt->get_result();
    $transactions = $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk menghasilkan PDF
function generatePDF($transactions) {
    require_once '../vendor/autoload.php';

    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Laporan Peminjaman');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Laporan Peminjaman', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(30, 10, 'Tanggal Pinjam', 1);
    $pdf->Cell(60, 10, 'Nama Barang', 1);
    $pdf->Cell(40, 10, 'Nama Peminjam', 1);
    $pdf->Cell(30, 10, 'Jumlah', 1);
    $pdf->Cell(30, 10, 'Tanggal Kembali', 1); // Kolom baru untuk Tanggal Kembali
    $pdf->Ln();

    $pdf->SetFont('helvetica', '', 12);
    foreach ($transactions as $trans) {
        $pdf->Cell(30, 10, date('d/m/Y', strtotime($trans['tanggal_pinjam'])), 1);
        $pdf->Cell(60, 10, htmlspecialchars($trans['nama_barang']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($trans['nama_peminjam']), 1);
        $pdf->Cell(30, 10, $trans['jumlah_pinjam'], 1);
        $pdf->Cell(30, 10, date('d/m/Y', strtotime($trans['tanggal_kembali'])), 1); // Menambahkan Tanggal Kembali
        $pdf->Ln();
    }

    $pdf->Output('laporan_peminjaman.pdf', 'D');
    exit();
}

// Fungsi untuk menghasilkan Excel
function generateExcel($transactions) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal Pinjam');
    $sheet->setCellValue('C1', 'Nama Barang');
    $sheet->setCellValue('D1', 'Nama Peminjam');
    $sheet->setCellValue('E1', 'Jumlah');
    $sheet->setCellValue('F1', 'Tanggal Kembali');
    $sheet->setCellValue('G1', 'Status');
    
    // Isi Data
    $row = 2;
    foreach ($transactions as $index => $trans) {
        $sheet->setCellValue('A' . $row, $index + 1);
        $sheet->setCellValue('B' . $row, date('d/m/Y', strtotime($trans['tanggal_pinjam'])));
        $sheet->setCellValue('C' . $row, htmlspecialchars($trans['nama_barang']));
        $sheet->setCellValue('D' . $row, htmlspecialchars($trans['nama_peminjam']));
        $sheet->setCellValue('E' . $row, $trans['jumlah_pinjam']);
        $sheet->setCellValue('F' . $row, date('d/m/Y', strtotime($trans['tanggal_kembali'])));
        $sheet->setCellValue('G' . $row, htmlspecialchars($trans['status']));
        $row++;
    }
    
    // Set header untuk download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="laporan_peminjaman.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output'); // Download Excel
}

// Cek jika ada permintaan untuk mengunduh PDF atau Excel
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'download_pdf' && !empty($transactions)) {
        generatePDF($transactions);
    } elseif ($_GET['action'] == 'download_excel' && !empty($transactions)) {
        generateExcel($transactions);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
    <link rel="icon" type="image/png" href="../img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include '../partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="container">
                <h1 class="mb-4">Laporan Peminjaman</h1>

                <!-- Form untuk Memilih Tanggal -->
                <form action="" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tanggal_selesai" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                </form>

                <!-- Tombol untuk Mengunduh Laporan -->
                <?php if (!empty($transactions)): ?>
                    <a href="?tanggal_mulai=<?= $tanggal_mulai ?>&tanggal_selesai=<?= $tanggal_selesai ?>&action=download_pdf" class="btn btn-danger mb-3">Unduh PDF</a>
                    <a href="?tanggal_mulai=<?= $tanggal_mulai ?>&tanggal_selesai=<?= $tanggal_selesai ?>&action=download_excel" class="btn btn-success mb-3">Unduh Excel</a>

                    <!-- Tabel Laporan Peminjaman -->
                    <table class="table table-striped">
                    <thead>
    <tr>
        <th>No</th>
        <th>Tanggal Pinjam</th>
        <th>Nama Barang</th>
        <th>Nama Peminjam</th>
        <th>Jumlah</th>
        <th>Tanggal Kembali</th> <!-- Kolom baru -->
        <th>Status</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($transactions as $index => $trans): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= date('d/m/Y', strtotime($trans['tanggal_pinjam'])) ?></td>
            <td><?= htmlspecialchars($trans['nama_barang']) ?></td>
            <td><?= htmlspecialchars($trans['nama_peminjam']) ?></td>
            <td><?= $trans['jumlah_pinjam'] ?></td>
            <td><?= date('d/m/Y', strtotime($trans['tanggal_kembali'])) ?></td> <!-- Kolom baru -->
            <td><?= htmlspecialchars($trans['status']) ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
                    </table>
                <?php else: ?>
                    <p class="alert alert-warning">Tidak ada data untuk tanggal yang dipilih.</p>
                <?php endif; ?>

                <!-- Grafik (Jika diperlukan) -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Jika Anda ingin menampilkan grafik berdasarkan data yang diambil
<?php if (!empty($transactions)): ?>
    const labels = <?= json_encode(array_map(function($trans) {
        return date('d/m/Y', strtotime($trans['tanggal_pinjam']));
    }, $transactions)); ?>;

    const data = <?= json_encode(array_map(function($trans) {
        return $trans['jumlah_pinjam'];
    }, $transactions)); ?>;

    const ctx = document.getElementById('lineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: data,
                borderColor: 'rgb(75, 192, 192)',
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Peminjaman'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                }
            }
        }
    });
<?php endif; ?>
</script>

</body>
</html>