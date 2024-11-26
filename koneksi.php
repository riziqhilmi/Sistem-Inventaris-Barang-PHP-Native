<?php 
<<<<<<< HEAD
$koneksi = mysqli_connect("localhost","root","","db_pasarejo");
=======
$koneksi = mysqli_connect('localhost', 'root', '', 'db_pasarejo');
>>>>>>> 707e1269c554d838faecc089c6767e4f0f93a9da

if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
 
?>