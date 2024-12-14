<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $nama_peminjam = $_POST['nama_peminjam'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $jumlah_pinjam = $_POST['jumlah_pinjam'];
    $keterangan = $_POST['keterangan'];
    $created_by = $_SESSION['user_id']; // Ambil ID pengguna dari sesi

    $koneksi->begin_transaction();

    try {
        $cek_stok_query = "SELECT jumlah_akhir FROM barang WHERE id_barang = ?";
        $cek_stmt = $koneksi->prepare($cek_stok_query);
        $cek_stmt->bind_param("i", $id_barang);
        $cek_stmt->execute();
        $cek_stmt->bind_result($stok_akhir);
        $cek_stmt->fetch();
        $cek_stmt->close();

        if ($jumlah_pinjam > $stok_akhir) {
            throw new Exception("Jumlah pinjaman melebihi stok yang tersedia.");
        }

        $query = "INSERT INTO peminjaman (id_barang, nama_peminjam, tanggal_pinjam, tanggal_kembali, jumlah_pinjam, keterangan, created_by) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("isssssi", $id_barang, $nama_peminjam, $tanggal_pinjam, $tanggal_kembali, $jumlah_pinjam, $keterangan, $created_by); // Tambahkan created_by
        $stmt->execute();

        $query = "UPDATE barang SET jumlah_akhir = jumlah_akhir - ? WHERE id_barang = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ii", $jumlah_pinjam, $id_barang);
        $stmt->execute();

        $koneksi->commit();
        $_SESSION['success'] = "Data peminjaman berhasil ditambahkan";
        header('Location: peminjaman.php');
        exit();
    } catch (Exception $e) {
        $koneksi->rollback();
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return'])) {
    $id_peminjaman = $_POST['id_peminjaman'];
    $tanggal_kembali = date('Y-m-d'); 

    $koneksi->begin_transaction();

    try {
        $query = "UPDATE peminjaman SET status = 'Dikembalikan', tanggal_kembali = ? WHERE id_peminjaman = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("si", $tanggal_kembali, $id_peminjaman);
        $stmt->execute();

        $query = "SELECT id_barang, jumlah_pinjam FROM peminjaman WHERE id_peminjaman = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id_peminjaman);
        $stmt->execute();
        $stmt->bind_result($id_barang, $jumlah_pinjam);
        $stmt->fetch();
        $stmt->close();

        $query = "UPDATE barang SET jumlah_akhir = jumlah_akhir + ? WHERE id_barang = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ii", $jumlah_pinjam, $id_barang);
        $stmt->execute();

        $koneksi->commit();
        $_SESSION['success'] = "Barang berhasil dikembalikan.";
    } catch (Exception $e) {
        $koneksi->rollback();
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    }

    header('Location: peminjaman.php');
    exit();
}
$query_ruangan = "SELECT id_ruangan, nama_ruangan FROM ruangan ORDER BY nama_ruangan";
$result_ruangan = $koneksi->query($query_ruangan);
$ruangan_list = $result_ruangan->fetch_all(MYSQLI_ASSOC);

$barang_list = [];

if (isset($_GET['id_ruangan']) && !empty($_GET['id_ruangan'])) {
    $id_ruangan = $_GET['id_ruangan'];
    $query = "SELECT id_barang, nama, merek FROM barang WHERE ruangan = (SELECT nama_ruangan FROM ruangan WHERE id_ruangan = ?) ORDER BY nama";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_ruangan);
    $stmt->execute();
    $result = $stmt->get_result();
    $barang_list = $result->fetch_all(MYSQLI_ASSOC);
    }
    $query = "SELECT p.*, b.nama, b.merek, u.username 
    FROM peminjaman p 
    JOIN barang b ON p.id_barang = b.id_barang 
    LEFT JOIN user u ON p.created_by = u.id_user 
    ORDER BY p.tanggal_pinjam DESC 
    LIMIT 10";
