<?php
session_start();

include('koneksi.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login2.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="col-md-10 p-4">

            <!-- Dashboard Header -->
            <div class="row mb-4">
                <div class="col-md-15 position-relative">
                  
                    <!-- Wave Animation Behind Text -->
                    <div class="wave-container">
                        <div class="wave"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                <iframe title="project2" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=737c6aa7-8ae6-4382-b45c-7c910c143f71&autoAuth=true&ctid=5263cc81-5912-42c4-abc1-d0f1b668b530" frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>  
</html>