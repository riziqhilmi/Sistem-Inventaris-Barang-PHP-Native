<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/email.css">
    <title>Ganti Password</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
    <style>
    /* Gaya tombol default */
.btn-primary {
    background-color: #007bff; /* Warna biru */
    color: white; /* Warna teks */
    padding: 7px 29px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    transition: all 0.3s ease; /* Efek transisi */
}

/* Efek hover */
.btn-primary:hover {
    background-color: #0056b3; /* Warna biru lebih gelap */
    color: #eaeaea; /* Warna teks berubah */
    transform: scale(1.05); /* Membesar sedikit */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan */
}

</style>

</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#0099ff" fill-opacity="1"
            d="M0,192L30,186.7C60,181,120,171,180,192C240,213,300,267,360,288C420,309,480,299,540,288C600,277,660,267,720,256C780,245,840,235,900,234.7C960,235,1020,245,1080,240C1140,235,1200,213,1260,213.3C1320,213,1380,235,1410,245.3L1440,256L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z">
        </path>
    </svg>
    <div class="card shadow" style="width: 53rem;>
        <h5 class=" card-header">
        </h5>
        <div class="card-body">
            <h5 class="card-title"><strong>Perbarui kata sandi</strong></h5>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="Masukkan Password Baru"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"> konfirmasi Password</label>
                <input type="password" class="form-control"  placeholder="Masukkan Konfirmasi Password" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="togglePassword()">
                <label class="form-check-label" for="exampleCheck1">Tampilkan password</label>
            </div>

            <a href="login2.php" class="btn btn-primary"><strong>Kirim</strong></a>
        </div>
    </div>


</body>
<script>
    function togglePassword() {
        var passwordInput = document.querySelectorAll("#exampleInputPassword1");
        if (passwordInput[0].type == "password") {
            passwordInput[0].type = "text";
            // passwordInput[1].type = "text";
        } else {
            passwordInput[0].type = "password";
            // passwordInput[1].type == "password";
        }
    }
</script>

</html>