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

// Query untuk mengambil data kategori barang
$sql_barang = "SELECT kategori, COUNT(*) as jumlah FROM barang GROUP BY kategori";
$result_barang = mysqli_query($koneksi, $sql_barang);

$labels_barang = [];
$data_barang = [];

if ($result_barang) {
    while($row = mysqli_fetch_assoc($result_barang)) {
        $labels_barang[] = $row['kategori'];
        $data_barang[] = $row['jumlah'];
    }
}

// Query untuk mengambil data kondisi barang
$sql_kondisi = "SELECT kondisi, COUNT(*) as jumlah FROM barang GROUP BY kondisi";
$result_kondisi = mysqli_query($koneksi, $sql_kondisi);

$labels_kondisi = [];
$data_kondisi = [];

if ($result_kondisi) {
    while($row = mysqli_fetch_assoc($result_kondisi)) {
        $labels_kondisi[] = $row['kondisi'];
        $data_kondisi[] = $row['jumlah'];
    }
}

// Query untuk mengambil data barang masuk dan keluar
$sql_masuk = "SELECT DATE(tanggal) as tgl, SUM(jumlah) as total FROM barang_masuk GROUP BY DATE(tanggal)";
$result_masuk = mysqli_query($koneksi, $sql_masuk);

$labels_masuk = [];
$data_masuk = [];

if ($result_masuk) {
    while($row = mysqli_fetch_assoc($result_masuk)) {
        $labels_masuk[] = $row['tgl'];
        $data_masuk[] = $row['total'];
    }
}

$sql_keluar = "SELECT DATE(tanggal) as tgl, SUM(jumlah) as total FROM barang_keluar GROUP BY DATE(tanggal)";
$result_keluar = mysqli_query($koneksi, $sql_keluar);

$labels_keluar = [];
$data_keluar = [];

if ($result_keluar) {
    while($row = mysqli_fetch_assoc($result_keluar)) {
        $labels_keluar[] = $row['tgl'];
        $data_keluar[] = $row['total'];
    }
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Visualisasi Barang</title>
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

    .row {
        display: flex; /* Flexbox aktif */
        justify-content: space-between; /* Spasi di antara elemen */
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
    
        .text-info {
            font-size: 1.2rem;
            margin-top: 20px;
            text-align: center;
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

.text-info {
    margin-top: 15px;
    font-size: 1.2rem;
    text-align: center;
}
        
    </style>
</head>

<body>

<div class="container">
        <h1 class="mb-4 text-center">Data Visualisasi Barang</h1>

        <!-- Tombol Kembali -->
        <a href="../data_visualisasi.php" class="cancel-btn" onclick="closeModal()">Kembali</a>

        <!-- Bar Chart dan Line Chart bersebelahan -->
        <div class="row">
            <!-- Bar Chart untuk jumlah barang berdasarkan kategori -->
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Jumlah Barang per Kategori</div>
                    <canvas id="barChart" width="400" height="200"></canvas>
                </div>
            </div>
            <!-- Line Chart untuk tren barang masuk dan keluar -->
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Tren Barang Masuk dan Keluar</div>
                    <canvas id="lineChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart untuk kondisi barang -->
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container" style="max-width: 600px; margin: auto;">
                    <div class="chart-title">Kondisi Barang</div>
                    <canvas id="pieChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Teks penjelasan untuk kondisi barang -->
        <div class="text-info">
            <p>Grafik di atas menunjukkan proporsi kondisi barang yang ada. Pastikan untuk memantau kondisi barang agar tetap dalam keadaan baik!</p>
        </div>

        <!-- Teks penjelasan untuk tren barang -->
        <div class="text-info">
            <p>Grafik ini menggambarkan tren barang yang masuk dan keluar dari waktu ke waktu. Analisis tren ini sangat penting untuk pengelolaan inventaris yang efektif.</p>
        </div>
    </div>

    <script>
        // Bar Chart
        const ctxBar = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_barang); ?>,
                datasets: [{
                    label: 'Jumlah Barang per Kategori',
                    data: <?php echo json_encode($data_barang); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
                        text: 'Jumlah Barang per Kategori'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart untuk kondisi barang
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels_kondisi); ?>,
                datasets: [{
                    label: 'Kondisi Barang',
                    data: <?php echo json_encode($data_kondisi); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
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
                        text: 'Kondisi Barang'
                    }
                }
            }
        });

        // Line Chart untuk barang masuk dan keluar
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_merge($labels_masuk, $labels_keluar)); ?>,
                datasets: [{
                    label: 'Barang Masuk',
                    data: <?php echo json_encode($data_masuk); ?>,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1
                }, {
                    label: 'Barang Keluar',
                    data: <?php echo json_encode($data_keluar); ?>,
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
                        text: 'Tren Barang Masuk dan Keluar'
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