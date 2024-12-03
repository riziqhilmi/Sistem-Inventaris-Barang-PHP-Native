<?php
session_start();

// Pastikan pengguna login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Periksa apakah ada file yang diunggah
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/profile_photos/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    
    // Validasi tipe file
    $file_type = mime_content_type($_FILES['profile_photo']['tmp_name']);
    if (!in_array($file_type, $allowed_types)) {
        die('Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan.');
    }

    // Pastikan direktori upload ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Buat nama file unik
    $file_name = uniqid('profile_') . '.' . pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
    $target_file = $upload_dir . $file_name;

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
        // Simpan URL foto di database atau session
        $_SESSION['user_photo'] = $target_file;

        // Perbarui data di database (sesuaikan query dengan kebutuhan Anda)
        // Contoh:
        // $db->query("UPDATE users SET photo = '$target_file' WHERE id = {$_SESSION['user_id']}");

        // Kembali ke halaman profil tanpa notifikasi
        header('Location: profile.php');
        exit();
    } else {
        die('Terjadi kesalahan saat mengunggah file.');
    }
} else {
    die('Tidak ada file yang diunggah.');
}
?>
