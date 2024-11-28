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
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
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
                                    <img src="img/data_guru.png" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Visualisasi Guru</h4>

                                        <a href="javascript:void(0);" onclick="dsvGuru()" class="btn  btn-primary btn-right"><strong>Lihat
                                            Selengkapnya</strong> <img src="img/panah.png" alt="Ikon"
                                                style="width: 27px; height: 27px; margin-left: 4px;"></a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 2 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/data_siswa.png" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Visualisasi Siswa</h4>
                                        <a href="javascript:void(0);" onclick="dsvSiswa()" class="btn  btn-primary btn-right"><strong>Lihat
                                            Selengkapnya</strong> <img src="img/panah.png" alt="Ikon"
                                                style="width: 27px; height: 27px; margin-left: 4px;"></a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 3 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/data_barang.png" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Visualisasi Barang</h4>

                                        <a href="javascript:void(0);" onclick="dsvBarang()"
                                            class="btn  btn-primary btn-right"><strong>Lihat Selengkapnya</strong> <img src="img/panah.png" alt="Ikon"
                                                style="width: 27px; height: 27px; margin-left: 4px;"></a>
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
                                        <h4 class="card-title">Data Visualisasi Barang Masuk</h4>
                                        <a href="javascript:void(0);" onclick="dsvBarangMasuk()"
                                            class="btn  btn-primary btn-right"><strong>Lihat Selengkapnya</strong><img src="img/panah.png" alt="Ikon"
                                            style="width: 27px; height: 27px; margin-left: 4px;">
                                            </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 5 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Visualisasi Barang Keluar</h4>

                                        <a href="javascript:void(0);" onclick="dsvBarangKeluar()"
                                            class="btn btn-primary btn-right"><strong>Lihat Selengkapnya</strong>
                                            <img src="img/panah.png" alt="Ikon"
                                                style="width: 27px; height: 27px; margin-left: 4px;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 6 -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card small-card">
                                    <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Visualisasi Peminjaman</h4>

                                        <a href="javascript:void(0);" onclick="dsvPeminjaman()"
                                            class="btn btn-primary btn-right"><strong>
                                            Lihat Selengkapnya</strong>
                                            <img src="img/panah.png" alt="Ikon"
                                                style="width: 27px; height: 27px; margin-left: 4px;">
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="grafikModal" tabindex="-1" aria-labelledby="grafikModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="grafikModalLabel">Grafik Barang Masuk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>



</body>
<script>

    function dsvBarang() {
        var url = '../project/fitur/visualisasi_barang.php';
        window.open(url, '_blank');
    }
    function dsvGuru() {
        var url = '../project/fitur/visual_guru.php';
        window.open(url, '_blank');
    }

    function dsvSiswa() {
        var url = '../project/fitur/visual_siswa.php';
        window.open(url, '_blank');
    }

    function dsvBarangMasuk() {
        var url = '../project/fitur/visual_barang_masuk.php';
        window.open(url, '_blank');
    }

    function dsvBarangKeluar() {
        var url = '../project/fitur/visual_barang_keluar.php';
        window.open(url, '_blank');
    }

    function dsvPeminjaman() {
        var url = '../project/fitur/visual_peminjaman.php';
        window.open(url, '_blank');
    }

</script>

</html>