<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Check if the OTP is valid
    $query = "SELECT * FROM user WHERE email = '$email' AND otp = '$otp' AND otp_expiration > NOW()";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        // OTP is valid, redirect to new password page
        header("Location: new_pw.php?email=" . urlencode($email));
        exit();
    } else {
        echo "Invalid OTP or OTP expired.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/email.css">
    <title>Verifikasi OTP</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
</head>
<body>
    <div class="card text-center" style="width: 32rem;">
        <div class="card-body">
            <h5 class="card-title"><strong>Email verifikasi</strong></h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Kode OTP</label>
                    <input type="text" name="otp" class="form-control" placeholder="Masukkan Kode" id="exampleInputEmail1" required>
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
                    <div id="emailHelp" class="form-text">Kami tidak akan pernah membagikan Kode OTP Anda kepada orang lain.</div>
                </div>
                <button type="submit" class="btn btn-primary"><strong>Selanjutnya</strong></button>
            </form>
        </div>
    </div>
</body>
</html>