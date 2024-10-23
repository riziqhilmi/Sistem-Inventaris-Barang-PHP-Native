<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_ruangan = $_POST['id_ruangan'];
    $nama = $_POST['nama'];
    $ket = $_POST['ket'];
    

    $query = "UPDATE ruangan SET nama_ruangan ='$nama', keterangan='$ket' WHERE id_ruangan ='$id_ruangan'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data ruangan berhasil diubah'); window.location='../data_kelas.php';</script>";
    } else {
        echo "<script>alert('Data ruangan gagal diubah: " . mysqli_error($koneksi) . "'); window.location='../data_kelas.php';</script>";
    }
}
?>
