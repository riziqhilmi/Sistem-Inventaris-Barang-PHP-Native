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
        <td><?php echo $jenis_kelamin; ?></td>
        <td><?php echo $tempatLahir; ?></td>
        <td><?php echo $tglLahir; ?></td>
        <td><?php echo $agama; ?></td>
        <td><?php echo $alamat; ?></td>
  <td>
    <button type="button" class="btn btn-primary btn-sm">Edit</button>
    <a href="fitur/hapus.php?id=<?php echo $row['id_siswa']; ?>">
        <button type="button" class="btn btn-danger btn-sm">Hapus</button>
    
    </a>
  </td>
</tr>
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
   


</body>
</html>
