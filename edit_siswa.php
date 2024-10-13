<?php
include 'koneksi.php'; // Pastikan file koneksi sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_siswa = $_POST['id_siswa'];
    $nama = $_POST['nama'];
    $NIS = $_POST['NIS'];
    $NISN = $_POST['NISN'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];

    // Update query dengan bind_param untuk prepared statement
    $query = "UPDATE siswa SET nama=?, NIS=?, NISN=?, jenis_kelamin=?, tempat_lahir=?, tgl_lahir=?, agama=?, alamat=? WHERE id_siswa=?";
    $stmt = $koneksi->prepare($query); // Menggunakan $koneksi, bukan $database
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssssssi", $nama, $NIS, $NISN, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $agama, $alamat, $id_siswa);
        
        // Execute statement
        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman data siswa
            header('Location: data_siswa.php');
            exit();
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Error: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $koneksi->error;
    }
} else {
    echo "Invalid request";
}
?>
