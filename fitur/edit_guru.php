<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_guru = $_POST['id_guru'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $kontak = $_POST['kontak'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    $query = "UPDATE guru SET 
              nama='$nama', 
              NIP='$nip', 
              kontak='$kontak', 
              tempat_lahir='$tempat_lahir', 
              tgl_lahir='$tgl_lahir', 
              alamat='$alamat', 
              status='$status' 
              WHERE id_guru='$id_guru'";

    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "<script>alert('Data guru berhasil diubah'); window.location='../data_guru.php';</script>";
    } else {
        echo "<script>alert('Data guru gagal diubah: " . mysqli_error($koneksi) . "'); window.location='../data_guru.php';</script>";
    }
}
?>
