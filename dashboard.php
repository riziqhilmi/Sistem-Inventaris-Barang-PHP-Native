<?php
session_start(); // Start session

// Menyertakan koneksi database
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login2.php');
    exit();
}

// Sample data for the dashboard
$user_name = $_SESSION['username']; // Username from the session
// Query to get the count of teachers
$result_guru = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM guru");
$data_guru = mysqli_fetch_assoc($result_guru)['total'];

// Query to get the count of students
$result_siswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa");
$data_siswa = mysqli_fetch_assoc($result_siswa)['total'];

// Query to get the count of rooms
$result_ruangan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM ruangan");
$data_ruangan = mysqli_fetch_assoc($result_ruangan)['total'];

// Query to get the count of items (barang)
$result_barang = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang");
$data_barang = mysqli_fetch_assoc($result_barang)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function () {
            showGraph();
            
            // Call the scroll animation function
            $(window).on('scroll', function() {
                animateOnScroll();
            });

            // Initial check for elements in viewport on page load
            animateOnScroll();
        });

        function showGraph() {
            $.post("bar_encode.php", function (data) {
                console.log(data);
                var id = [];
                var jual = [];

                for (var i in data) {
                    id.push(data[i].nama);
                    jual.push(data[i].jumlah_akhir);
                }

                var chartdata = {
                    labels: id,
                    datasets: [
                        {
                            label: 'Nama Barang',
                            backgroundColor: '#49e2ff',
                            hoverBackgroundColor: '#CCCCCC',
                            hoverBorderColor: '#666666',
                            data: jual
                        }
                    ]
                };

                var graphTarget = $("#graphCanvas");

                // Create the bar chart with animation options
                var barGraph = new Chart(graphTarget, {
                    type: 'bar',
                    data: chartdata,
                    options: {
                        responsive: true,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutBounce',
                        }
                    }
                });
            });
        }

        function updateTime() {
            var currentDate = new Date();
            var day = currentDate.toLocaleString('id-ID', { weekday: 'long' }); // Get day name
            var date = currentDate.getDate(); // Get day number
            var month = currentDate.toLocaleString('id-ID', { month: 'long' }); // Get month name
            var year = currentDate.getFullYear(); // Get year
            var hours = currentDate.getHours(); // Get hours
            var minutes = currentDate.getMinutes(); // Get minutes
            var seconds = currentDate.getSeconds(); // Get seconds

            // Ensure two-digit format for minutes and seconds
            minutes = (minutes < 10) ? '0' + minutes : minutes;
            seconds = (seconds < 10) ? '0' + seconds : seconds;

            // Display the full date and time
            document.getElementById('current-day').textContent = day + ', ' + date + ' ' + month + ' ' + year;
            document.getElementById('current-time').textContent = hours + ':' + minutes + ':' + seconds;
        }

        // Update the time every second
        setInterval(updateTime, 1000);

        // Check if element is in viewport
        function isInViewport(element) {
            var rect = element.getBoundingClientRect();
            return rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
        }

        // Function to animate elements when they are in the viewport
        function animateOnScroll() {
            $('.card').each(function () {
                if (isInViewport(this)) {
                    $(this).addClass('fade-in');
                }
            });
        }

        // Function to check if element is in the viewport
        function isInViewport(element) {
            var rect = element.getBoundingClientRect();
            return rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
        }

        // Function to animate elements when they are in the viewport
        function animateOnScroll() {
            $('.card').each(function () {
                if (isInViewport(this)) {
                    $(this).addClass('fade-in');
                }
            });
        }
    </script>

    <style>
        h1.text-start {
            color: white; /* Set the text color to white */
        }

        /* Animation for fade-in effect */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px); /* Start from below */
            }
            100% {
                opacity: 1;
                transform: translateY(0); /* End at original position */
            }
        }

        /* Apply the animation to the table/card */
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Styling for the cards */
        .card-body {
            display: flex;
            padding: 8px;
            display: flex; /* Use flexbox to arrange text and icon */
    justify-content: space-between; /* Space between text and icon */
    align-items: center; /* Vertically align items */
        }

        /* Text Left */
.text-left {
    text-align: left; /* Align text to the left */
}

        .card-custom {
    color: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Shadow */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 15px; /* Mengurangi padding */
    position: relative;
    height: 120px; /* Reduce height */
    padding: 10px; /* Reduce padding for a more compact layout */
}

