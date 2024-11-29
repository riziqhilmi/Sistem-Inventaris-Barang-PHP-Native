<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$koneksi = mysqli_connect('localhost', 'root', 'Chaca6Yaa*', 'db_pasarejo');

if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

// Query untuk mengambil jumlah barang keluar berdasarkan tanggal
$sql_barang_keluar = "SELECT tanggal, SUM(jumlah) as total_jumlah FROM barang_keluar GROUP BY tanggal";
$result_barang_keluar = mysqli_query($koneksi, $sql_barang_keluar);

$labels_barang_keluar = [];
$data_barang_keluar = [];

while ($row = mysqli_fetch_assoc($result_barang_keluar)) {
    $labels_barang_keluar[] = $row['tanggal'];
    $data_barang_keluar[] = $row['total_jumlah'];
}

mysqli_close($koneksi);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Data Barang Keluar</title>
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
        <h1 class="text-center my-4">Visualisasi Data Barang Keluar</h1>

        <!-- Line Chart untuk jumlah barang keluar berdasarkan tanggal -->
    <div class="chart-container">
        <div class="chart-title">Jumlah Barang Keluar per Tanggal</div>
        <canvas id="lineChartBarangKeluar" width="400" height="200"></canvas>
    </div>
</div>

<script>
    const ctxLineBarangKeluar = document.getElementById('lineChartBarangKeluar').getContext('2d');
    const lineChartBarangKeluar = new Chart(ctxLineBarangKeluar, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels_barang_keluar); ?>,
            datasets: [{
                label: 'Jumlah Barang Keluar',
                data: <?php echo json_encode($data_barang_keluar); ?>,
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Jumlah Barang Keluar per Tanggal'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>