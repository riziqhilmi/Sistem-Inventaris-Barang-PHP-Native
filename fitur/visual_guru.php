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

// Query untuk mengambil jumlah guru berdasarkan status
$sql_guru = "SELECT status, COUNT(*) as jumlah FROM guru GROUP BY status";
$result_guru = mysqli_query($koneksi, $sql_guru);

$labels_guru = [];
$data_guru = [];

while ($row = mysqli_fetch_assoc($result_guru)) {
    $labels_guru[] = $row['status'];
    $data_guru[] = $row['jumlah'];
}

// Query untuk mengambil jumlah guru berdasarkan tempat lahir
$sql_tempat_lahir = "SELECT tempat_lahir, COUNT(*) as jumlah FROM guru GROUP BY tempat_lahir";
$result_tempat_lahir = mysqli_query($koneksi, $sql_tempat_lahir);

$labels_tempat_lahir = [];
$data_tempat_lahir = [];

while ($row = mysqli_fetch_assoc($result_tempat_lahir)) {
    $labels_tempat_lahir[] = $row['tempat_lahir'];
    $data_tempat_lahir[] = $row['jumlah'];
}

// Query untuk mengambil jumlah guru berdasarkan tahun lahir
$sql_tahun_lahir = "SELECT YEAR(tgl_lahir) as tahun, COUNT(*) as jumlah FROM guru GROUP BY tahun";
$result_tahun_lahir = mysqli_query($koneksi, $sql_tahun_lahir);

$labels_tahun_lahir = [];
$data_tahun_lahir = [];

while ($row = mysqli_fetch_assoc($result_tahun_lahir)) {
    $labels_tahun_lahir[] = $row['tahun'];
    $data_tahun_lahir[] = $row['jumlah'];
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
            margin: 10px 0; /* Mengurangi margin */
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: white;
            padding: 10px; /* Mengurangi padding */
        }
        .chart-title {
            text-align: center;
            margin-bottom: 5px; /* Mengurangi margin */
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
            <canvas id="pieChartGuru" width="300" height="150"></canvas> <!-- Ukuran lebih kecil -->
        </div>

        <!-- Bar Chart untuk jumlah guru berdasarkan tempat lahir -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Guru Berdasarkan Tempat Lahir</div>
            <canvas id="barChartTempatLahir" width="300" height="150"></canvas> <!-- Ukuran lebih kecil -->
        </div>

        <!-- Line Chart untuk jumlah guru berdasarkan tahun lahir -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Guru Berdasarkan Tahun Lahir</div>
            <canvas id="lineChartTahunLahir" width="300" height="150"></canvas> <!-- Ukuran lebih kecil -->
        </div>
    </div>

    <script>
        // Pie Chart
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
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
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

        // Bar Chart untuk tempat lahir
        const ctxBarTempatLahir = document.getElementById('barChartTempatLahir').getContext('2d');
        const barChartTempatLahir = new Chart(ctxBarTempatLahir, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_tempat_lahir); ?>,
                datasets: [{
                    label: 'Jumlah Guru',
                    data: <?php echo json_encode($data_tempat_lahir); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Guru Berdasarkan Tempat Lahir'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Chart untuk tahun lahir
        const ctxLineTahunLahir = document.getElementById('lineChartTahunLahir').getContext('2d');
        const lineChartTahunLahir = new Chart(ctxLineTahunLahir, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_tahun_lahir); ?>,
                datasets: [{
                    label: 'Jumlah Guru',
                    data: <?php echo json_encode($data_tahun_lahir); ?>,
                    fill: false,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Guru Berdasarkan Tahun Lahir'
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