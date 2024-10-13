<?php
// Menghubungkan ke database
include("../koneksi.php");

// Menampilkan error jika ada
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inisialisasi variabel
$search_query = "";

// Cek apakah ada query pencarian
if (isset($_GET['query'])) {
    echo "Searching for: " . htmlspecialchars($_GET['query']) . "<br>"; // Menampilkan query yang dicari
    $search_query = mysqli_real_escape_string($koneksi, $_GET['query']);
    
    // Query untuk mencari siswa berdasarkan nama, NIS, atau NISN
    $query = "SELECT * FROM siswa WHERE nama LIKE '%$search_query%' OR NIS LIKE '%$search_query%' OR NISN LIKE '%$search_query%'";
} else {
    echo "<p>No search query provided.</p>";
    exit();
}

// Eksekusi query
$result = mysqli_query($koneksi, $query);

// Cek apakah query berhasil
if (!$result) {
    echo "Error executing query: " . mysqli_error($koneksi); // Menampilkan pesan kesalahan
    exit();
}

// Tampilkan jumlah hasil
echo "Number of results: " . mysqli_num_rows($result) . "<br>"; // Tampilkan jumlah hasil

// Tampilkan hasil dalam tabel
?>
<table class="table table-bordered" width="100%" cellspacing="0">
    <thead>
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
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Mengecek apakah ada hasil
        if (mysqli_num_rows($result) > 0) {
            // Loop untuk menampilkan setiap baris hasil pencarian
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['NIS']}</td>
                    <td>{$row['NISN']}</td>
                    <td>" . ($row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan') . "</td>
                    <td>{$row['tempat_lahir']}</td>
                    <td>{$row['tgl_lahir']}</td>
                    <td>{$row['agama']}</td>
                    <td>{$row['alamat']}</td>
                    <td>
                        <a href='../fitur/hapus.php?id={$row['id_siswa']}' onclick=\"return confirm('Apakah Anda yakin ingin menghapus siswa ini?');\" class='btn btn-danger btn-sm'>Hapus</a>
                        <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editStudentModal{$row['id_siswa']}'>Edit</button>
                    </td>
                </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='10' class='text-center'>Data tidak ditemukan</td></tr>";
        }
        ?>
    </tbody>
</table>
