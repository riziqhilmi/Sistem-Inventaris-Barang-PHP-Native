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

    <script>
        function animateAndRedirect(element, url) {
    // Tambahkan kelas animasi
    element.classList.add('fade-out');

    // Tunggu hingga animasi selesai, lalu buka URL
    setTimeout(() => {
        window.open(url, '_blank');
    }, 300); // 300ms sesuai durasi animasi
}

function dsvBarang() {
    const element = event.target.closest('a'); // Ambil elemen tombol
    animateAndRedirect(element, '../project/fitur/visualisasi_barang.php');
}

function dsvGuru() {
    const element = event.target.closest('a');
    animateAndRedirect(element, '../project/fitur/visual_guru.php');
}

function dsvSiswa() {
    const element = event.target.closest('a');
    animateAndRedirect(element, '../project/fitur/visual_siswa.php');
}

function dsvBarangMasuk() {
    const element = event.target.closest('a');
    animateAndRedirect(element, '../project/fitur/visual_barang_masuk.php');
}

function dsvBarangKeluar() {
    const element = event.target.closest('a');
    animateAndRedirect(element, '../project/fitur/visual_barang_keluar.php');
}

function dsvPeminjaman() {
    const element = event.target.closest('a');
    animateAndRedirect(element, '../project/fitur/visual_peminjaman.php');
}

    </script>

    <style>
        /* Tambahkan animasi fade-out */
.fade-out {
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* Efek membesar saat hover */
.btn:hover {
    transform: scale(1.1); /* Membesarkan tombol 10% */
    transition: transform 0.2s ease; /* Transisi halus selama 0.2 detik */
}

/* Untuk membuat efek kembali ke ukuran semula */
.btn {
    transition: transform 0.2s ease; /* Haluskan transisi */
}

/* Efek card saat hover */
.card:hover {
    transform: translateY(-10px) scale(1.05); /* Mengangkat sedikit dan memperbesar */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Memberikan bayangan */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Transisi halus */
}

/* Transisi awal untuk card */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Pastikan kembali halus ke posisi awal */
}

/* Gaya untuk container gambar */
.card-img-container {
    position: relative;
    width: 100%;
    height: auto;
}

.card-img-container img {
    width: 100%;
    height: auto;
    display: block;
    transition: opacity 0.3s ease; /* Transisi halus */
}

.card-img-container .hover-img {
    position: absolute;
    top: 80%; /* Geser ke bawah */
    left: 50%; /* Posisikan di tengah */
    transform: translate(-50%, -70%) scale(0.8); /* Tempatkan di atas teks dan kecilkan ukuran */
    opacity: 0; /* Sembunyikan gambar hover secara default */
    pointer-events: none; /* Nonaktifkan interaksi dengan gambar hover */
}

/* Ketika card di-hover */
.card-guru:hover .static-img {
    opacity: 0; /* Sembunyikan gambar default */
}

.card-guru:hover .hover-img {
    opacity: 1; /* Tampilkan gambar animasi */
}

