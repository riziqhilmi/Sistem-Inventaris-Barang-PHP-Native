<?php
$base_url = "/project";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sidebar.js"></script>
<div class="col-md-2 sidebar bg-dark sticky-top p-0">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary" style="height: 100vh;">
    <div class="sidebar-header d-flex flex-column align-items-center justify-content-center text-center">
    <img src="/project/img/logo_sd.png" alt="Logo" class="rounded-circle logo-white mb-2" width="80" height="80">
    <span class="fs-4 shiny-text">SD PASAREJO 1</span>
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
</style>
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