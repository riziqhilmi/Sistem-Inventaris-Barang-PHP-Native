<?php
$base_url = "/project";
$current_page = basename($_SERVER['PHP_SELF']); // Mendapatkan nama file dari URL
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="col-md-2 sidebar bg-dark sticky-top p-0">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary" style="height: 100vh;">
        <div class="sidebar-header d-flex flex-column align-items-center justify-content-center text-center">
            <img src="/project/img/logo_sd.png" alt="Logo" class="logo-white mb-2" width="90" height="100">
            <a href="/project/dashboard.php" class="text-decoration-none text-white">
            <span class="fs-4 shiny-text">SDN PASAREJO 1</span>
        </div>
        <style>
            .shiny-text {
                font-weight: bold;
                background: linear-gradient(90deg, #000000, #C62828, #4adeff);
                background-size: 200% auto;
                color: white;
                background-clip: text;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: shine 3s linear infinite;
            }

            @keyframes shine {
                to {
                    background-position: 200% center;
                }
            }

            /* Background putih dan teks hitam untuk menu utama yang aktif */
            .sidebar .nav-link.active-main {
                background-color: white;
                color: black !important;
                border-radius: 10px;
                font-weight: bold;
            }

            /* Submenu tetap default meskipun aktif */
            .sidebar .nav-link.ms-3 {
                color: white !important;
            }

              /* Default styling untuk ikon */
    .icon_sidebar {
        width: 20px;
        height: 20px;
        margin-left: 8px;
        transition: filter 0.3s ease; /* Tambahkan transisi untuk efek halus */
    }

    /* Warna default (ikon tetap putih) */
    .nav-link .icon_sidebar {
        filter: invert(0); /* Ikon putih */
    }

    /* Ketika menu aktif, ubah warna ikon menjadi hitam */
    .nav-link.active-main .icon_sidebar {
        filter: invert(1); /* Ikon hitam */
    }
        </style>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <!-- Menu Data Master -->
                <a href="#inventarisSubMenu"
                    class="nav-link text-white <?php echo (in_array($current_page, ['data_guru.php', 'data_siswa.php', 'data_kelas.php', 'barang.php'])) ? 'active-main' : ''; ?>"
                    data-bs-toggle="collapse">
                    <i class="bi bi-collection"></i> Data Master
                </a>
                <ul class="collapse <?php echo (in_array($current_page, ['data_guru.php', 'data_siswa.php', 'data_kelas.php', 'barang.php'])) ? 'show' : ''; ?>"
                    id="inventarisSubMenu">
                    <li>
                        <a href="<?php echo $base_url; ?>/data_guru.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'data_guru.php') ? '' : ''; ?>">Data Guru</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/data_siswa.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'data_siswa.php') ? '' : ''; ?>">Data Siswa
                            </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/data_kelas.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'data_kelas.php') ? '' : ''; ?>">Data Ruangan
                            </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/barang.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'barang.php') ? '' : ''; ?>">Data Barang</a>
                    </li>
                </ul>
            </li>

            <li>
                <!-- Menu transaksi -->
                <a href="#transaksiSubMenu"
                    class="nav-link text-white <?php echo (in_array($current_page, ['barang_masuk.php', 'barang_keluar.php', 'peminjaman.php'])) ? 'active-main' : ''; ?>"
                    data-bs-toggle="collapse">
                    <i class="bi bi-layout-wtf"></i> Transaksi
                </a>
                <ul class="collapse <?php echo (in_array($current_page, ['barang_masuk.php', 'barang_keluar.php', 'peminjaman.php'])) ? 'show' : ''; ?>"
                    id="transaksiSubMenu">
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/barang_masuk.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'barang_masuk.php') ? '' : ''; ?>">Barang Masuk</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/barang_keluar.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'barang_keluar.php') ? '' : ''; ?>">Barang Keluar</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/inventaris/peminjaman.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'peminjaman.php') ? '' : ''; ?>">Peminjaman</a>
                    </li>
                </ul>
            </li>
            <li>
                <!-- Menu Laporan -->
                <a href="#laporanSubMenu"
                    class="nav-link text-white <?php echo (in_array($current_page, ['laporan_siswa.php', 'laporan_guru.php', 'laporan_inventaris.php'])) ? 'active-main' : ''; ?>"
                    data-bs-toggle="collapse">
                    <i class="bi bi-envelope"></i> Laporan
                </a>
                <ul class="collapse <?php echo (in_array($current_page, ['laporan_siswa.php', 'laporan_guru.php', 'laporan_inventaris.php'])) ? 'show' : ''; ?>"
                    id="laporanSubMenu">
                    <li>
                        <a href="<?php echo $base_url; ?>/laporan/laporan_siswa.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'laporan_siswa.php') ? '' : ''; ?>">Laporan
                            Siswa</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/laporan/laporan_guru.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'laporan_guru.php') ? '' : ''; ?>">Laporan
                            Guru</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/laporan/laporan_inventaris.php"
                            class="nav-link text-white ms-3 <?php echo ($current_page == 'laporan_inventaris.php') ? '' : ''; ?>">Laporan
                            Inventaris</a>
                    </li>
                </ul>
            </li>
            <!-- Menu Visualisasi -->
            <li>
                <a href="/project/data_visualisasi.php"
                class="nav-link text-white <?php echo ($current_page == 'data_visualisasi.php') ? 'active-main' : ''; ?>">
                <i class="bi bi-bar-chart-line"></i> Visualisasi
                </a>
            </li>

        </ul>
        <hr>
        <a href="/project/fitur/logout.php" class="btn btn-outline-light">Logout</a>
    </div>
</div>
