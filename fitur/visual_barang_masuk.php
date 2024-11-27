<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$koneksi = mysqli_connect('localhost', 'root', '', 'db_pasarejo');

if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

// Query untuk mengambil jumlah barang masuk berdasarkan tanggal
$sql_barang_masuk = "SELECT tanggal, SUM(jumlah) as total_jumlah FROM barang_masuk GROUP BY tanggal";
$result_barang_masuk = mysqli_query($koneksi, $sql_barang_masuk);

$labels_barang_masuk = [];
$data_barang_masuk = [];

while ($row = mysqli_fetch_assoc($result_barang_masuk)) {
    $labels_barang_masuk[] = $row['tanggal'];
    $data_barang_masuk[] = $row['total_jumlah'];
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Data Barang Masuk</title>
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
        <h1 class="text-center my-4">Visualisasi Data Barang Masuk</h1>

        <!-- Line Chart untuk jumlah barang masuk berdasarkan tanggal -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Barang Masuk per Tanggal</div>
            <canvas id="lineChartBarangMasuk" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        const ctxLineBarangMasuk = document.getElementById('lineChartBarangMasuk').getContext('2d');
        const lineChartBarangMasuk = new Chart(ctxLineBarangMasuk, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_barang_masuk); ?>,
                datasets: [{
                    label: 'Jumlah Barang Masuk',
                    data: <?php echo json_encode($data_barang_masuk); ?>,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
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
                        text: 'Jumlah Barang Masuk per Tanggal'
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
</body>
</html>