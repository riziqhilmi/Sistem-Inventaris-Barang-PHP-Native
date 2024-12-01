<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', 'Chaca6Yaa*', 'db_pasarejo');

if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

// Query untuk data peminjaman
// Query untuk data peminjaman
$sql_peminjaman = "SELECT tanggal_pinjam, nama_peminjam, SUM(jumlah_pinjam) AS total_pinjam 
                   FROM peminjaman 
                   GROUP BY tanggal_pinjam, nama_peminjam 
                   LIMIT 0, 25;";

$result = mysqli_query($koneksi, $sql_peminjaman);

// Pastikan data direset sebelum digunakan
$labels_tanggal = [];
$data_jumlah_pinjam = [];
$data_nama_peminjam = [];

// Mengelompokkan data untuk chart
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $labels_tanggal[] = $row['tanggal_pinjam'];
        $data_jumlah_pinjam[] = $row['total_pinjam'];
        $data_nama_peminjam[] = $row['nama_peminjam'];
    }
} else {
    echo "Tidak ada data.";
}

// Tutup koneksi
mysqli_close($koneksi);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Data Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .chart-container {
            margin: 20px 0;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: white;
            padding: 20px;
        }
        .chart-title {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Visualisasi Data Peminjaman</h1>

        <!-- Line Chart -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Peminjaman Berdasarkan Tanggal</div>
            <canvas id="lineChart" width="400" height="200"></canvas>
        </div>

        <!-- Bar Chart -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Peminjaman per Nama Peminjam</div>
            <canvas id="barChart" width="400" height="200"></canvas>
        </div>

        <!-- Histogram -->
        <div class="chart-container">
            <div class="chart-title">Distribusi Jumlah Barang Dipinjam</div>
            <canvas id="histogram" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        // Line Chart: Jumlah Peminjaman Berdasarkan Tanggal
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_tanggal); ?>,
                datasets: [{
                    label: 'Jumlah Barang Dipinjam',
                    data: <?php echo json_encode($data_jumlah_pinjam); ?>,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Jumlah Barang Dipinjam Berdasarkan Tanggal' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Bar Chart: Jumlah Peminjaman per Nama Peminjam
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($data_nama_peminjam); ?>,
                datasets: [{
                    label: 'Jumlah Barang Dipinjam',
                    data: <?php echo json_encode($data_jumlah_pinjam); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Jumlah Barang Dipinjam per Nama Peminjam' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Histogram: Distribusi Jumlah Barang Dipinjam
        const ctxHistogram = document.getElementById('histogram').getContext('2d');
        new Chart(ctxHistogram, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_tanggal); ?>,
                datasets: [{
                    label: 'Distribusi Jumlah Barang Dipinjam',
                    data: <?php echo json_encode($data_jumlah_pinjam); ?>,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribusi Jumlah Barang Dipinjam' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>
