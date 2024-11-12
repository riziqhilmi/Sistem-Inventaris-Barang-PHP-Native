<?php
$base_url = "/project"; // Sesuaikan dengan folder root proyek kamu
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sidebar.js"></script>
<div class="col-md-2 sidebar bg-dark sticky-top p-0">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary" style="height: 100vh;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="/project/img/logo_sd.png" alt="Logo" class="rounded-circle logo-white" width="40" height="40">
            <span class="fs-4 ms-2">SD Pasarejo 1</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="/project/dashboard.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#file-earmark" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/project/data_guru.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#people" />
                    </svg>
                    Data Guru
                </a>
            </li>
            <li>
                <a href="/project/data_siswa.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#grid" />
                    </svg>
                    Data Siswa
                </a>
            </li>
            <li>
                <a href="/project/data_kelas.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#grid" />
                    </svg>
                    Data Kelas
                </a>
            </li>
            <li>
                <a href="#inventarisSubMenu" class="nav-link text-white" data-bs-toggle="collapse">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#folder" />
                    </svg>
                    Inventaris
                </a>
                <ul class="collapse" id="inventarisSubMenu">
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/barang.php" class="nav-link text-white ms-3">Barang</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/barang_masuk.php" class="nav-link text-white ms-3 show">Barang Masuk</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/barang_keluar.php" class="nav-link text-white ms-3 show">Barang Keluar</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/peminjaman.php" class="nav-link text-white ms-3 show">Peminjaman</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#laporanSubMenu" class="nav-link text-white" data-bs-toggle="collapse">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#file-earmark" />
                    </svg>
                    Laporan
                </a>
                <ul class="collapse" id="laporanSubMenu">
                    <li>
                        <a href="<?php echo $base_url; ?>/laporan/laporan_siswa.php"
                            class="nav-link text-white ms-3">Laporan Siswa</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/laporan/laporan_guru.php" class="nav-link text-white ms-3">Laporan
                            Guru</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/laporan/laporan_inventaris.php"
                            class="nav-link text-white ms-3">Laporan Inventaris</a>
                    </li>
                </ul>
            </li>
        </ul>
        <hr>
        <a href="/project/fitur/logout.php" class="btn btn-outline-light">Logout</a>
        <script src="https://cdn.jsdelivr.net/npm/sidebar.js"></script>
    </div>
</div>