/* Pastikan teks tetap terlihat */
.card-body {
    position: relative; /* Supaya teks tetap terpisah */
    z-index: 2; /* Pastikan teks berada di atas gambar default */
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
                <div class="container">
                    <h1 class="mb-4">Data Visualisasi</h1>
                    <div class="container">
                        <div class="row">
                            <!-- Card 1 -->
                            <div class="col-lg-4 col-md-6 mb-3">
    <div class="card small-card card-guru position-relative">
        <!-- Gambar utama dan gambar hover -->
        <div class="card-img-container">
            <img src="img/data_guru.png" class="card-img-top static-img" alt="jpg">
            <img src="img/pie_chart.gif" class="card-img-top hover-img" alt="Pie Chart">
        </div>
        <div class="card-body">
            <h4 class="card-title">Data Visualisasi Guru</h4>
            <a href="javascript:void(0);" onclick="dsvGuru()" class="btn btn-primary btn-right">
                <strong>Lihat Selengkapnya</strong>
                <img src="img/panah.png" alt="Ikon" style="width: 27px; height: 27px; margin-left: 4px;">
            </a>
        </div>
    </div>
</div>
                            <!-- Card 2 -->
                            <div class="col-lg-4 col-md-6 mb-3">
    <div class="card small-card card-guru position-relative">
        <!-- Gambar utama dan gambar hover -->
        <div class="card-img-container">
            <img src="img/data_siswa.png" class="card-img-top static-img" alt="jpg">
            <img src="img/bar_chart.gif" class="card-img-top hover-img" alt="Pie Chart">
        </div>
        <div class="card-body">
            <h4 class="card-title">Data Visualisasi Siswa</h4>
            <a href="javascript:void(0);" onclick="dsvGuru()" class="btn btn-primary btn-right">
                <strong>Lihat Selengkapnya</strong>
                <img src="img/panah.png" alt="Ikon" style="width: 27px; height: 27px; margin-left: 4px;">
            </a>
        </div>
    </div>
</div>
                            <!-- Card 3 -->
                            <div class="col-lg-4 col-md-6 mb-3">
    <div class="card small-card card-guru position-relative">
        <!-- Gambar utama dan gambar hover -->
        <div class="card-img-container">
            <img src="img/data_barang.png" class="card-img-top static-img" alt="jpg">
            <img src="img/barang_chart.gif" class="card-img-top hover-img" alt="Pie Chart">
        </div>
        <div class="card-body">
            <h4 class="card-title">Data Visualisasi Barang</h4>
            <a href="javascript:void(0);" onclick="dsvBarang()" class="btn btn-primary btn-right">
                <strong>Lihat Selengkapnya</strong>
                <img src="img/panah.png" alt="Ikon" style="width: 27px; height: 27px; margin-left: 4px;">
            </a>
        </div>
    </div>
</div>
                        <div class="row">
                            <!-- Card 4 -->
                            <div class="col-lg-4 col-md-6 mb-3">
    <div class="card small-card card-guru position-relative">
        <!-- Gambar utama dan gambar hover -->
        <div class="card-img-container">
            <img src="img/barang_masuk.png" class="card-img-top static-img" alt="jpg">
            <img src="img/line_chart.gif" class="card-img-top hover-img" alt="line chart">
        </div>
        <div class="card-body">
            <h4 class="card-title">Data Visualisasi Barang Masuk</h4>
            <a href="javascript:void(0);" onclick="dsvBarangMasuk()" class="btn btn-primary btn-right">
                <strong>Lihat Selengkapnya</strong>
                <img src="img/panah.png" alt="Ikon" style="width: 27px; height: 27px; margin-left: 4px;">
            </a>
        </div>
    </div>
</div>
                            <!-- Card 5 -->
                            <div class="col-lg-4 col-md-6 mb-3">
    <div class="card small-card card-guru position-relative">
        <!-- Gambar utama dan gambar hover -->
        <div class="card-img-container">
            <img src="img/vector_visual.jpg" class="card-img-top static-img" alt="jpg">
            <img src="img/keluar.gif" class="card-img-top hover-img" alt="line chart">
        </div>
        <div class="card-body">
            <h4 class="card-title">Data Visualisasi Barang Keluar</h4>
            <a href="javascript:void(0);" onclick="dsvBarangKeluar()" class="btn btn-primary btn-right">
                <strong>Lihat Selengkapnya</strong>
                <img src="img/panah.png" alt="Ikon" style="width: 27px; height: 27px; margin-left: 4px;">
            </a>
        </div>
    </div>
</div>
                            <!-- Card 6 -->
                            <div class="col-lg-4 col-md-6 mb-3">
    <div class="card small-card card-guru position-relative">
        <!-- Gambar utama dan gambar hover -->
        <div class="card-img-container">
            <img src="img/vector_visual.jpg" class="card-img-top static-img" alt="jpg">
            <img src="img/pie2_chart.gif" class="card-img-top hover-img" alt="line chart">
        </div>
        <div class="card-body">
            <h4 class="card-title">Data Visualisasi Peminjaman</h4>
            <a href="javascript:void(0);" onclick="dsvPeminjaman()" class="btn btn-primary btn-right">
                <strong>Lihat Selengkapnya</strong>
                <img src="img/panah.png" alt="Ikon" style="width: 27px; height: 27px; margin-left: 4px;">
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