/* Styling untuk card jumlah guru */
.card-guru {
    background: linear-gradient(135deg, #4CAF50, #8BC34A); /* Gradient hijau */
    color: white; /* Text color */
    position: relative;
}

/* Styling untuk card jumlah siswa */
.card-siswa {
    background: linear-gradient(135deg, #2196F3, #03A9F4); /* Gradient biru */
    color: white;
    position: relative;
}

/* Styling untuk card jumlah ruangan */
.card-ruangan {
    background: linear-gradient(135deg, #FF9800, #FFC107); /* Gradient oranye */
    color: white;
    position: relative;
}

/* Styling untuk card jumlah barang */
.card-barang {
    background: linear-gradient(135deg, #F44336, #E91E63); /* Gradient merah */
    color: white;
    position: relative;
}

/* Icon Styling: Make icons white */
.card-icon i {
    color: white; /* Set icon color to white */
}

/* Optional: Add subtle background images */
.card-guru::before, 
.card-siswa::before, 
.card-ruangan::before, 
.card-barang::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    opacity: 0.1; /* Make the background subtle */
    z-index: 0; /* Ensure it's behind the content */
}

/* Hover Effects */
.card-guru:hover {
    background: linear-gradient(135deg, #2575fc, #6a11cb); /* Biru ke ungu */
}

.card-siswa:hover {
    background: linear-gradient(135deg, #3bb2b8, #42e695); /* Teal ke hijau */
}

.card-ruangan:hover {
    background: linear-gradient(135deg, #d76d77, #ffaf7b); /* Merah muda ke orange */
}

.card-barang:hover {
    background: linear-gradient(135deg, #ee0979, #ff6a00); /* Merah ke oranye */
}

/* Card Icon Styling */
.card-icon {
    color: white; /* Warna icon putih */
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 24px;
    background-color: rgba(255, 255, 255, 0.2);
}

/* Icon adjustment */
.card-icon i {
    font-size: 24px; /* Smaller icon size */
}

.card-custom:hover {
    transform: translateY(-5px); /* Efek Hover */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3);
    color: #f0f0f0; /* Teks menjadi lebih terang */
}

.icon-container {
    width: 40px; /* Smaller icon container */
    height: 40px;
    font-size: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
}

.title {
    font-size: 14px; /* Ukuran judul lebih kecil */
    font-weight: bold;
    margin-bottom: 5px;
}

.display-value {
    font-size: 1.8rem; /* Ukuran angka lebih kecil */
    font-weight: bold;
    margin: 0;
}

.description {
    font-size: 12px; /* Ukuran deskripsi lebih kecil */
    color: rgba(255, 255, 255, 0.8);
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .card-custom {
        height: 120px; /* Tinggi kartu lebih kecil pada layar kecil */
    }

    .icon-container {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }

    .display-value {
        font-size: 1.5rem;
    }

    .title {
        font-size: 12px;
    }
}

/* Update untuk memperbesar teks pada 4 card */
.card-custom .display-4 {
    font-size: 3rem; /* Ukuran angka lebih besar */
    font-weight: bold;
}

.card-custom .card-text {
    font-size: 1.2rem; /* Ukuran teks lebih besar */
}


/* Styling untuk current-day (hari, tanggal, bulan, tahun) */
#current-day {
    font-size: 1.2rem; /* Ukuran teks lebih kecil */
    font-weight: 300; /* Teks tipis */
    margin-bottom: 5px; /* Memberikan sedikit jarak di bawahnya */
    color: rgba(0, 0, 0, 0.7); /* Memberikan warna teks lebih lembut (hitam tipis) */
}

/* Styling untuk current-time (waktu) */
#current-time {
    font-size: 2.5rem; /* Ukuran teks lebih besar untuk waktu */
    font-weight: bold; /* Teks lebih tebal untuk waktu */
    color: #333; /* Warna waktu lebih gelap untuk menonjol */
}

/* Responsif untuk perangkat kecil */
@media (max-width: 768px) {
    #current-day {
        font-size: 1rem; /* Ukuran teks lebih kecil untuk layar kecil */
    }

    #current-time {
        font-size: 2rem; /* Ukuran waktu sedikit lebih kecil pada layar kecil */
    }
}

/* Styling untuk card pada layout date and time agar tetap responsif */
@media (max-width: 768px) {
    .card-custom .display-4 {
        font-size: 2.5rem; /* Ukuran angka lebih kecil pada layar kecil */
    }

    .card-custom .card-text {
        font-size: 1rem; /* Ukuran teks lebih kecil pada layar kecil */
    }

    #current-day {
        font-size: 1.5rem; /* Ukuran teks hari, tanggal, bulan lebih kecil */
    }

    #current-time {
        font-size: 2rem; /* Ukuran waktu lebih kecil */
    }
}

/* Styling khusus untuk card Date and Time */
#card-date-time .card-body {
    display: flex;
    flex-direction: column; /* Menampilkan elemen secara kolom (atas ke bawah) */
    align-items: center; /* Menyelaraskan elemen di tengah secara horizontal */
    justify-content: center; /* Menyelaraskan elemen di tengah secara vertikal */
}

/* Styling untuk current-day (hari, tanggal, bulan, tahun) */
#card-date-time #current-day {
    font-size: 1.2rem; /* Ukuran teks lebih kecil */
    font-weight: 300; /* Teks tipis */
    margin-bottom: 5px; /* Memberikan sedikit jarak di bawahnya */
    color: rgba(0, 0, 0, 0.7); /* Memberikan warna teks lebih lembut (hitam tipis) */
}

/* Styling untuk current-time (waktu) */
#card-date-time #current-time {
    font-size: 2.5rem; /* Ukuran teks lebih besar untuk waktu */
    font-weight: bold; /* Teks lebih tebal untuk waktu */
    color: #333; /* Warna waktu lebih gelap untuk menonjol */
}

