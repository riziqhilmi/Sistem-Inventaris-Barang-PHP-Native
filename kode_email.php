<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/input.css">
    <title>Ganti Password</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
<style>
    /* Gaya tombol default */
.btn-primary {
    background-color: #007bff; /* Warna biru */
    color: white; /* Warna teks */
    padding: 10px 20px;
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
            d="M0,192L30,213.3C60,235,120,277,180,272C240,267,300,213,360,192C420,171,480,181,540,192C600,203,660,213,720,218.7C780,224,840,224,900,213.3C960,203,1020,181,1080,192C1140,203,1200,245,1260,266.7C1320,288,1380,288,1410,288L1440,288L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z">
        </path>
    </svg>

    <div class="card text-center" style="width: 32rem;>
        <h5 class=" card-header">
        </h5>
        <div class="card-body">
            <h5 class="card-title"><strong>Email verifikasi</strong></h5>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Kode OTP</label>
                <input type="email" class="form-control" placeholder="Masukkan Kode" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Kami tidak akan pernah membagikan Kode OTP  Anda kepada orang lain.
                </div>
            </div>

            <a href="new_pw.php" class="btn btn-primary"><strong>Selanjutnya</strong></a>
        </div>
    </div>





</body>

</html>