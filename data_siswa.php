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
include ("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar bg-dark sticky-top">
            <?php include 'partials/sidebar.php'; ?>
        </div>

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
                            <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                Tambah Data Siswa
                            </button>

                            <form class="d-flex mb-3" id="searchForm" method="GET">
                                <input type="text" class="form-control form-control-sm me-2" name="query" placeholder="Cari Siswa..." style="width: 200px;" required>
                                    <button class="btn btn-primary btn-sm" type="submit">Search</button>
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

                                   if ($query) {
                                       $query = mysqli_real_escape_string($koneksi, $query); 
                                       $sql = "SELECT * FROM siswa WHERE nama LIKE '%$query%' OR NIS LIKE '%$query%'OR NISN LIKE '%$query%' OR jenis_kelamin LIKE '%$query%' OR tempat_lahir LIKE '%$query%' OR tgl_lahir LIKE '%$query%' OR agama LIKE '%$query%' OR alamat LIKE '%$query%' "; 
                                   } else {
                                       $sql = "SELECT * FROM siswa";
                                   }
                                   
                                   $result = mysqli_query($koneksi, $sql);
                                   $no = 1;

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
                                        <td><?php echo ($jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                                        <td><?php echo $tempatLahir; ?></td>
                                        <td><?php echo $tglLahir; ?></td>
                                        <td><?php echo $agama; ?></td>
                                        <td><?php echo $alamat; ?></td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal<?php echo $row['id_siswa']; ?>">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <a href="fitur/hapus.php?id=<?php echo $row['id_siswa']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');" class="btn btn-danger btn-sm">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Data Siswa -->
                                    <div class="modal fade" id="editStudentModal<?php echo $row['id Siswa']; ?>" tabindex="-1" aria-labelledby="editStudentLabel<?php echo $row['id Siswa']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editStudentLabel<?php echo $row['id Siswa']; ?>">Edit Data Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="fitur/edit Siswa.php" method="POST">
    <input type="hidden" name="id Siswa" value="<?php echo $row['id Siswa']; ?>">
    
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="nip" class="form-label">NIP</label>
        <input type="text" class="form-control" name="nip" value="<?php echo $row['NIP']; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="kontak" class="form-label">Kontak</label>
        <input type="text" class="form-control" name="kontak" value="<?php echo $row['kontak']; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <input type="text" class="form-control" name="tempat_lahir" value="<?php echo $row['tempat_lahir']; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" class="form-control" name="tgl_lahir" value="<?php echo $row['tgl_lahir']; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat" required><?php echo $row['alamat']; ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <input type="text" class="form-control" name="status" value="<?php echo $row['status']; ?>" required>
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

                <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault(); // Menghindari reload halaman
                var query = $('input[name="query"]').val(); // Mengambil nilai dari input

                $.ajax({
                    url: 'fitur/cari Siswa.php', // URL untuk memproses pencarian
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        $('#searchResults').html(response); // Menampilkan hasil di div searchResults
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error); // Menampilkan kesalahan jika ada
                    }
                });
            });
        });
    </script>

                <!-- Modal for Adding Student -->
                <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addStudentLabel">Tambah Data Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="fitur/tambah Siswa.php" method="POST">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" required>
    </div>
    
    <div class="mb-3">
        <label for="nip" class="form-label">NIP</label>
        <input type="text" class="form-control" name="nip" required>
    </div>
    
    <div class="mb-3">
        <label for="kontak" class="form-label">Kontak</label>
        <input type="text" class="form-control" name="kontak" required>
    </div>
    
    <div class="mb-3">
        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <input type="text" class="form-control" name="tempat_lahir" required>
    </div>
    
    <div class="mb-3">
        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" class="form-control" name="tgl_lahir" required>
    </div>
    
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat" required></textarea>
    </div>
    
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <input type="text" class="form-control" name="status" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

                            </div>
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
