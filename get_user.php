<?php
session_start();
header('Content-Type: application/json'); // Set header untuk respons JSON
include('koneksi.php');

$response = array(); // Array untuk menyimpan respon API

if (isset($_POST['username']) && isset($_POST['password'])) {
    $usr = $_POST['username'];
    $pass = $_POST['password'];

    if (!empty(trim($usr)) && !empty(trim($pass))) {
        // Query untuk mendapatkan user berdasarkan username atau email
        $query = "SELECT * FROM user WHERE username = '$usr' OR email = '$usr'";
        $result = mysqli_query($koneksi, $query);
        $num = mysqli_num_rows($result);

        if ($num != 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id_user'];
                $userVal = $row['username'];
                $passVal = $row['password'];
                $userName = $row['email'];
            }

            // Cek apakah username/email dan password cocok
            if (($userVal == $usr || $userName == $usr) && $passVal == $pass) {
                // Jika berhasil, kembalikan data user dalam format JSON
                $response['status'] = 'success';
                $response['message'] = 'Login berhasil';
                $response['data'] = array(
                    'id_user' => $id,
                    'username' => $userVal,
                    'email' => $userName
                );
            } else {
                // Jika password salah
                $response['status'] = 'error';
                $response['message'] = 'User atau password salah';
            }
        } else {
            // Jika user tidak ditemukan
            $response['status'] = 'error';
            $response['message'] = 'User tidak ditemukan';
        }
    } else {
        // Jika username atau password kosong
        $response['status'] = 'error';
        $response['message'] = 'Username dan password tidak boleh kosong';
    }
} else {
    // Jika request tidak valid
    $response['status'] = 'error';
    $response['message'] = 'Invalid request';
}

// Kirimkan respon dalam format JSON
echo json_encode($response);
?>
