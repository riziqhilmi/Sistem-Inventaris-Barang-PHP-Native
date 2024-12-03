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
    <link rel="icon" type="image/png" href="../img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

    .text-center {
        text-align: center;
    }

    h1 {
            font-size: 2.5rem;
            color: #4CAF50;
        }

    .my-4 {
        margin: 20px 0;
    }

    .col-md-12 {
        flex: 1; /* Set elemen menjadi fleksibel */
        max-width: calc(70% - 20px); /* Grafik mengambil 1/3 lebar baris */
        box-sizing: border-box; /* Pastikan padding tidak memengaruhi lebar */
    }

    .chart-container {
        flex: 1; /* Ukuran fleksibel untuk menyesuaikan */
        background-color: white;
        padding: 20px;
        margin: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .chart-title {
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }

    .row {
        display: flex; /* Flexbox aktif */
        flex-wrap: wrap; /* Grafik turun ke bawah jika layar kecil */
        justify-content: space-between; /* Spasi di antara elemen */
        gap: 20px; /* Jarak antar elemen */
    }

    .cancel-btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .cancel-btn:hover {
            background-color: #45a049;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

    .cancel-btn:active {
        transform: translateY(1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chart-container {
            background: linear-gradient(to bottom, #ffffff, #e8f5e9);
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
<div class="container">
    <h1 class="text-center">Visualisasi Data Guru</h1>

    <!-- Tombol Kembali -->
    <a href="../data_visualisasi.php" class="cancel-btn" onclick="closeModal()">Kembali</a>

    <!-- Baris untuk semua chart -->
    <div class="row">
        <!-- Pie Chart -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Guru Berdasarkan Status</div>
            <canvas id="pieChartGuru"></canvas>
        </div>

        <!-- Bar Chart -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Guru Berdasarkan Tempat Lahir</div>
            <canvas id="barChartTempatLahir"></canvas>
        </div>

        <!-- Line Chart -->
        <div class="chart-container">
            <div class="chart-title">Jumlah Guru Berdasarkan Tahun Lahir</div>
            <canvas id="lineChartTahunLahir"></canvas>
        </div>
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
        function closeModal() {
            window.close();
        }
    </script>
</body>
</html>