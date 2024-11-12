<?php
include('../koneksi.php'); // Koneksi ke database
require_once('../vendor/autoload.php'); // Pastikan TCPDF terinstal di direktori 'vendor'

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil tanggal dari form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $file_format = $_POST['file_format'];

    // Query untuk mengambil data peminjaman dalam rentang tanggal
    $query = "SELECT p.id_peminjaman, p.kode_peminjaman, p.tanggal_pinjam, p.tanggal_kembali, p.jumlah_pinjam, p.status, p.keterangan, b.nama AS nama_barang
              FROM peminjaman p
              JOIN barang b ON p.id_barang = b.id_barang
              WHERE p.tanggal_pinjam BETWEEN '$start_date' AND '$end_date'
              ORDER BY p.tanggal_pinjam DESC";

    $result = $koneksi->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if ($file_format === 'PDF') {
        // Membuat dokumen PDF baru
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Riwayat Peminjaman');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Judul
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Riwayat Peminjaman - ' . date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date)), 0, 1, 'C');
        $pdf->Ln(5);

        // Header tabel
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Tanggal Pinjam', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Status', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Keterangan', 1, 1, 'C');

        // Data tabel
        $pdf->SetFont('helvetica', '', 12);
        $no = 1;
        foreach ($data as $row) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['tanggal_pinjam'])), 1, 0, 'C');
            $pdf->Cell(60, 10, $row['nama_barang'], 1, 0, 'L');
            $pdf->Cell(20, 10, $row['jumlah_pinjam'], 1, 0, 'C');
            $pdf->Cell(20, 10, $row['status'], 1, 0, 'C');
            $pdf->Cell(50, 10, $row['keterangan'], 1, 1, 'L');
        }

        // Output PDF
        $pdf->Output('riwayat_peminjaman.pdf', 'I');
        exit;
    } elseif ($file_format === 'EXCEL') {
        // Output dalam format Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=riwayat_peminjaman.xls");
        echo "<table border='1'>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pinjam</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>";
        $no = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal_pinjam'])) . "</td>
                    <td>{$row['nama_barang']}</td>
                    <td>{$row['jumlah_pinjam']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['keterangan']}</td>
                  </tr>";
            $no++;
        }
        echo "</table>";
        exit;
    } else {
        echo "Format tidak dikenali. Silakan pilih PDF atau Excel.";
    }
} else {
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
        /* Styling modal, tabel, dll */
    </style>
</head>
<body>

<?php
// Menentukan tanggal hari ini dalam format 'Y-m-d'
$today = date("Y-m-d");
?>

<!-- Modal Overlay dan Konten Modal -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h2>Cetak Riwayat Peminjaman Harian</h2>

        <form id="report_form" method="POST" action="cetak_riwayat_barang_keluar.php">
            <!-- Tanggal otomatis sebagai start dan end date untuk laporan harian -->
            <input type="hidden" name="start_date" value="<?php echo $today; ?>">
            <input type="hidden" name="end_date" value="<?php echo $today; ?>">
            
            <label for="file_format">Pilih Format File:</label>
            <select name="file_format" id="file_format" required>
                <option value="PDF">PDF</option>
                <option value="EXCEL">Excel</option>
            </select>

            <!-- Preview Tabel -->
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pinjam</th>
                        <th>Nama Barang</th>
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
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                            <td><?php echo $row['nama_barang']; ?></td>
                            <td><?php echo $row['jumlah_pinjam']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['keterangan']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Tombol Cetak dan Batal -->
            <div class="button-container">
                <button type="submit" class="print-btn">Cetak Laporan</button>
                <button type="button" class="cancel-btn" onclick="closeModal()">Batal</button>
            </div>
        </form>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("modalOverlay").style.display = "flex";
    });

    function closeModal() {
        document.getElementById("modalOverlay").style.display = "none";
        window.location.href = '../inventaris/barang_keluar.php';
    }
</script>

</body>
</html>
