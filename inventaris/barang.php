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

  <style>
    .disable-scroll {
      overflow: hidden !important;
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init(); // Inisialisasi AOS

    document.addEventListener('aos:in', (event) => {
      // Ketika animasi dimulai, nonaktifkan scroll
      document.body.classList.add('disable-scroll');
    });

    document.addEventListener('aos:out', (event) => {
      // Ketika animasi selesai, aktifkan kembali scroll
      document.body.classList.remove('disable-scroll');
    });

    AOS.init({
      startEvent: 'DOMContentLoaded', // Pastikan animasi dimulai setelah halaman dimuat
      once: true, // Hanya jalankan animasi sekali
    });

    const tableContainer = document.querySelector('.table-responsive');
    document.addEventListener('aos:in', () => {
      tableContainer.classList.add('disable-scroll');
    });

    document.addEventListener('aos:out', () => {
      tableContainer.classList.remove('disable-scroll');
    });


  </script>

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
                  <input type="text" class="form-control form-control-sm me-2" name="query" placeholder="Cari barang..."
                    style="width: 200px;" required>
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
                  $query = isset($_GET['query']) ? $_GET['query'] : '';
                  if ($query) {
                    $query = mysqli_real_escape_string($koneksi, $query);
                    $sql = "SELECT * FROM barang WHERE nama LIKE '%$query%' OR merek LIKE '%$query%'OR kategori LIKE '%$query%' OR ruangan LIKE '%$query%' OR kondisi LIKE '%$query%' OR jumlah_awal LIKE '%$query%' OR jumlah_akhir LIKE '%$query%' OR tgl LIKE '%$query%' OR keterangan LIKE '%$query%'";
                  } else {
                    $sql = "SELECT * FROM barang";
                  }
                  $result = mysqli_query($koneksi, query: $sql);
                  $no = 1;

                  // Tentukan jumlah item per halaman
                  $items_per_page = 10;
                  // Ambil nomor halaman dari URL (default adalah 1 jika tidak ada)
                  $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                  $offset = ($page - 1) * $items_per_page;
                  // Query untuk menampilkan data dengan LIMIT dan OFFSET untuk paginasi
               
                  $result = mysqli_query($koneksi, $sql);

                  while ($row = mysqli_fetch_array($result)) {
                    $nama = $row['nama'];
                    $merk = $row['merek'];
                    $kategori = $row['kategori'];
                    $ruangan = $row['ruangan'];
                    $kondisi = $row['kondisi'];
                    $jml_a = $row['jumlah_awal'];
                    $jml_ak = $row['jumlah_akhir'];
                    $tgl = $row['tgl'];
                    $ket = $row['keterangan'];
                    // Query untuk menghitung total item
                    $count_query = "SELECT COUNT(*) as total FROM barang";
                    $count_result = mysqli_query($koneksi, $count_query);
                    $total_items = mysqli_fetch_assoc($count_result)['total'];
                    $total_pages = ceil($total_items / $items_per_page);
                    ?>
                    <tr data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo $no * 100; ?>">
                      <td><?php echo $no; ?></td>
                      <td><?php echo $nama; ?></td>
                      <td><?php echo $merk; ?></td>
                      <td><?php echo $kategori; ?></td>
                      <td><?php echo $ruangan; ?></td>
                      <td><?php echo $kondisi; ?></td>
                      <td><?php echo $jml_a; ?></td>
                      <td><?php echo $jml_ak; ?></td>
                      <td><?php echo $tgl; ?></td>
                      <td><?php echo $ket; ?></td>
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
                        <a href="../fitur/generate_barcode.php?id=<?php echo $row['id_barang']; ?>" target="_blank"
                          class="btn btn-info btn-sm mt-1">
                          Cetak Barcode
                        </a>

                      </td>
                    </tr>

                    <!-- Modal Edit Data barang -->
                    <div class="modal fade" id="editTeacherModal<?php echo $row['id_barang']; ?>" tabindex="-1"
                      aria-labelledby="editTeacherLabel<?php echo $row['id_barang']; ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editTeacherLabel<?php echo $row['id_barang']; ?>">Edit Data barang
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="../fitur/edit_barang.php" method="POST">
                              <input type="hidden" name="id_barang" value="<?php echo $row['id_barang']; ?>">
                              <div class="mb-3">
                                <label for="nama" class="form-label">Nama barang</label>
                                <input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>"
                                  required>
                              </div>
                              <div class="mb-3">
                                <label for="merek" class="form-label">Merek</label>
                                <input type="text" class="form-control" name="merek" value="<?php echo $row['merek']; ?>"
                                  required>
                              </div>
                              <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <input type="text" class="form-control" name="kategori"
                                  value="<?php echo $row['kategori']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label for="ruangan" class="form-label">Ruangan</label>
                                <select class="form-select" name="ruangan" required>
                                  <?php
                                  $query_kelas = "SELECT nama_ruangan FROM ruangan";
                                  $result_kelas_edit = $koneksi->query($query_kelas);
                                  echo '<option value="">Pilih Ruangan</option>';

                                  if ($result_kelas_edit->num_rows > 0) {
                                    while ($row_kelas = $result_kelas_edit->fetch_assoc()) {
                                      $selected = (isset($row['ruangan']) && $row['ruangan'] == $row_kelas['nama_ruangan']) ? 'selected' : '';
                                      echo '<option value="' . $row_kelas['nama_ruangan'] . '" ' . $selected . '>' . $row_kelas['nama_ruangan'] . '</option>';
                                    }
                                  } else {
                                    echo '<option value="">Tidak ada data ruang tersedia</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="kondisi" class="form-label">Kondisi</label>
                                <select class="form-select" name="kondisi" required>
                                  <option value="Baik" <?php echo ($kondisi == 'B') ? 'selected' : ''; ?>>Baik</option>
                                  <option value="Rusak Ringan" <?php echo ($kondisi == 'R') ? 'selected' : ''; ?>>Rusak
                                    Ringan</option>
                                  <option value="Rusak Berat" <?php echo ($kondisi == 'RB') ? 'selected' : ''; ?>>Rusak
                                    Berat</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="jumlah_awal" class="form-label">Jumlah Awal</label>
                                <input type="text" class="form-control" name="jumlah_awal"
                                  value="<?php echo $row['jumlah_awal']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label for="jumlah_akhir" class="form-label">Jumlah Akhir</label>
                                <input type="text" class="form-control" name="jumlah_akhir"
                                  value="<?php echo $row['jumlah_akhir']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label for="tgl" class="form-label">TGL Pengadaan</label>
                                <input type="date" class="form-control" name="tgl" value="<?php echo $row['tgl']; ?>"
                                  required>
                              </div>
                              <div class="mb-3">
                                <label for="ket" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" name="ket"
                                  value="<?php echo $row['keterangan']; ?>" required>
                              </div>
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                    $no++;
                  }
                  ?>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
        <!-- Modal for Adding Item -->
        <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg"> <!-- Make modal wider -->
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addTeacherLabel">Tambah Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="../fitur/tambah_barang.php" method="POST">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="nama_barang" class="form-label">Nama Barang</label>
                      <input type="text" class="form-control" name="nama_barang" required>
                    </div>
                    <div class="col-md-6">
                      <label for="merk" class="form-label">Merek</label>
                      <input type="text" class="form-control" name="merk" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="kategori" class="form-label">Kategori</label>
                      <input type="text" class="form-control" name="kategori" required>
                    </div>
                    <div class="col-md-6">
                      <label for="ruangan" class="form-label">Ruangan</label>
                      <select class="form-select" name="ruangan" required>
                        <?php
                        $query_kelas = "SELECT nama_ruangan FROM ruangan";
                        $result_kelas = $koneksi->query($query_kelas);
                        if ($result_kelas->num_rows > 0) {
                          while ($row_kelas = $result_kelas->fetch_assoc()) {
                            echo '<option value="' . $row_kelas['nama_ruangan'] . '">' . $row_kelas['nama_ruangan'] . '</option>';
                          }
                        } else {
                          echo '<option value="">Tidak ada data ruang tersedia</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select class="form-select" name="kondisi" required>
                      <option value="Baik">Baik</option>
                      <option value="Rusak Ringan">Rusak Ringan</option>
                      <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="jml_a" class="form-label">Jumlah Awal</label>
                      <input type="text" class="form-control" name="jml_a" required>
                    </div>
                    <div class="col-md-6">
                      <label for="jml_ak" class="form-label">Jumlah Akhir</label>
                      <input type="text" class="form-control" name="jml_ak" required>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="tgl" class="form-label">TGL Pengadaan</label>
                    <input type="date" class="form-control" name="tgl" required>
                  </div>

                  <div class="mb-3">
                    <label for="ket" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="ket" required>
                  </div>

                  <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
              </div>
            </div>
          </div>
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
            // Halaman saat ini (diberi gaya berbeda)
            echo '<span class="btn btn-primary mx-1">' . $i . '</span>';
          } else {
            // Link ke halaman lain
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
</body>

</html>