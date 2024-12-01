<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_siswa = $_POST['id_siswa'];
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $jenis_kelamin = $_POST['j_kelamin']; 
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE siswa SET 
              nama='$nama', 
              NIS='$nis', 
              NISN='$nisn', 
              jenis_kelamin='$jenis_kelamin',  
              tempat_lahir='$tempat_lahir', 
              tgl_lahir='$tgl_lahir', 
              agama='$agama', 
              alamat='$alamat' 
              WHERE id_siswa='$id_siswa'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data siswa berhasil diubah'); window.location='../data_siswa.php';</script>";
    } else {
        echo "<script>alert('Data siswa gagal diubah: " . mysqli_error($koneksi) . "'); window.location='../data_siswa.php';</script>";
    }
}
?>