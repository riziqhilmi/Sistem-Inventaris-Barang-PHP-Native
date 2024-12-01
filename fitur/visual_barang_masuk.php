<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$koneksi = mysqli_connect('localhost', 'root', '', 'db_pasarejo');

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

// Query untuk Line Chart (jumlah barang masuk per tanggal)
$sql_barang_masuk = "SELECT tanggal, SUM(jumlah) as total_jumlah FROM barang_masuk GROUP BY tanggal";
$result_barang_masuk = mysqli_query($koneksi, $sql_barang_masuk);

$labels_barang_masuk = [];
$data_barang_masuk = [];

while ($row = mysqli_fetch_assoc($result_barang_masuk)) {
    $labels_barang_masuk[] = $row['tanggal'];
    $data_barang_masuk[] = $row['total_jumlah'];
}

// Query untuk Bar Chart (jumlah barang masuk per barang)
$sql_barang = "SELECT b.nama, SUM(bm.jumlah) as total_jumlah FROM barang_masuk bm JOIN barang b ON bm.id_barang = b.id_barang GROUP BY b.nama";
$result_barang = mysqli_query($koneksi, $sql_barang);

$labels_barang = [];
$data_barang = [];

while ($row = mysqli_fetch_assoc($result_barang)) {
    $labels_barang[] = $row['nama'];
    $data_barang[] = $row['total_jumlah'];
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
            color: #343a40;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Visualisasi Data Barang Masuk</h1>

        <!-- Line Chart -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Barang Masuk per Tanggal</div>
            <canvas id="lineChartBarangMasuk" width="400" height="200"></canvas>
        </div>

        <!-- Bar Chart -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Barang Masuk per Barang</div>
            <canvas id="barChartBarangMasuk" width="400" height="200"></canvas>
        </div>

    </div>

    <script>
        // Line Chart
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

        // Bar Chart
        const ctxBarBarangMasuk = document.getElementById('barChartBarangMasuk').getContext('2d');
        const barChartBarangMasuk = new Chart(ctxBarBarangMasuk, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_barang); ?>,
                datasets: [{
                    label: 'Jumlah Barang Masuk',
                    data: <?php echo json_encode($data_barang); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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
                        text: 'Jumlah Barang Masuk per Barang'
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