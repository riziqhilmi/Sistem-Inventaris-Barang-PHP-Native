<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login2.php');
    exit();
}

include("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'partials/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="container">
                    <h1 class="mb-4">Data Siswa</h1>
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <h1 class="h3 mb-2 text-gray-800">Daftar Siswa Pasarejo 1</h1>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <!-- Tombol tambah siswa dan pencarian -->
                                <div class="d-flex justify-content-between mb-3">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addTeacherModal">Tambah Data Siswa</button>
                                    <form class="d-flex mb-3" method="GET">
                                        <input type="text" class="form-control form-control-sm me-2" name="query" placeholder="Cari Siswa..." value="<?= htmlspecialchars(isset($_GET['query']) ? $_GET['query'] : ''); ?>" style="width: 200px;">
                                        <button class="btn btn-primary btn-sm me-2" type="submit">Search</button>
                                        <a class="btn btn-danger btn-sm" href="data_siswa.php">Reset</a>
                                    </form>
                                </div>

                                <!-- Tabel Data Siswa -->
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Agama</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                        <?php
                                        $query = isset($_GET['query']) ? mysqli_real_escape_string($koneksi, $_GET['query']) : '';
                                        $sql_base = "SELECT * FROM siswa";
                                        if ($query) {
                                            $sql_base .= " WHERE nama LIKE '%$query%' OR NIS LIKE '%$query%' OR NISN LIKE '%$query%' OR jenis_kelamin LIKE '%$query%' OR tempat_lahir LIKE '%$query%' OR tgl_lahir LIKE '%$query%' OR agama LIKE '%$query%' OR alamat LIKE '%$query%'";
                                        }

                                        $items_per_page = 10;
                                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $items_per_page;

                                        $sql_count = str_replace("*", "COUNT(*) as total", $sql_base);
                                        $result_count = mysqli_query($koneksi, $sql_count);
                                        $total_items = mysqli_fetch_assoc($result_count)['total'];
                                        $total_pages = ceil($total_items / $items_per_page);

                                        $sql_base .= " LIMIT $offset, $items_per_page";
                                        $result = mysqli_query($koneksi, $sql_base);

                                        if (mysqli_num_rows($result) > 0) {
                                            $no = $offset + 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "
                                                <tr>
                                                    <td>{$no}</td>
                                                    <td>{$row['nama']}</td>
                                                    <td>{$row['NIS']}</td>
                                                    <td>{$row['NISN']}</td>
                                                    <td>" . ($row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan') . "</td>
                                                    <td>{$row['tempat_lahir']}</td>
                                                    <td>{$row['tgl_lahir']}</td>
                                                    <td>{$row['agama']}</td>
                                                    <td>{$row['alamat']}</td>
                                                    <td>
                                                        <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editTeacherModal{$row['id_siswa']}'>Edit</button>
                                                        <a href='fitur/hapus.php?id={$row['id_siswa']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus?');\">Hapus</a>
                                                    </td>
                                                </tr>";
                                                $no++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='10' class='text-center'>Data tidak ditemukan</td></tr>";
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigasi Pagination -->
                    <div class="d-flex justify-content-center">
                        <?php if ($page > 1) : ?>
                            <a href="?page=<?= $page - 1; ?>" class="btn btn-secondary mx-1">Sebelumnya</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <a href="?page=<?= $i; ?>" class="btn <?= ($i == $page) ? 'btn-primary' : 'btn-outline-secondary'; ?> mx-1"><?= $i; ?></a>
                        <?php endfor; ?>
                        <?php if ($page < $total_pages) : ?>
                            <a href="?page=<?= $page + 1; ?>" class="btn btn-secondary mx-1">Berikutnya</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
