<?php
include('koneksi.php');
$username = $_POST['usernamee'];
$email = $_POST['email'];
$password = $_POST['passwordd'];
$confirm_password = $_POST['confirm_password'];


if ($password !== $confirm_password) {
    echo json_encode([
        'status'=> 'error'
    ]);
    exit(); 
}
 
$sql = "INSERT INTO `user`(`username`, `password`, `email`, `c_password`) VALUES ('$username', '$password', '$email', '$confirm_password')";
 mysqli_query($koneksi, $sql);

 echo json_encode([
    "status" => "success"
 ]);