<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../koneksi.php';

// Menangani submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    // Cek stok tersedia
    $query = "SELECT jumlah_akhir FROM barang WHERE id_barang = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_barang);
    $stmt->execute();
    $result = $stmt->get_result();
    $barang = $result->fetch_assoc();

    if ($barang['jumlah_akhir'] < $jumlah) {
        $_SESSION['error'] = "Stok tidak mencukupi! Stok tersedia: " . $barang['jumlah_akhir'];
    } else {
        // Memulai transaksi
        $koneksi->begin_transaction();

        try {
            // Memasukkan data ke tabel barang_keluar
            $query = "INSERT INTO barang_keluar (id_barang, jumlah, tanggal, keterangan) 
                     VALUES (?, ?, ?, ?)";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("iiss", $id_barang, $jumlah, $tanggal, $keterangan);
            $stmt->execute();

            // Memperbarui jumlah_akhir di tabel barang
            $query = "UPDATE barang SET jumlah_akhir = jumlah_akhir - ? 
                     WHERE id_barang = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("ii", $jumlah, $id_barang);
            $stmt->execute();

            $koneksi->commit();
            $_SESSION['success'] = "Data barang keluar berhasil ditambahkan";
            header('Location: barang_keluar.php');
            exit();
        } catch (Exception $e) {
            $koneksi->rollback();
            $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}

// Mengambil daftar barang
$query = "SELECT id_barang, nama, merek, jumlah_akhir FROM barang ORDER BY nama";
$result = $koneksi->query($query);
$barang_list = $result->fetch_all(MYSQLI_ASSOC);

// Mengambil data transaksi terakhir
$query = "SELECT bk.*, b.nama, b.merek 
          FROM barang_keluar bk 
          JOIN barang b ON bk.id_barang = b.id_barang 
          ORDER BY bk.tanggal DESC 
          LIMIT 10";
$transactions = $koneksi->query($query)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../partials/sidebar.php'; ?>

            <!-- Konten Utama -->
            <div class="col-md-10 p-4">
                <div class="container">
                    <h1 class="mb-4">Barang Keluar</h1>
                    <div class="d-flex justify-content-between mb-3">
                        <button class="btn btn-success btn-sm ms-auto" type="button">
                            <img src="../img/save.png" alt="Icon" width="20" height="20" class="me-1"> Cetak Riwayat
                        </button>
                    </div>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Input Barang Keluar -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Input Barang Keluar</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_barang" class="form-label">Pilih Barang</label>
                                        <select class="form-select" name="id_barang" id="id_barang" required>
                                            <option value="">Pilih Barang</option>
                                            <?php foreach ($barang_list as $barang): ?>
                                                <option value="<?= $barang['id_barang'] ?>"
                                                    data-stok="<?= $barang['jumlah_akhir'] ?>">
                                                    <?= htmlspecialchars($barang['nama']) ?> -
                                                    <?= htmlspecialchars($barang['merek']) ?>
                                                    (Stok: <?= $barang['jumlah_akhir'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" name="jumlah" id="jumlah" required
                                            min="1">
                                        <small class="text-muted" id="stok-info"></small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Riwayat Barang Keluar -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Riwayat Barang Keluar</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Merek</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transactions as $index => $trans): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= date('d/m/Y', strtotime($trans['tanggal'])) ?></td>
                                                <td><?= htmlspecialchars($trans['nama']) ?></td>
                                                <td><?= htmlspecialchars($trans['merek']) ?></td>
                                                <td><?= $trans['jumlah'] ?></td>
                                                <td><?= htmlspecialchars($trans['keterangan']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik -->
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Grafik Barang Keluar</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Inisialisasi date picker
        flatpickr("input[type=date]", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });

        // Validasi stok
        document.getElementById('id_barang').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const stok = selectedOption.dataset.stok;
            const jumlahInput = document.getElementById('jumlah');
            const stokInfo = document.getElementById('stok-info');

            jumlahInput.max = stok;
            stokInfo.textContent = `Stok tersedia: ${stok}`;
        });

        document.getElementById('jumlah').addEventListener('input', function () {
            const selectedOption = document.getElementById('id_barang').options[document.getElementById('id_barang').selectedIndex];
            const stok = selectedOption.dataset.stok;

            if (parseInt(this.value) > parseInt(stok)) {
                this.value = stok;
                alert('Jumlah melebihi stok tersedia!');
            }
        });

        // Mengambil data untuk grafik
        <?php
        $query = "SELECT DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total 
          FROM barang_keluar 
          GROUP BY DATE_FORMAT(tanggal, '%Y-%m') 
          ORDER BY bulan DESC 
          LIMIT 6";
        $chart_data = $koneksi->query($query)->fetch_all(MYSQLI_ASSOC);
        $chart_data = array_reverse($chart_data);
        ?>

        // Inisialisasi grafik
        const ctx = document.getElementById('lineChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_map(function ($item) {
                    return date('M Y', strtotime($item['bulan'] . '-01'));
                }, $chart_data)) ?>,
                datasets: [{
                    label: 'Jumlah Barang Keluar per Bulan',
                    data: <?= json_encode(array_map(function ($item) {
                        return $item['total'];
                    }, $chart_data)) ?>,
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>