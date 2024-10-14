<?php
include('../koneksi.php');

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    $query = "SELECT * FROM guru WHERE nama LIKE '%$searchQuery%' OR NIP LIKE '%$searchQuery%'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) { 
        echo '<table class="table table-bordered">';
        echo '<thead><tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Kontak</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr></thead>';
        echo '<tbody>';

        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $row['nama'] . '</td>';
            echo '<td>' . $row['NIP'] . '</td>';
            echo '<td>' . $row['kontak'] . '</td>';
            echo '<td>' . $row['tempat_lahir'] . '</td>';
            echo '<td>' . $row['tgl_lahir'] . '</td>';
            echo '<td>' . $row['alamat'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>
                    <a href="edit_guru.php?id=' . $row['id_guru'] . '" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_guru.php?id=' . $row['id_guru'] . '" class="btn btn-danger btn-sm">Delete</a>
                  </td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        // Jika data tidak ditemukan
        echo '<p>Data tidak ditemukan</p>';
    }
}
?>
