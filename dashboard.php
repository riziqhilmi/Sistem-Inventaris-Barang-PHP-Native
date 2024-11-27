<?php
session_start(); // Start session

// Menyertakan koneksi database
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login2.php');
    exit();
}

// Sample data for the dashboard
$user_name = $_SESSION['username']; // Username from the session
// Query to get the count of teachers
$result_guru = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM guru");
$data_guru = mysqli_fetch_assoc($result_guru)['total'];

// Query to get the count of students
$result_siswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa");
$data_siswa = mysqli_fetch_assoc($result_siswa)['total'];

// Query to get the count of rooms
$result_ruangan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM ruangan");
$data_ruangan = mysqli_fetch_assoc($result_ruangan)['total'];

// Query to get the count of items (barang)
$result_barang = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang");
$data_barang = mysqli_fetch_assoc($result_barang)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function () {
            showGraph();
        });

        function showGraph() {
            $.post("bar_encode.php", function (data) {
                console.log(data);
                var id = [];
                var jual = [];

                for (var i in data) {
                    id.push(data[i].nama);
                    jual.push(data[i].jumlah_akhir);
                }

                var chartdata = {
                    labels: id,
                    datasets: [
                        {
                            label: 'Nama Barang',
                            backgroundColor: '#49e2ff',
                            hoverBackgroundColor: '#CCCCCC',
                            hoverBorderColor: '#666666',
                            data: jual
                        }
                    ]
                };

                var graphTarget = $("#graphCanvas");

                // Create the bar chart with animation options
                var barGraph = new Chart(graphTarget, {
                    type: 'bar',
                    data: chartdata,
                    options: {
                        responsive: true,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutBounce',
                        }
                    }
                });
            });
        }
    </script>

<style>
        /* CSS untuk memberi warna latar belakang pada setiap card */
        .card-guru {
            background-color: #f7d7a3; /* Warna kuning muda untuk Data Guru */
        }

        .card-siswa {
            background-color: #a3d8f7; /* Warna biru muda untuk Data Siswa */
        }

        .card-ruangan {
            background-color: #d9f7a3; /* Warna hijau muda untuk Data Ruangan */
        }

        .card-barang {
            background-color: #f7a3e1; /* Warna merah muda untuk Data Barang */
        }

        .card-body {
            padding: 20px;
        }
        /* CSS untuk Wave Animasi */
.wave-container {
    position: absolute; /* Absolute positioning to place it behind the text */
    bottom: -10px; /* Adjust vertical position */
    left: 0;
    width: 100%; /* Ensure it covers the entire width */
    height: 80px; /* Adjust the height of the wave */
    overflow: hidden;
    z-index: -1; /* Ensure it's behind the text */
}

.wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 200%; /* Stretch the wave across the width */
    height: 80px; /* Match the height of the container */
    background: linear-gradient(90deg, #49e2ff 25%, #f7d7a3 50%, #a3d8f7 75%);
    animation: waveAnimation 5s linear infinite;
}

/* Animasi Gelombang */
@keyframes waveAnimation {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%); /* Moves the wave across 50% */
    }
}
    </style>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="col-md-10 p-4">

            <!-- Dashboard Header -->
            <div class="row mb-4">
                <div class="col-md-15 position-relative"> <!-- Add position-relative here -->
                    <h1 class="text-start">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
                    <!-- Wave Animation Behind Text -->
                    <div class="wave-container">
                        <div class="wave"></div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Statistics -->
            <div class="row mb-4">
                <!-- Number of Teachers -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center card-guru">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Guru</h5>
                            <p class="display-4"><?php echo $data_guru; ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Number of Students -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center card-siswa">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Siswa</h5>
                            <p class="display-4"><?php echo $data_siswa; ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Digital Books -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center card-ruangan">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Ruangan</h5>
                            <p class="display-4"><?php echo $data_ruangan; ?></p>
                        </div>
                    </div>
                </div>

                <!-- Interactive Content -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center card-barang">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Barang</h5>
                            <p class="display-4"><?php echo $data_barang; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graph Section -->
            <div class="row">
                <div class="col-lg-12">
                    <canvas id="graphCanvas" style="height: 400px; width: 100%;"></canvas> <!-- Canvas for the graph -->
                </div>
            </div>

        </div>
    </div>
</div>

</body>  
</html>
