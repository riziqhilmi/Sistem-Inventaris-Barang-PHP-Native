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

// Query untuk mengambil jumlah guru berdasarkan status
$sql_guru = "SELECT status, COUNT(*) as jumlah FROM guru GROUP BY status";
$result_guru = mysqli_query($koneksi, $sql_guru);

$labels_guru = [];
$data_guru = [];

while ($row = mysqli_fetch_assoc($result_guru)) {
    $labels_guru[] = $row['status'];
    $data_guru[] = $row['jumlah'];
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #007bff;
            color: white;
        }
        .chart-container {
            margin: 20px 0;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: white;
            padding: 15px;
        }
        .chart-title {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
            color: #343a40;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Visualisasi Data Guru</h1>

        <!-- Pie Chart untuk jumlah guru berdasarkan status -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Guru Berdasarkan Status</div>
            <canvas id="pieChartGuru" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        const ctxPieGuru = document.getElementById('pieChartGuru').getContext('2d');
        const pieChartGuru = new Chart(ctxPieGuru, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels_guru); ?>,
                datasets: [{
                    label: 'Jumlah Guru',
                    data: <?php echo json_encode($data_guru); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
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
                        text: 'Jumlah Guru Berdasarkan Status'
                    }
                }
            }
        });
    </script>
</body>
</html>