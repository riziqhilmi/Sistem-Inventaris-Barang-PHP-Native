<?php
session_start();

if (!isset($_SESSION['user_id'])) {
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

// Mengambil data barang berdasarkan rentang tanggal
$transactions = [];
if ($tanggal_mulai && $tanggal_selesai) {
    $query = "SELECT * FROM barang WHERE tgl BETWEEN ? AND ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $tanggal_mulai, $tanggal_selesai);
    $stmt->execute();
    $result = $stmt->get_result();
    $transactions = $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk menghasilkan PDF
function generatePDF($transactions) {
    require_once '../vendor/autoload.php'; // Pastikan ini sesuai dengan path Anda

    // Buat instance dari TCPDF
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Laporan Barang');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Set judul
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Laporan Barang', 0, 1, 'C');
    $pdf->Ln(10);

    // Header tabel
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(30, 10, 'Tanggal', 1);
    $pdf->Cell(60, 10, 'Nama Barang', 1);
    $pdf->Cell(40, 10, 'Merek', 1);
    $pdf->Cell(30, 10, 'Jumlah Awal', 1);
    $pdf->Cell(30, 10, 'Jumlah Akhir', 1);
    $pdf->Ln();

    // Data tabel
    $pdf->SetFont('helvetica', '', 12);
    foreach ($transactions as $trans) {
        $pdf->Cell(30, 10, date('d/m/Y', strtotime($trans['tgl'])), 1);
        $pdf->Cell(60, 10, htmlspecialchars($trans['nama']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($trans['merek']), 1);
        $pdf->Cell(30, 10, $trans['jumlah_awal'], 1);
        $pdf->Cell(30, 10, $trans['jumlah_akhir'], 1);
        $pdf->Ln();
    }

    // Output PDF
    $pdf->Output('laporan_barang.pdf', 'D'); // 'D' untuk download
    exit();
}

// Fungsi untuk menghasilkan Excel
function generateExcel($transactions) {
    require_once '../vendor/autoload.php'; // Pastikan ini sesuai dengan path Anda

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Laporan Barang');

    // Header tabel
    $sheet->setCellValue('A1', 'Tanggal');
    $sheet->setCellValue('B1', 'Nama Barang');
    $sheet->setCellValue('C1', 'Merek');
    $sheet->setCellValue('D1', 'Jumlah Awal');
    $sheet->setCellValue('E1', 'Jumlah Akhir');

    // Data tabel
    $row = 2;
    foreach ($transactions as $trans) {
        $sheet->setCellValue('A' . $row, date('d/m/Y', strtotime($trans['tgl'])));
        $sheet->setCellValue('B' . $row, htmlspecialchars($trans['nama']));
        $sheet->setCellValue('C' . $row, htmlspecialchars($trans['merek']));
        $sheet->setCellValue('D' . $row, $trans['jumlah_awal']);
        $sheet->setCellValue('E' . $row, $trans['jumlah_akhir']);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'laporan_barang.xlsx'; // Ganti ekstensi menjadi .xlsx
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // Mengubah header untuk Excel
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $writer->save('php://output');
    exit();
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
    <title>Laporan Barang</title>
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
                <h1 class="mb-4">Laporan Barang</h1>

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

                    <!-- Tabel Laporan Barang -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Merek</th>
                                <th>Jumlah Awal</th>
                                <th>Jumlah Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $index => $trans): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= date('d/m/Y', strtotime($trans['tgl'])) ?></td>
                                    <td><?= htmlspecialchars($trans['nama']) ?></td>
                                    <td><?= htmlspecialchars($trans['merek']) ?></td>
                                    <td><?= $trans['jumlah_awal'] ?></td>
                                    <td><?= $trans['jumlah_akhir'] ?></td>
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
    // Mengambil data untuk grafik
    const labels = <?= json_encode(array_map(function($trans) {
        return date('d/m/Y', strtotime($trans['tgl']));
    }, $transactions)); ?>;
    
    const data = <?= json_encode(array_map(function($trans) {
        return $trans['jumlah_awal']; // Ganti dengan 'jumlah_akhir' jika ingin menampilkan jumlah akhir
    }, $transactions)); ?>;

    const ctx = document.getElementById('lineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Barang Masuk',
                data: data,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
<?php endif; ?>
</script>

</body>
</html>