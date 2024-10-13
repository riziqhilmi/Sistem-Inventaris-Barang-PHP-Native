<?php
// Menghubungkan ke database
include('../koneksi.php');

// Mengecek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form yang dikirim melalui method POST
    $id_siswa = $_POST['id_siswa'];
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $jenis_kelamin = $_POST['jenis_kelamin']; // Menambahkan jenis kelamin
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];

    // Query untuk mengupdate data siswa berdasarkan id_siswa
    $query = "UPDATE siswa SET 
              nama='$nama', 
              NIS='$nis', 
              NISN='$nisn', 
              jenis_kelamin='$jenis_kelamin',  -- Perbaiki kesalahan di sini
              tempat_lahir='$tempat_lahir', 
              tgl_lahir='$tgl_lahir', 
              agama='$agama', 
              alamat='$alamat' 
              WHERE id_siswa='$id_siswa'";

    // Menjalankan query
    $result = mysqli_query($koneksi, $query);

    // Pengecekan hasil query
    if ($result) {
        // Jika berhasil, tampilkan alert sukses dan redirect ke halaman data siswa
        echo "<script>alert('Data siswa berhasil diubah'); window.location='../data_siswa.php';</script>";
    } else {
        // Jika gagal, tampilkan alert gagal dan tetap di halaman data siswa
        echo "<script>alert('Data siswa gagal diubah: " . mysqli_error($koneksi) . "'); window.location='../data_siswa.php';</script>";
    }
}
?>