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
                    <h1 class="h3 mb-2 text-gray-800">Siswa - Siswi</h1>
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">SD Pasarejo 1</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Agama</th>
                                            <th>Alamat</th>
                                        </tr>
                                        <?php
    
    $query  = "SELECT * FROM siswa";
    $result = mysqli_query($koneksi, $query);
    $no = 1;
    
    
    while ($row = mysqli_fetch_array($result)){
        
        $nama = $row['nama'];
        $nisn = $row['NISN'];
        $nis = $row['NIS'];
        $tempatLahir = $row['tempat_lahir'];
        $tglLahir = $row['tgl_lahir'];
        $agama = $row['agama'];
        $alamat = $row['alamat'];
    ?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $nama; ?></td>
        <td><?php echo $nisn; ?></td>
        <td><?php echo $nis; ?></td>
        <td><?php echo $tempatLahir; ?></td>
        <td><?php echo $tglLahir; ?></td>
        <td><?php echo $agama; ?></td>
        <td><?php echo $alamat; ?></td>
        <!-- Tombol Edit untuk membuka modal -->
        echo "<td><button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' onclick='editSiswa(" . json_encode($row) . ")'>Edit</button></td>";
        echo "</tr>";
        <form id="editForm" method="POST" action="edit_siswa.php">
        <td><a href="fitur/hapus.php?id=<?php echo $row['id_siswa']; ?>">hapus</a></td>
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
   
<!-- Modal Edit Data Siswa -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk update siswa -->
                <form id="editForm" method="POST" action="update_siswa.php">
                    <input type="hidden" name="id_siswa" id="edit-id_siswa">
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit-nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-NIS" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="edit-NIS" name="NIS" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-NISN" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="edit-NISN" name="NISN" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control" id="edit-jenis_kelamin" name="jenis_kelamin" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="edit-tempat_lahir" name="tempat_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="edit-tgl_lahir" name="tgl_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-agama" class="form-label">Agama</label>
                        <input type="text" class="form-control" id="edit-agama" name="agama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="edit-alamat" name="alamat" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function fillEditForm(id, nama, nis, nisn, jenis_kelamin, tempat_lahir, tgl_lahir, agama, alamat) {
    document.getElementById('edit-id_siswa').value = id;
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-NIS').value = nis;
    document.getElementById('edit-NISN').value = nisn;
    document.getElementById('edit-jenis_kelamin').value = jenis_kelamin;
    document.getElementById('edit-tempat_lahir').value = tempat_lahir;
    document.getElementById('edit-tgl_lahir').value = tgl_lahir;
    document.getElementById('edit-agama').value = agama;
    document.getElementById('edit-alamat').value = alamat;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
