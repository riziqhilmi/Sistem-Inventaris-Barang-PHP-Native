<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}
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
    <script>$(document).ready(function () {
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

        var barGraph = new Chart(graphTarget, {
            type: 'bar',
            data: chartdata
        });
    });
}
</script> <!-- Panggil file bar.js di sini -->
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="container">
                <h1 class="mb-4">Dashboard</h1>

                <!-- Graph -->
                <div class="row">
                    <div class="col-lg-12">
                        <canvas id="graphCanvas"></canvas> <!-- Canvas untuk grafik -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
