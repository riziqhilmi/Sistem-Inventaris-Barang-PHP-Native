<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_barang= $_POST['id_barang'];
    $nama = $_POST['nama'];
    $merk = $_POST['merek'];
    $kategori = $_POST['kategori'];
    $ruangan = $_POST['ruangan'];
    $kondisi = $_POST['kondisi'];
    $jml_a = $_POST['jumlah_awal'];
    $jml_ak = $_POST['jumlah_akhir'];
    $tgl = $_POST['tgl'];
    $ket = $_POST['ket'];

    $query = "UPDATE barang SET nama='$nama', merek='$merk', kategori='$kategori', ruangan='$ruangan', kondisi='$kondisi', jumlah_awal='$jml_a', jumlah_akhir='$jml_ak',tgl='$tgl', keterangan='$ket' WHERE id_barang='$id_barang'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data barang berhasil diubah'); window.location='../inventaris/barang.php';</script>";
    } else {
        echo "<script>alert('Data barang gagal diubah: " . mysqli_error($koneksi) . "'); window.location='../inventaris/barang.php';</script>";
    }
}
?>