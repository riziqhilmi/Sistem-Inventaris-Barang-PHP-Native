<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style3.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700,800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
  <!-- Include Font Awesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>SDN PASAREJO 1 | Unofficial Site</title>
  <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
  <style>
    /* Styling for the Visi Card */
    .card-body {
      cursor: pointer;
      transition: all 0.3s ease;
      /* Smooth transition for all properties */
    }

    /* Visi Card hover effect */
    .visi-card:hover {
      background-color: #f0f0f0;
      /* Change the background color on hover */
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      /* Add shadow effect */
      transform: translateY(-5px);
      /* Lift the card slightly */
    }

    /* Visi Card text color change on hover */
    .visi-card:hover .card-title,
    .visi-card:hover .card-text {
      color: #FF5733;
      /* Change text color on hover */
    }

    /* Image initially hidden */
    .hidden-image {
      display: none;
      transform: translateY(-20px);
      opacity: 0;
      transition: transform 0.5s ease-out, opacity 0.5s ease-out;
      width: 50%;
      /* Adjust the image to take up the full width of the card */
      max-width: 400px;
      /* Max width of the image */
      height: auto;
      /* Maintain aspect ratio */
      object-fit: cover;
      /* Maintain aspect ratio and cover the area */
      margin: 20px auto;
      /* Center the image and add space around it */
    }

    /* Animation for the image to show up */
    .show-image {
      display: block;
      transform: translateY(0);
      opacity: 1;
    }

    .card-title {
      font-family: 'Verdana', sans-serif;
      font-size: 1.5rem;
      color: #FF5733;
    }

    .card-text {
      font-size: 1.2rem;
      font-weight: bold;
      color: #4CAF50;
      text-align: center;
    }

    /* Style for Misi content */
    .card-body ul {
      text-align: left;
      /* Align the list items to the left */
      padding-left: 20px;
      /* Add some padding on the left to ensure it doesn't touch the container's edge */
    }

    .card-body ul li {
      font-size: 1rem;
      color: #333;
      line-height: 1.6;
    }

    /* Downward arrow style */
    .arrow-down {
      text-align: center;
      font-size: 2rem;
      color: #FF5733;
      margin-top: 20px;
      cursor: pointer;
      opacity: 0;
      /* Initially hidden */
      transform: translateY(20px);
      /* Start position, below the card */
      transition: transform 0.5s ease, opacity 0.5s ease;
      /* Smooth transition for sliding up and fading */
    }

    /* Animation class to show the arrow */
    .show-arrow {
      opacity: 1;
      transform: translateY(0);
      /* Arrow moves up */
    }
  </style>
</head>

