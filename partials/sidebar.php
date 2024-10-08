<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="height: 100vh;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <img src="img/logo_sd.png" alt="Logo" class="rounded-circle logo-white" width="40" height="40">

        <span class="fs-4 ms-2">SD Pasarejo 1</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link active" aria-current="page">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#people"/></svg>
                Data Guru
            </a>
        </li>
        <li>
            <a href="data_siswa.php" class="nav-link text-white">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
                Data Siswa
            </a>
        </li>
        
        <li>
            <a href="#inventarisSubMenu" class="nav-link text-white" data-bs-toggle="collapse">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#folder"/></svg>
                Inventaris
            </a>
            <ul class="collapse" id="inventarisSubMenu">
                <li>
                    <a href="#" class="nav-link text-white ms-3">Barang</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white ms-3">Suplier</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white ms-3">Barang Masuk</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white ms-3">Barang Keluar</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white ms-3">Distribusi</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#laporanSubMenu" class="nav-link text-white" data-bs-toggle="collapse">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#file-earmark"/></svg>
                Laporan
            </a>
            <ul class="collapse" id="laporanSubMenu">
                <li>
                    <a href="#" class="nav-link text-white ms-3">Laporan Siswa</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white ms-3">Laporan Guru</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white ms-3">Laporan Inventaris</a>
                </li>
            </ul>
        </li>
        
    </ul>
    <hr>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
</div>
