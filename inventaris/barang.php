<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}
?>
<?php
include("../koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="../img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include '../partials/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="container">
                <h1 class="mb-4">Item Barang</h1>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#addTeacherModal">
                                Tambah Data Barang
                            </button>
                            <form class="d-flex mb-3" id="searchForm" method="GET">
                                <input type="text" class="form-control form-control-sm me-2" name="query"
                                       placeholder="Cari barang..." style="width: 200px;" required>
                                <button class="btn btn-primary btn-sm me-2" type="submit">Search</button>
                                <a class="btn btn-danger btn-sm" href="barang.php">Reset</a>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Merek</th>
                                    <th>Kategori</th>
                                    <th>Ruangan</th>
                                    <th>Kondisi</th>
                                    <th>Jumlah Awal</th>
                                    <th>Jumlah Sekarang</th>
                                    <th>TGL Pengadaan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php
                                // Tentukan jumlah item per halaman
                                $items_per_page = 10;

                                // Ambil nomor halaman dari URL (default adalah 1 jika tidak ada)
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                                // Hitung offset untuk query SQL
                                $offset = ($page - 1) * $items_per_page;

                                // Periksa apakah ada pencarian
                                $query = isset($_GET['query']) ? $_GET['query'] : '';
                                if ($query) {
                                    $query = mysqli_real_escape_string($koneksi, $query);
                                    $sql = "SELECT * FROM barang 
                                            WHERE nama LIKE '%$query%' 
                                               OR merek LIKE '%$query%'
                                               OR kategori LIKE '%$query%' 
                                               OR ruangan LIKE '%$query%' 
                                               OR kondisi LIKE '%$query%' 
                                               OR jumlah_awal LIKE '%$query%' 
                                               OR jumlah_akhir LIKE '%$query%' 
                                               OR tgl LIKE '%$query%' 
                                               OR keterangan LIKE '%$query%' 
                                            LIMIT $items_per_page OFFSET $offset";
                                    $count_query = "SELECT COUNT(*) as total 
                                                    FROM barang 
                                                    WHERE nama LIKE '%$query%' 
                                                       OR merek LIKE '%$query%' 
                                                       OR kategori LIKE '%$query%' 
                                                       OR ruangan LIKE '%$query%' 
                                                       OR kondisi LIKE '%$query%' 
                                                       OR jumlah_awal LIKE '%$query%' 
                                                       OR jumlah_akhir LIKE '%$query%' 
                                                       OR tgl LIKE '%$query%' 
                                                       OR keterangan LIKE '%$query%'";
                                } else {
                                    $sql = "SELECT * FROM barang LIMIT $items_per_page OFFSET $offset";
                                    $count_query = "SELECT COUNT(*) as total FROM barang";
                                }

                                // Hitung total item dan total halaman
                                $result = mysqli_query($koneksi, $count_query);
                                $total_items = mysqli_fetch_assoc($result)['total'];
                                $total_pages = ceil($total_items / $items_per_page);

                                // Eksekusi query untuk data barang
                                $result = mysqli_query($koneksi, $sql);
                                $no = $offset + 1;

                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['merek']; ?></td>
                                        <td><?php echo $row['kategori']; ?></td>
                                        <td><?php echo $row['ruangan']; ?></td>
                                        <td><?php echo $row['kondisi']; ?></td>
                                        <td><?php echo $row['jumlah_awal']; ?></td>
                                        <td><?php echo $row['jumlah_akhir']; ?></td>
                                        <td><?php echo $row['tgl']; ?></td>
                                        <td><?php echo $row['keterangan']; ?></td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editTeacherModal<?php echo $row['id_barang']; ?>">
                                                Edit
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <a href="../fitur/hapus_barang.php?id=<?php echo $row['id_barang']; ?>"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');"
                                               class="btn btn-danger btn-sm">
                                                Hapus
                                            </a>
                                            <!-- Tombol Cetak Barcode -->
                                            <a href="../fitur/generate_barcode.php?id=<?php echo $row['id_barang']; ?>"
                                               target="_blank" class="btn btn-info btn-sm mt-1">
                                                Cetak Barcode
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                        echo "<div class='d-flex justify-content-center align-items-center my-3'>";
                        if ($page > 1) {
                            echo '<a href="?page=' . ($page - 1) . '" class="btn btn-secondary mx-1">Sebelumnya</a>';
                        } else {
                            echo '<span class="btn btn-secondary disabled mx-1">Sebelumnya</span>';
                        }
                        echo "<div class='mx-2'>";
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<span class="btn btn-primary mx-1">' . $i . '</span>';
                            } else {
                                echo '<a href="?page=' . $i . '" class="btn btn-outline-secondary mx-1">' . $i . '</a>';
                            }
                        }
                        echo "</div>";
                        if ($page < $total_pages) {
                            echo '<a href="?page=' . ($page + 1) . '" class="btn btn-secondary mx-1">Berikutnya</a>';
                        } else {
                            echo '<span class="btn btn-secondary disabled mx-1">Berikutnya</span>';
                        }
                        echo "</div>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
