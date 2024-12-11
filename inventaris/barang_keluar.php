<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login2.php');
    exit();
}

require_once '../koneksi.php';

$query_ruangan = "SELECT id_ruangan, nama_ruangan FROM ruangan ORDER BY nama_ruangan";
$result_ruangan = $koneksi->query($query_ruangan);
$ruangan_list = $result_ruangan->fetch_all(MYSQLI_ASSOC);


// Menangani submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $created_by = $_SESSION['user_id']; // Ambil ID pengguna dari sesi

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
            $query = "INSERT INTO barang_keluar (id_barang, jumlah, tanggal, keterangan, created_by) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("iissi", $id_barang, $jumlah, $tanggal, $keterangan, $created_by); // Tambahkan created_by
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

// Ganti query barang_list dengan kondisi filter ruangan
$barang_list = [];

// Jika ruangan dipilih, ambil barang sesuai ruangan
if (isset($_GET['id_ruangan']) && !empty($_GET['id_ruangan'])) {
    $id_ruangan = $_GET['id_ruangan'];
    $query = "SELECT id_barang, nama, merek, jumlah_akhir 
              FROM barang 
              WHERE ruangan = (SELECT nama_ruangan FROM ruangan WHERE id_ruangan = ?) 
              ORDER BY nama";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_ruangan);
    $stmt->execute();
    $result = $stmt->get_result();
    $barang_list = $result->fetch_all(MYSQLI_ASSOC);
}

$query = "SELECT bk.*, b.nama, b.merek, u.username 
          FROM barang_keluar bk 
          LEFT JOIN barang b ON bk.id_barang = b.id_barang 
          LEFT JOIN user u ON bk.created_by = u.id_user 
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
    <link rel="icon" type="image/png" href="../img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/barang_keluar.css">
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

                 <!-- Notification Alerts -->
                 <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?=$_SESSION['success'];?></strong>
                            <?php 
                            unset($_SESSION['success']);
                            ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?=$_SESSION['error'];?></strong>
                        <?php 
                        unset($_SESSION['error']);
                        ?>
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    <input type="number" class="form-control" name="jumlah" id="jumlah" required min="1">
                                    <small class="text-muted" id="stok-info"></small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3" required></textarea>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary float-right"  style="float: right;"> <img src="../img/save.png" alt="icon" style="width: 20px; height: 20px; vertical-align:middle; margin-right:5px;">Simpan</button>
    
                            <a href="javascript:void(0);" onclick="previewPDF()" class="btn btn-success float-right" style="float: right;  margin-right: 10px;">
                            <img src="../img/printt.png" alt="Icon" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                            Cetak Riwayat Harian </a>
                            
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
                        <th>Dibuat Oleh</th> <!-- Kolom untuk nama pembuat -->
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
                            <td><?= htmlspecialchars($trans['username'] ?? 'Tidak Diketahui') ?></td> <!-- Menampilkan username atau 'Tidak Diketahui' -->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

// Tambahkan di dalam <script> atau file terpisah
function filterBarang(ruanganId) {
    if (ruanganId) {
        window.location.href = 'barang_keluar.php?id_ruangan=' + ruanganId;
    } else {
        $('#id_barang').html('<option value="">Pilih Barang (Pilih Ruangan Terlebih Dahulu)</option>');
    }
}

// Inisialisasi date picker
flatpickr("input[type=date]", {
    dateFormat: "Y-m-d",
    maxDate: "today"
});

// Validasi stok
document.getElementById('id_barang').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stok = selectedOption.dataset.stok;
    const jumlahInput = document.getElementById('jumlah');
    const stokInfo = document.getElementById('stok-info');

    jumlahInput.max = stok;
    stokInfo.textContent = `Stok tersedia: ${stok}`;
});

document.getElementById('jumlah').addEventListener('input', function() {
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
        labels: <?= json_encode(array_map(function($item) {
            return date('M Y', strtotime($item['bulan'] . '-01'));
        }, $chart_data)) ?>,
        datasets: [{
            label: 'Jumlah Barang Keluar per Bulan',
            data: <?= json_encode(array_map(function($item) {
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

<script>
function previewPDF() {
    // Ganti URL ini dengan URL yang sesuai untuk file PHP Anda
    var url = '../fitur/cetak_riwayat_barang_keluar.php';
    window.open(url, '_blank');
}
</script>

</body>
</html>