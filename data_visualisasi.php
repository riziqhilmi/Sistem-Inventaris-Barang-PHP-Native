<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/visualisasi.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'partials/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="container">
                    <h1 class="mb-4">Data Visualisasi</h1>
                    <div class="container">
                        <div class="row">
                            <!-- Card 1 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data visualisasi guru</h4>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 2 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data visualisasi siswa</h4>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 3 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data visualisasi barang</h4>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Card 4 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/barang_masuk.png" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data visualisasi barang masuk</h4>
                                        <a href="#" id="showGrafikBarangMasuk" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#grafikModal">Tampilkan Grafik</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 5 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data visualisasi barang keluar</h4>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 6 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Peminjaman</h4>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="grafikModal" tabindex="-1" aria-labelledby="grafikModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="grafikModalLabel">Grafik Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Inisialisasi grafik saat modal ditampilkan
            const grafikModal = document.getElementById("grafikModal");
            grafikModal.addEventListener("shown.bs.modal", function () {
                const ctx = document.getElementById("lineChart").getContext("2d");
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
                        datasets: [{
                            label: 'Barang Masuk',
                            data: [10, 20, 15, 25, 30],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                enabled: true,
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Jumlah Barang'
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
