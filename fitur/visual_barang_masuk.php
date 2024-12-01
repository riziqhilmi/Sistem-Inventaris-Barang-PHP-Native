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

// Query untuk mengambil jumlah barang masuk per barang
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

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        h1 {
            font-size: 2.5rem;
            color: #4CAF50;
        }

        .chart-container {
            margin: 50px 0;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: white;
            padding: 20px;
            display: none;
        }
        .chart-title {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .page-title-container {
            position: relative;
            margin-top: 50px;
            margin-bottom: 70px;
        }
        .page-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #0056b3;
            text-transform: uppercase;
        }
        .page-subtitle {
            text-align: center;
            font-size: 1rem;
            color: #6c757d;
        }
        .small-dropdown-container {
    position: absolute;
    top: 100%;
    left: 10px;
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 10;
}

.small-dropdown {
    width: 250px;
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.small-dropdown:hover {
    border-color: #4CAF50;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    transform: translateY(-2px);
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
    margin-top: 20px; /* Tambahkan jarak di atas */
    margin-bottom: 20px;
}

.cancel-btn:hover {
    background-color: #45a049;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
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

        .chart-title {
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #388E3C;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Title -->
        <div class="page-title-container">
            <h1 class="page-title">VISUALISASI DATA BARANG MASUK</h1>
            <p class="page-subtitle">Pantau data barang masuk Anda dengan grafik interaktif</p>
            
            <!-- Small Dropdown and Back Button Container -->
            <div class="small-dropdown-container">
                <a href="../data_visualisasi.php" class="cancel-btn" onclick="closeModal()">Kembali</a>
                <select id="chartSelector" class="form-select form-select-sm small-dropdown">
                    <option value="lineChartContainer">Jumlah Barang Masuk per Tanggal</option>
                    <option value="barChartContainer">Jumlah Barang Masuk per Barang</option>
                </select>
            </div>
        </div>

        <!-- Line Chart untuk jumlah barang masuk berdasarkan tanggal -->
        <div id="lineChartContainer" class="chart-container">
            <div class="chart-title">Jumlah Barang Masuk per Tanggal</div>
            <canvas id="lineChartBarangMasuk" width="400" height="200"></canvas>
        </div>

        <!-- Bar Chart untuk jumlah barang masuk per barang -->
        <div id="barChartContainer" class="chart-container">
            <div class="chart-title">Jumlah Barang Masuk per Barang</div>
            <canvas id="barChartBarangMasuk" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan diagram berdasarkan pilihan dropdown
        document.getElementById('chartSelector').addEventListener('change', function() {
            const charts = document.querySelectorAll('.chart-container');
            charts.forEach(chart => chart.style.display = 'none');
            document.getElementById(this.value).style.display = 'block';
        });

        // Tampilkan chart pertama secara default
        document.getElementById('lineChartContainer').style.display = 'block';

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

        function closeModal() {
            window.close();
        }
    </script>
</body>
</html>