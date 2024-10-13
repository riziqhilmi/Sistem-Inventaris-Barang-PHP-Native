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
if(isset($_POST['submit'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $telepon = $_POST['kontak'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    // Query untuk memasukkan data ke tabel guru
    $query = "INSERT INTO guru (nama, NIP, kontak, tempat_lahir, tgl_lahir, alamat, status) 
              VALUES ('$nama', '$nip', '$telepon', '$tempat_lahir', '$tgl_lahir', '$alamat', '$status')";
    if(mysqli_query($koneksi, $query)) {
        header("location:data_guru.php");
    } else {
        echo "<script>alert('Gagal menambahkan data guru: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/data_guru.css">
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
        <h1 class="mb-4">Data Guru</h1>
        
        <!-- Button Tambah Data -->
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#tambahDataModal">
            Tambah Data
        </button>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Guru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="data_guru.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>  
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                            <div class="form-group">
                                <label for="kontak">No Telepon</label>
                                <input type="text" class="form-control" id="kontak" name="kontak" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Cuti">Cuti</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Guru</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SD Pasarejo 1</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>No Telepon</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            $query  = "SELECT * FROM guru";
                            $result = mysqli_query($koneksi, $query);
                            $no = 1;

                            while ($row = mysqli_fetch_array($result)) {
                                $nama = $row['nama'];
                                $nip = $row['NIP'];
                                $kontak = $row['kontak'];
                                $tempatLahir = $row['tempat_lahir'];
                                $tglLahir = $row['tgl_lahir'];
                                $alamat = $row['alamat'];
                                $status = $row['status'];
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $nama; ?></td>
                                    <td><?php echo $nip; ?></td>
                                    <td><?php echo $kontak; ?></td>
                                    <td><?php echo $tempatLahir; ?></td>
                                    <td><?php echo $tglLahir; ?></td>
                                    <td><?php echo $alamat; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm">Edit</button>
                                        <a href="fitur/hapus_guru.php?id=<?php echo $row['id_guru']; ?>">
                                            <button type="button" class="btn btn-danger btn-sm">Hapus</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

                <!-- /.container-fluid -->

            </div>



                <!-- Graph -->
                <div class="row">
                    <div class="col-lg-12">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
   
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
