<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('../koneksi.php');


// Query untuk data peminjaman
$sql_peminjaman = "SELECT tanggal_pinjam, nama_peminjam, SUM(jumlah_pinjam) AS total_pinjam 
                   FROM peminjaman 
                   GROUP BY tanggal_pinjam, nama_peminjam 
                   LIMIT 0, 25;";

$result = mysqli_query($koneksi, $sql_peminjaman);

// Pastikan data direset sebelum digunakan
$labels_tanggal = [];
$data_jumlah_pinjam = [];
$data_nama_peminjam = [];

// Mengelompokkan data untuk chart
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $labels_tanggal[] = $row['tanggal_pinjam'];
        $data_jumlah_pinjam[] = $row['total_pinjam'];
        $data_nama_peminjam[] = $row['nama_peminjam'];
    }
} else {
    echo "Tidak ada data.";
}

// Tutup koneksi
mysqli_close($koneksi);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Data Peminjaman</title>
    <link rel="icon" type="image/png" href="../img/logo sd pasarejo.png">
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
            <h1 class="page-title">VISUALISASI DATA PEMINJAMAN</h1>
            <p class="page-subtitle">Pantau data peminjaman Anda dengan grafik interaktif</p>
            
            <!-- Small Dropdown and Back Button Container -->
            <div class="small-dropdown-container">
                <a href="../data_visualisasi.php" class="cancel-btn" onclick="closeModal()">Kembali</a>
                <select id="chartSelector" class="form-select form-select-sm small-dropdown">
                    <option value="lineChartContainer">Peminjaman Berdasarkan Tanggal</option>
                    <option value="barChartContainer">Peminjaman per Nama Peminjam</option>
                    <option value="histogramContainer">Distribusi Jumlah Barang Dipinjam</option>
                </select>
            </div>
        </div>

        <!-- Line Chart untuk jumlah peminjaman berdasarkan tanggal -->
        <div id="lineChartContainer" class="chart-container">
            <div class="chart-title">Jumlah Peminjaman Berdasarkan Tanggal</div>
            <canvas id="lineChart" width="400" height="200"></canvas>
        </div>

        <!-- Bar Chart untuk jumlah peminjaman per nama peminjam -->
        <div id="barChartContainer" class="chart-container">
            <div class="chart-title">Jumlah Peminjaman per Nama Peminjam</div>
            <canvas id="barChart" width="400" height="200"></canvas>
        </div>

        <!-- Histogram untuk distribusi jumlah barang dipinjam -->
        <div id="histogramContainer" class="chart-container">
            <div class="chart-title">Distribusi Jumlah Barang Dipinjam</div>
            <canvas id="histogram" width="400" height="200"></canvas>
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

        // Line Chart: Jumlah Peminjaman Berdasarkan Tanggal
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_tanggal); ?>,
                datasets: [{
                    label: 'Jumlah Barang Dipinjam',
                    data: <?php echo json_encode($data_jumlah_pinjam); ?>,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Jumlah Barang Dipinjam Berdasarkan Tanggal' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Bar Chart: Jumlah Peminjaman per Nama Peminjam
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($data_nama_peminjam); ?>,
                datasets: [{
                    label: 'Jumlah Barang Dipinjam',
                    data: <?php echo json_encode($data_jumlah_pinjam); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Jumlah Barang Dipinjam per Nama Peminjam' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Histogram: Distribusi Jumlah Barang Dipinjam
        const ctxHistogram = document.getElementById('histogram').getContext('2d');
        new Chart(ctxHistogram, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_tanggal); ?>,
                datasets: [{
                    label: 'Distribusi Jumlah Barang Dipinjam',
                    data: <?php echo json_encode($data_jumlah_pinjam); ?>,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribusi Jumlah Barang Dipinjam' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        function closeModal() {
            window.close();
        }
    </script>
</body>
</html>