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

// Query untuk mengambil jumlah barang keluar berdasarkan tanggal
$sql_barang_keluar = "SELECT tanggal, SUM(jumlah) as total_jumlah FROM barang_keluar GROUP BY tanggal";
$result_barang_keluar = mysqli_query($koneksi, $sql_barang_keluar);

$labels_barang_keluar = [];
$data_barang_keluar = [];

while ($row = mysqli_fetch_assoc($result_barang_keluar)) {
    $labels_barang_keluar[] = $row['tanggal'];
    $data_barang_keluar[] = $row['total_jumlah'];
}

// Query untuk mengambil jumlah barang keluar per barang
$sql_barang = "SELECT b.nama, SUM(bk.jumlah) as total_jumlah FROM barang_keluar bk JOIN barang b ON bk.id_barang = b.id_barang GROUP BY b.nama";
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
    <title>Visualisasi Data Barang Keluar</title>
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
        <h1 class="text-center my-4">Visualisasi Data Barang Keluar</h1>

        <!-- Line Chart untuk jumlah barang keluar berdasarkan tanggal -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Barang Keluar per Tanggal</div>
            <canvas id="lineChartBarangKeluar" width="400" height="200"></canvas>
        </div>

        <!-- Bar Chart untuk jumlah barang keluar per barang -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Barang Keluar per Barang</div>
            <canvas id="barChartBarangKeluar" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        // Line Chart
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

                // Bar Chart
                const ctxBarBarangKeluar = document.getElementById('barChartBarangKeluar').getContext('2d');
        const barChartBarangKeluar = new Chart(ctxBarBarangKeluar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_barang); ?>,
                datasets: [{
                    label: 'Jumlah Barang Keluar',
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
                        text: 'Jumlah Barang Keluar per Barang'
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