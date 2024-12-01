<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login2.php');
    exit();
}
?>
<?php
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
                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Daftar Siswa Pasarejo 1</h1>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">


                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3">
                                    <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                        data-bs-target="#addTeacherModal">
                                        Tambah Data Siswa
                                    </button>

                                    <form class="d-flex mb-3" id="searchForm" method="GET">
                                        <input type="text" class="form-control form-control-sm me-2" name="query"
                                            placeholder="Cari Siswa..." style="width: 200px;" required>
                                        <button class="btn btn-primary btn-sm me-2" type="submit">Search</button>
                                        <a class="btn btn-danger btn-sm" href="data_siswa.php">Reset</a>
                                    </form>

                                </div>

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
                                        $query = isset($_GET['query']) ? $_GET['query'] : '';

                                        if ($query != '') {
                                            $sql = "SELECT * FROM siswa WHERE nama LIKE '%$query%' OR NIS LIKE '%$query%'OR NISN LIKE '%$query%' OR jenis_kelamin LIKE '%$query%' OR tempat_lahir LIKE '%$query%' OR tgl_lahir LIKE '%$query%' OR agama LIKE '%$query%' OR alamat LIKE '%$query%'";
                                        } else {
                                            $sql = "SELECT * FROM siswa";
                                        }

                                        $result = mysqli_query($koneksi, $sql);
                                        $total_rows = mysqli_num_rows($result); // Hitung total baris

                                        // Pagination
                                        $items_per_page = 10;
                                        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                        $offset = ($page - 1) * $items_per_page;
                                        
                                        if ($query != '') {
                                            $sql = "SELECT * FROM siswa WHERE nama LIKE '%$query%' OR NIS LIKE '%$query%' OR NISN LIKE '%$query%' OR jenis_kelamin LIKE '%$query%' OR tempat_lahir LIKE '%$query%' OR tgl_lahir LIKE '%$query%' OR agama LIKE '%$query%' OR alamat LIKE '%$query%' LIMIT $items_per_page OFFSET $offset";
                                        } else {
                                            $sql = "SELECT * FROM siswa LIMIT $items_per_page OFFSET $offset";
                                        }

                                        $result = mysqli_query($koneksi, $sql);
                                        $no = $offset + 1; // Mulai nomor urut dari offset

                                        while ($row = mysqli_fetch_array($result)) {
                                            $nama = $row['nama'];
                                            $nis = $row['NIS'];
                                            $nisn = $row['NISN'];
                                            $jenis_kelamin = $row['jenis_kelamin'];
                                            $tempatLahir = $row['tempat_lahir'];
                                            $tglLahir = $row['tgl_lahir'];
                                            $agama = $row['agama'];
                                            $alamat = $row['alamat'];
                                            ?>


                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $nama; ?></td>
                                                <td><?php echo $nis; ?></td>
                                                <td><?php echo $nisn; ?></td>
                                                <td><?php echo ($jenis_kelamin === 'Laki-laki') ? 'Laki-laki' : 'Perempuan'; ?></td>
                                                <td><?php echo $tempatLahir; ?></td>
                                                <td><?php echo $tglLahir; ?></td>
                                                <td><?php echo $agama; ?></td>
                                                <td><?php echo $alamat; ?></td>

                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editTeacherModal<?php echo $row['id_siswa']; ?>">
                                                        Edit
                                                    </button>
                                                    <a href="fitur/hapus.php?id=<?php echo $row['id_siswa']; ?>"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus Siswa ini?');"
                                                        class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Data Siswa -->
<div class="modal fade" id="editTeacherModal<?php echo $row['id_siswa']; ?>" tabindex="-1" aria-labelledby="editTeacherLabel<?php echo $row['id_siswa']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg for a wider form -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeacherLabel<?php echo $row['id_siswa']; ?>">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="fitur/edit_siswa.php" method="POST">
                    <input type="hidden" name="id_siswa" value="<?php echo $row['id_siswa']; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" name="nis" value="<?php echo $row['NIS']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="jenis_kelamin" required>
                                <option value="Laki-laki" <?php echo ($row['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php echo ($row['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" value="<?php echo $row['tempat_lahir']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tgl_lahir" value="<?php echo $row['tgl_lahir']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" class="form-control" name="agama" value="<?php echo $row['agama']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required><?php echo $row['alamat']; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

                                            <!-- End Modal Edit Data Siswa -->
                                            <?php $no++; } ?>
                                    </table>
                                </div>

                                <!-- Modal for Adding Teacher -->
                    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg"> <!-- Make modal wider -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTeacherLabel">Tambah Data Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="fitur/tambah_siswa.php" method="POST">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="nama" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nis" class="form-label">NIS</label>
                                                <input type="text" class="form-control" name="nis" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="nisn" class="form-label">NISN</label>
                                                <input type="text" class="form-control" name="nisn" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                <select class="form-select" name="jenis_kelamin" required>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                <input type="text" class="form-control" name="tempat_lahir" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control" name="tgl_lahir" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="agama" class="form-label">Agama</label>
                                            <input type="text" class="form-control" name="agama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                                <!-- Pagination -->
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        <?php
                                        $total_pages = ceil($total_rows / $items_per_page);
                                        $prev_page = $page - 1;
                                        $next_page = $page + 1;
                                        ?>
                                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $prev_page; ?>&query=<?php echo $query; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&query=<?php echo $query; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $next_page; ?>&query=<?php echo $query; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>