<body>

  <!-- navbar -->
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="img/logo_sd.png" width="35" height="45" class="d-inline-block align-top" alt="">
        SDN PASAREJO 1
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
          <a class="nav-item nav-link active" href="index.php">Home<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="#profile">Profile</a>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" style="color:white !important; href=" #" id="navbarDropdown"
              role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Prestasi siswa
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#ak">Juara 01</a>
              <a class="dropdown-item" href="#ak">Juara 02</a>
              <a class="dropdown-item" href="#adper">Juara 03</a>
              <a class="dropdown-item" href="#adper">Juara 01</a>
              <a class="dropdown-item" href="#jb">grup drumband</a>
              <a class="dropdown-item" href="#jb">Juara favorit</a>
              <a class="dropdown-item" href="#rpl">Semua Guru Pasarejo</a>
            </div>
          </li>
          <a class="nav-item nav-link active" href="login2.php">Login</a>
          &nbsp;
        </div>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->

  <!-- end navbar -->
  <BR>
  <BR>
  <br>


  <!-- Carousel -->
  <div class="bd-example">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/guru3.jpeg" class="d-block carousel-img w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>SDN PASAREJO 1</h5>
            

          </div>
        </div>

        <div class="carousel-item">
          <img src="img/guru2.jpeg" class="d-block carousel-img w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5 style="color: #00BFFF;">SDN PASAREJO 01</h5>
            <p>
              Dengan hadirnya situs SD Negeri 1 Pasarejo ini,
              semoga dapat memberikan informasi
              kepada khalayak tentang SD Negeri 1 Pasarejo.

            </p>
          
          </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <!-- end carousel -->
    <div class="row panel mx-auto">
      <div class="header col-8 mt-5 text-center mx-auto">
        <h1> Selamat Datang</h1>
        <p>Selamat datang di website SDN PASAREJO 01. Sekolah bertaraf internasional yang memiliki banyak prestasi dan
          murid yang berkarakter.
        </p>
      </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <
    <div class="row">
      <div class="header2 col-10 mt-5 text-center mx-auto">
        <h1 data-aos="fade-right" data-aos-duration="1200">Sambutan Kepala Sekolah</h1>
        <br>
        <img src="img/ganteng.jpg" class="rounded-circle" alt="" style=" height: 245px;">

        <br>
        <br>
        <blockquote class="blockquote">
          <p class="mb-0" data-aos="fade-right" data-aos-duration="1200">Dengan hadirnya situs SDN PASAREJO01 ini,
            <br>
            semoga dapat memberikan informasi
            kepada khalayak tentang <br> SDN PASAREJO 01
            SDN Bisa, SDN PASAREJO 01 Yakin Bisa.</p>
          <footer class="blockquote-footer"><cite title="Source Title">Kepala Sekolah
              SDN PASAREJO 01 Hermawan</cite></footer>
        </blockquote>
      </div>
    </div>
    <br>
    <br>

    <div class="header2 col-10 mt-5 text-center mx-auto" id="profile">
      <h1 data-aos="fade-right" data-aos-duration="1200" style="font-family: 'Arial', sans-serif; color: #4CAF50;">Visi
        dan Misi SDN PASAREJO 01</h1>

      <div class="row mt-4" data-aos="fade-right" data-aos-duration="1200">
        <!-- Identitas Sekolah Card (top card) -->
        <div class="col-10 mx-auto">
          <div class="card shadow-sm" style="border-radius: 15px; border: 1px solid #ddd;">
            <div class="card-body">
              <h2 class="card-title"><strong>A. Identitas Sekolah</strong></h2>
              <p style="text-align: justify !important; font-size: 1rem; color: #333; line-height: 1.6;">
                SDN PASAREJO 01 mempunyai izin pendirian sekolah tersurat, pada Nomor 326/B3/KEJ dan berdiri sejak
                bulan Agustus Tahun 1964.
                Posisi sekolah berada di Jl. Trunojoyo No.186, Krajan, Pasarejo, Kec. Wonosari, Kabupaten Bondowoso, Jawa Timur 68282
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4" data-aos="fade-right" data-aos-duration="1200">
        <!-- Visi Card (middle card) with specific class for hover animation -->
        <div class="col-md-5 mx-auto">
          <div class="card shadow-sm visi-card" style="border-radius: 15px; border: 1px solid #ddd;">
            <div class="card-body" onclick="toggleContent()">
              <h2 class="card-title"><strong>B. Visi</strong></h2>
              <p class="card-text">
                “Terwujudnya SMK Bertaraf Internasional Pada Tahun 2010”.
              </p>
              <br>
              <br>
              <br>
              <br>
              <br>
              <br>
              <!-- Hidden Image inside the card -->
              <img src="img/logo sd pasarejo.png" alt="Visi Image" class="hidden-image" id="visi-image">

              <!-- Downward Arrow Icon with animation -->
              <div class="arrow-down" id="arrow-down">
                <i class="fas fa-arrow-down"></i> <!-- Font Awesome Arrow Icon -->
              </div>
            </div>
          </div>
        </div>

        <!-- Misi Card (bottom card) -->
        <div class="col-md-5 mx-auto">
          <div class="card shadow-sm" style="border-radius: 15px; border: 1px solid #ddd;">
            <div class="card-body">
              <h2 class="card-title"><strong>C. Misi</strong></h2>
              <ul>
                <li>Bersikap profesional dalam melakukan segala tindakan dan perbuatan pada keimanan dan ketakwaan
                  kepada Allah SWT.</li>
                <li>Membangun kemitraan yang kokoh dengan pemerintahan daerah, masyarakat, institusi pasangan dan dunia
                  usaha industri.</li>
                <li>Melakukan inovasi dalam bidang ilmu pengetahuan dan teknologi.</li>
                <li>Memberikan bekal pengetahuan dan keterampilan kepada seluruh warga sekolah agar mampu bersaing dalam
                  era global.</li>
                <li>Memberikan pelayanan yang prima berdasar pada standar mutu ISO 9001:2000.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Include Bootstrap JS for animations (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Function to toggle image visibility and arrow animation
      function toggleContent() {
        var image = document.getElementById('visi-image');
        var arrow = document.getElementById('arrow-down');

        // Toggle image visibility
        image.classList.toggle('show-image');

        // Toggle arrow animation
        arrow.classList.toggle('show-arrow');
      }
    </script>

    <div class="header2 col-10 mt-5 text-center mx-auto">
      <h1>Prestasi SDN Pasarejo 01</h1>
      <br>
      <div class="row" data-aos="fade-left" data-aos-duration="1200" id="ak">
        <div class="col-6">
          <div class="card mb-5">
            <img src="img/juara mapel ipa.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"
                style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Juara 1</h5>
              <p class="card-text">Lomba Mapel IPA dan Matematika tingkat kecamatan wonosari <br> <br><br></p>
              <p class="card-text"><small class="text-muted">SDN PASAREJO 01</small></p>
            </div>
          </div>
        </div>


        <br>
        <div class="col-6">
          <div class="card mb-5">
            <img src="img/juara perpus.jpeg" class="card-img-top img-fluid" alt="...">
            <div class="card-body">
              <h5 class="card-title"
                style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Juara 2</h5>
              <p class="card-text"> Lomba perpustakan sekolah se kabupaten bondowoso.<br> <br> <br></p>
              <p class="card-text"><small class="text-muted">SDN PASAREJO 01</small></p>
            </div>
          </div>
        </div>
      </div>
      <br>

      <div class="row" data-aos="fade-right" data-aos-duration="1200" id="">
        <div class="col-6" id="adper">
          <div class="card mb-3">
            <img src="img/juara mb.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"
                style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Juara 3</h5>
              <p class="card-text">Marching band BOMF Kaporles cup 2023.<br> <br> <br> </p>
              <p class="card-text"><small class="text-muted">SDN PASAREJO 01</small></p>
            </div>
          </div>
        </div>


        <br>

        <div class="col-6">
          <div class="card mb-3">
            <img src="img/juara gatau.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"
                style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Juara 1</h5>
              <p class="card-text">Lomba Sekabupaten Bondowoso. <br> <br></p>
              <p class="card-text"><small class="text-muted">SDN PASAREJO O1</small></p>
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="row" data-aos="fade-left" data-aos-duration="1200">
        <div class="col-6 mx-auto" id="jb">
          <div class="card mb-3">
            <img src="img/juara dm.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"
                style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Grup drumband
              </h5>
              <p class="card-text">CKBS Lomba marching band festival BOMF 2023</p>
              <p class="card-text"><small class="text-muted">SDN PASAREJO 01</small></p>
            </div>
          </div>
        </div>


        <br>

        <div class="col-6 mx-auto">
          <div class="card mb-3">
            <img src="img/juara pramuka.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"
                style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Juara Favorit
              </h5>
              <p class="card-text">CTG open IV Gramatsada tingkat kabupaten Bondowoso. <br> </p>
              <p class="card-text"><small class="text-muted">SDN PASAREJO 01</small></p>
            </div>
          </div>
        </div>
      </div>



      <div class="row" data-aos="fade-right" data-aos-duration="1200">
        <div class="col-12" id="rpl">

          <div class="card mb-3">
            <img src="img/kay.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"
                style="color:#3498DB !important; font-weight: 800 !important; font-size:30px !important;">SEMUA GURU SDN
                PASAREJO 01 BONDOWOSO</h5>
              <p class="card-text"><small class="text-muted">SDN PASAREJO 01</small></p>
            </div>
          </div>
        </div>
      </div>

      <br>
      <br>
     

     
    </div>
  </div>
  </div>

  <!-- Optional JavaScript -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>