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

// Query untuk mengambil jumlah peminjaman berdasarkan bulan
$sql_peminjaman = "SELECT MONTH(tanggal) as bulan, COUNT(*) as total_peminjaman FROM peminjaman GROUP BY bulan";
$result_peminjaman = mysqli_query($koneksi, $sql_peminjaman);

$labels_peminjaman = [];
$data_peminjaman = [];

while ($row = mysqli_fetch_assoc($result_peminjaman)) {
    $labels_peminjaman[] = $row['bulan'];
    $data_peminjaman[] = $row['total_peminjaman'];
}

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

        <!-- Line Chart untuk jumlah peminjaman berdasarkan bulan -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Peminjaman per Bulan</div>
            <canvas id="lineChartPeminjaman" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        const ctxLinePeminjaman = document.getElementById('lineChartPeminjaman').getContext('2d');
        const lineChartPeminjaman = new Chart(ctxLinePeminjaman, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_peminjaman); ?>,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: <?php echo json_encode($data_peminjaman); ?>,
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
                        text: 'Jumlah Peminjaman per Bulan'
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
                   