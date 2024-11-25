<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/visualisasi.css">
</head>

<body>

<<<<<<< HEAD


<div class="container-fluid">
=======
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'partials/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="container">
                    <h1 class="mb-4">Data Visualisasi</h1>
                    <div class="container">
>>>>>>> b6c28327eed63d7ba8e6c6114d3574853acf777e
    <div class="row">
        <!-- Card 1 -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card small-card">
                <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                <div class="card-body">
                    <h4 class="card-title">Data visualisasi guru</h4>
                    
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card small-card">
                <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                <div class="card-body">
                    <h4 class="card-title">Data visualisasi siswa</h4>
                    
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card small-card">
                <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                <div class="card-body">
                    <h4 class="card-title">Data visualisasi barang</h4>
                    
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Card 4 -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card small-card">
                <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                <div class="card-body">
                    <h4 class="card-title">Data visualisasi barang masuk</h4>
                   
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <!-- Card 5 -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card small-card">
                <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                <div class="card-body">
                    <h4 class="card-title">Data visualisasi barang keluar</h4>
                  
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <!-- Card 6 -->
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card small-card">
                <img src="img/vector_visual.jpg" class="card-img-top" alt="jpg">
                <div class="card-body">
                    <h4 class="card-title">Peminjaman</h4>
                   
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>

                 
                    <div class="row">
                        <div class="col-lg-12">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>



</body>

</html>