$transactions = $koneksi->query($query)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Barang</title>
    <link rel="icon" type="image/png" href="../img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/peminjaman.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include '../partials/sidebar.php'; ?>
        
        <!-- Konten Utama -->
        <div class="col-md-10 p-4">
            <div class="container">
                <h1 class="mb-4">Peminjaman Barang</h1>

                <?php if (isset($_SESSION['success'])):
                    echo '<script>Swal.fire({
                        title: "SUCCESS",
                        text: "' . $_SESSION['success'] . '",
                        icon: "success"
                    });</script>';
                    unset($_SESSION['success']);
                    endif;
                    ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?=$_SESSION['error'];?></strong>
                        <?php 
                        unset($_SESSION['error']);
                        ?>
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Input Peminjaman -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"></h5>
                        Form Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                    <label for="id_ruangan" class="form-label">Pilih Ruangan</label>
                                    <select class="form-select" id="id_ruangan" onchange="filterBarang(this.value)">
                                        <option value="">Pilih Ruangan</option>
                                        <?php foreach ($ruangan_list as $ruangan): ?>
                                            <option value="<?= $ruangan['id_ruangan'] ?>"
                                                <?= (isset($_GET['id_ruangan']) && $_GET['id_ruangan'] == $ruangan['id_ruangan']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($ruangan['nama_ruangan']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="id_barang" class="form-label">Pilih Barang</label>
                                    <select class="form-select" name="id_barang" id="id_barang" required>
                                        <option value="">Pilih Barang (Pilih Ruangan Terlebih Dahulu)</option>
                                        <?php foreach ($barang_list as $barang): ?>
                                            <option value="<?= $barang['id_barang'] ?>">
                                                <?= htmlspecialchars($barang['nama']) ?> - 
                                                <?= htmlspecialchars($barang['merek']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                                    <input type="text" class="form-control" name="nama_peminjam" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                    <input type="date" class="form-control" name="tanggal_pinjam" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_pinjam" class="form-label">Jumlah Pinjam</label>
                                    <input type="number" class="form-control" name="jumlah_pinjam" required min="1">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3" required></textarea>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary float-right" style="float: right;"> <img src="../img/save.png" alt="icon" style="width: 20px; height: 20px; vertical-align:middle; margin-right:5px;">Simpan</button>             
                            <a href="javascript:void(0);" onclick="previewPDF()" class="btn btn-success float-right" style="float: right; margin-right: 10px;">
                            <img src="../img/printt.png" alt="Icon" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                            Cetak Riwayat Harian </a>
                        </form>
                    </div>
                </div>

                <div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Riwayat Peminjaman</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Merek</th>
                        <th>Jumlah Pinjam</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Dibuat Oleh</th> <!-- Kolom untuk nama pembuat -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $index => $trans): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= date('d/m/Y', strtotime($trans['tanggal_pinjam'])) ?></td>
                            <td><?= $trans['tanggal_kembali'] ? date('d/m/Y', strtotime($trans['tanggal_kembali'])) : '-' ?></td>
                            <td><?= htmlspecialchars($trans['nama_peminjam']) ?></td>
                            <td><?= htmlspecialchars($trans['nama']) ?></td>
                            <td><?= htmlspecialchars($trans['merek']) ?></td>
                            <td><?= $trans['jumlah_pinjam'] ?></td>
                            <td><?= htmlspecialchars($trans['keterangan']) ?></td>
                            <td>
                            <?php 
                                if ($trans['status'] === 'Terlambat') {
                                    echo '<span class="btn bg-danger" style="color: white;">Terlambat</span>';
                                } elseif ($trans['status'] === 'Dikembalikan') {
                                    echo '<span class="btn bg-success" style="color: white;">Dikembalikan</span>';
                                } else {
                                    echo '<span class="btn bg-warning btn-sm" style="color: white;">Dipinjam</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($trans['status'] === 'Dipinjam'): ?>
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_peminjaman" value="<?= $trans['id_peminjaman'] ?>">
                                        <button type="submit" name="return" class="btn btn-danger btn-sm">Kembalikan</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($trans['username'] ?? 'Tidak Diketahui') ?></td> <!-- Menampilkan username atau 'Tidak Diketahui' -->
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($transactions)): ?>
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada data peminjaman</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
                        <!-- Grafik -->
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Grafik Peminjaman per Bulan</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="peminjaman_chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Grafik Barang Terpopuler</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="popular_items_chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <script>
                        function filterBarang(ruanganId) {
                                if (ruanganId) {
                                    window.location.href = 'peminjaman.php?id_ruangan=' + ruanganId;
                                } else {
                                    $('#id_barang').html('<option value="">Pilih Barang (Pilih Ruangan Terlebih Dahulu)</option>');
                                }
                            }
                        
                        function previewPDF() {
                        // Ganti URL ini dengan URL yang sesuai untuk file PHP Anda
                        var url = '../fitur/cetak_riwayat_peminjaman.php';
                        window.open(url, '_blank');
                    }
                    
                    
                </script>
                </div>

            <!-- Script untuk grafik -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

            <script>
            <?php
            $query_monthly = "SELECT 
                DATE_FORMAT(tanggal_pinjam, '%Y-%m') as bulan,
                COUNT(*) as total_peminjaman
                FROM peminjaman
                GROUP BY DATE_FORMAT(tanggal_pinjam, '%Y-%m')
                ORDER BY bulan DESC
                LIMIT 6";
            $monthly_data = $koneksi->query($query_monthly)->fetch_all(MYSQLI_ASSOC);
            $monthly_data = array_reverse($monthly_data);

            // Data untuk grafik barang terpopuler
            $query_popular = "SELECT 
                b.nama,
                COUNT(*) as total_dipinjam
                FROM peminjaman p
                JOIN barang b ON p.id_barang = b.id_barang
                GROUP BY p.id_barang
                ORDER BY total_dipinjam DESC
                LIMIT 5";
            $popular_data = $koneksi->query($query_popular)->fetch_all(MYSQLI_ASSOC);
            ?>
            
            // Grafik Peminjaman per Bulan
            const ctxMonthly = document.getElementById('peminjaman_chart').getContext('2d');
            new Chart(ctxMonthly, {
                type: 'line',
                data: {
                    labels: <?= json_encode(array_map(function($item) {
                        return date('M Y', strtotime($item['bulan'] . '-01'));
                    }, $monthly_data)) ?>,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: <?= json_encode(array_map(function($item) {
                            return $item['total_peminjaman'];
                        }, $monthly_data)) ?>,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
            

            // Grafik Barang Terpopuler
            const ctxPopular = document.getElementById('popular_items_chart').getContext('2d');
            new Chart(ctxPopular, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_map(function($item) {
                        return $item['nama'];
                    }, $popular_data)) ?>,
                    datasets: [{
                        label: 'Frekuensi Peminjaman',
                        data: <?= json_encode(array_map(function($item) {
                            return $item['total_dipinjam'];
                        }, $popular_data)) ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
            flatpickr("input[type=date]", {
            dateFormat: "Y-m-d",
            maxDate: "today"
});

            </script>
            
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>