/* Responsif untuk perangkat kecil */
@media (max-width: 768px) {
    #card-date-time #current-day {
        font-size: 1rem; /* Ukuran teks lebih kecil untuk layar kecil */
    }

    #card-date-time #current-time {
        font-size: 2rem; /* Ukuran waktu sedikit lebih kecil pada layar kecil */
    }
}

/* Keyframes untuk fade-in dengan slide-up */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px); /* Mulai dari bawah */
    }
    to {
        opacity: 1;
        transform: translateY(0); /* Berhenti pada posisi awal */
    }
}

/* Keyframes untuk efek zoom */
@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(0.8); /* Mulai dari ukuran lebih kecil */
    }
    to {
        opacity: 1;
        transform: scale(1); /* Berhenti pada ukuran normal */
    }
}

/* Animasi untuk kartu */
.card-custom {
    opacity: 0; /* Awalnya transparan */
    animation-duration: 0.8s; /* Durasi animasi */
    animation-timing-function: ease-out; /* Efek pelan di akhir */
    animation-fill-mode: forwards; /* Tetap pada posisi akhir */
}

/* Gunakan kelas berbeda untuk animasi spesifik */
.card-fade-in {
    animation-name: fadeInUp;
}

.card-zoom-in {
    animation-name: zoomIn;
}

.card-custom:nth-child(1) {
    animation-delay: 0.2s; /* Kartu pertama animasi lebih cepat */
}

.card-custom:nth-child(2) {
    animation-delay: 0.4s; /* Kartu kedua animasi sedikit terlambat */
}

.card-custom:nth-child(3) {
    animation-delay: 0.6s; /* Kartu ketiga */
}

.card-custom:nth-child(4) {
    animation-delay: 0.8s; /* Kartu keempat */
}

        /* CSS untuk Wave Animasi */
        .wave-container {
            position: absolute; /* Absolute positioning to place it behind the text */
            bottom: -10px; /* Adjust vertical position */
            left: 0;
            width: 100%; /* Ensure it covers the entire width */
            height: 80px; /* Adjust the height of the wave */
            overflow: hidden;
            z-index: -1; /* Ensure it's behind the text */
        }

        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%; /* Stretch the wave across the width */
            height: 80px; /* Match the height of the container */
            background: #0d6efd;
            animation: waveAnimation 5s linear infinite;
        }

        /* Styling for the Time Section */
        #current-time {
            font-size: 2.5em;
            font-weight: bold;
            color: #333;
        }

        /* Flexbox adjustment for the row containing Time and Graph */
        .row.mb-4 {
            display: flex;
            flex-wrap: wrap;
        }

        /* Set the width for the Time and Graph columns */
        .col-lg-4 {
            flex: 0 0 33.33333%;
            max-width: 33.33333%;
        }

        .col-lg-8 {
            flex: 0 0 66.66666%;
            max-width: 66.66666%;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    </style>
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
                    <h1 class="text-start">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
                    <!-- Wave Animation Behind Text -->
                    <div class="wave-container">
                        <div class="wave"></div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
    <!-- Jumlah Guru -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-center card-custom card-guru">
            <div class="card-body d-flex justify-content-between align-items-center">
                <!-- Text Left -->
                <div class="text-left">
                    <p class="display-4"><?php echo $data_guru; ?></p>
                    <p class="card-text">Jumlah Guru</p>
                </div>
                <!-- Icon Right -->
                <div class="card-icon bg-primary text-white mb-3">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Siswa -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-center card-custom card-siswa">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="text-left">
                    <p class="display-4"><?php echo $data_siswa; ?></p>
                    <p class="card-text">Jumlah Siswa</p>
                </div>
                <div class="card-icon bg-success text-white mb-3">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Ruangan -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-center card-custom card-ruangan">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="text-left">
                    <p class="display-4"><?php echo $data_ruangan; ?></p>
                    <p class="card-text">Jumlah Ruangan</p>
                </div>
                <div class="card-icon bg-warning text-white mb-3">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Barang -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-center card-custom card-barang">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="text-left">
                    <p class="display-4"><?php echo $data_barang; ?></p>
                    <p class="card-text">Jumlah Barang</p>
                </div>
                <div class="card-icon bg-danger text-white mb-3">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mb-4">
    <!-- Left Column: Date and Time -->
    <div class="col-lg-4 col-md-6 mb-4" id="card-date-time">
        <div class="card">
            <div class="card-header text-center">
                <h5>Date and Time</h5>
            </div>
            <div class="card-body text-center">
                <h4 id="current-day"></h4> <!-- Display day, date, month, year here -->
                <h3 id="current-time"></h3> <!-- Display current time here -->
            </div>
        </div>
    </div>

    <!-- Right Column: Graph -->
    <div class="col-lg-8 col-md-6 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <h5>Grafik Data Barang</h5>
            </div>
            <div class="card-body">
                <canvas id="graphCanvas" style="height: 400px; width: 100%;"></canvas> <!-- Canvas for the graph -->
            </div>
        </div>
    </div>
</div>
            </div>

        </div>
    </div>
</div>

</body>  
</html>
