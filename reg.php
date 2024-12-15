<?php
include('koneksi.php');
$nip = $_POST['nip'];
$username = $_POST['usernamee'];
$email = $_POST['email'];
$password = $_POST['passwordd'];
$confirm_password = $_POST['confirm_password'];

// Validasi NIP
$check_nip = "SELECT * FROM guru WHERE NIP = '$nip'";
$result = mysqli_query($koneksi, $check_nip);

if(mysqli_num_rows($result) == 0) {
    echo json_encode([
        'status'=> 'error_nip',
        'message'=> 'NIP tidak terdaftar di database guru!'
    ]);
    exit();
}

if ($password !== $confirm_password) {
    echo json_encode([
        'status'=> 'error_password',
        'message'=> 'Password dan Confirm Password tidak cocok!'
    ]);
    exit(); 
}

// Check if username already exists
$check_username = "SELECT * FROM user WHERE username = '$username'";
$result_username = mysqli_query($koneksi, $check_username);
if(mysqli_num_rows($result_username) > 0) {
    echo json_encode([
        'status'=> 'error_username',
        'message'=> 'Username sudah digunakan!'
    ]);
    exit();
}

// Check if email already exists
$check_email = "SELECT * FROM user WHERE email = '$email'";
$result_email = mysqli_query($koneksi, $check_email);
if(mysqli_num_rows($result_email) > 0) {
    echo json_encode([
        'status'=> 'error_email',
        'message'=> 'Email sudah digunakan!'
    ]);
    exit();
}
 
$sql = "INSERT INTO `user`(`username`, `password`, `email`, `c_password`) VALUES ('$username', '$password', '$email', '$confirm_password')";
if(mysqli_query($koneksi, $sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Pendaftaran berhasil!"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Terjadi kesalahan saat mendaftar!"
    ]);
}
?>