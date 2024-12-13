<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            transition: all 0.3s ease; /* Smooth transition for all properties */
        }

        /* Visi Card hover effect */
        .visi-card:hover {
            background-color: #f0f0f0; /* Change the background color on hover */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Add shadow effect */
            transform: translateY(-5px); /* Lift the card slightly */
        }

        /* Visi Card text color change on hover */
        .visi-card:hover .card-title, .visi-card:hover .card-text {
            color: #FF5733; /* Change text color on hover */
        }

        /* Image initially hidden */
        .hidden-image {
            display: none;
            transform: translateY(-20px);
            opacity: 0;
            transition: transform 0.5s ease-out, opacity 0.5s ease-out;
            width: 50%; /* Adjust the image to take up the full width of the card */
            max-width: 400px; /* Max width of the image */
            height: auto; /* Maintain aspect ratio */
            object-fit: cover; /* Maintain aspect ratio and cover the area */
            margin: 20px auto; /* Center the image and add space around it */
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
        text-align: left; /* Align the list items to the left */
        padding-left: 20px; /* Add some padding on the left to ensure it doesn't touch the container's edge */
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
            opacity: 0; /* Initially hidden */
            transform: translateY(20px); /* Start position, below the card */
            transition: transform 0.5s ease, opacity 0.5s ease; /* Smooth transition for sliding up and fading */
        }

        /* Animation class to show the arrow */
        .show-arrow {
            opacity: 1;
            transform: translateY(0); /* Arrow moves up */
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link active" href="index.php">Home<span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="#profile">Profile</a>
                <li class="nav-item dropdown" >
                    <a class="nav-link dropdown-toggle" style="color:white !important; href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Kompetensi Keahlian
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#ak">Akuntansi</a>
                    <a class="dropdown-item" href="#ak">Pemasaran</a>
                    <a class="dropdown-item" href="#adper">Adper</a>
                    <a class="dropdown-item" href="#adper">Jasa Boga</a>
                    <a class="dropdown-item" href="#jb">Perhotelan</a>
                    <a class="dropdown-item" href="#jb">Multimedia</a>
                    <a class="dropdown-item" href="#rpl">RPL</a>
                    </div>
                </li>
                <li class="nav-item dropdown" >
                    <a class="nav-link dropdown-toggle" style="color:white !important; href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Siswa
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="404.php">Mata Pelajaran</a>
                    <a class="dropdown-item" href="404.php">Nilai</a>
                    </div>
                </li>
                <li class="nav-item dropdown" >
                    <a class="nav-link dropdown-toggle" style="color:white !important; href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Guru
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Daftar Guru</a>
                    </div>
                </li>
                <a class="nav-item nav-link" href="">Kontak</a>
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
          <p>Sekolah SD nya chaha yaa</p>

        </div>
      </div>
      
      <div class="carousel-item">
        <img src="img/guru2.jpeg" class="d-block carousel-img w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
        <h5 style="color: #00BFFF;">SDN PASAREJO 01</h5>
          <p >
            Dengan hadirnya situs SD Negeri 1 Pasarejo ini,
            semoga dapat memberikan informasi
            kepada khalayak tentang SD Negeri 1 Pasarejo.
        
        </p>
        <a href="" class="btn btn-carousel ">Selengkapnya &dHar; </a>
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
<div class="header col-8 mt-5 text-center mx-auto"><h1> Selamat Datang</h1>
<p >Selamat datang di website SDN PASAREJO 01. Sekolah bertaraf internasional yang memiliki banyak prestasi dan 
    murid yang berkarakter.
</p>
</div>
</div>
    
<br>
<br>
<br>
<br>
<div class="row">
<div class="header2 col-10 mt-5 text-left mx-auto"><h1 data-aos="fade-right" data-aos-duration="1200" >Sejarah Singkat &mdash;&mdash;&mdash;&mdash;</h1>
<p data-aos="fade-right" data-aos-duration="2000">SMK Negeri 1 Ciamis semula bernama SMEA Negeri Ciamis yang
     berlokasi di Jl. Ir. H. Juanda No. 304/35SMKN 1 Ciamis Tempo 
     DoeloeCiamis, terdiri dari 13 ruang yang berdiri di atas 
     tanah seluas 0,279 Ha yang dahulunya digunakan untuk Sekolah
      Dasar Sikuraja
      Tanah tersebut diperoleh dari Bupati Daswati II Ciamis melalui Surat Penyerahan Nomor: 6453/B.VI/Pem-69 Tanggal: 29 Desember 1969, sedangkan bangunan diperoleh dari Pemda Daswati II Ciamis dan sebagian lagi dari Proyek Depdikbud sebanyak 3 (tiga) ruang. </p>
</div>
</div>
<br>
<br>
<div class="row">
<div class="header2 col-10 mt-5 text-center mx-auto"><h1 data-aos="fade-right" data-aos-duration="1200">Sambutan Kepala Sekolah</h1>
<br>
<img src="img/kepsek.png" class="rounded-circle" alt="">
<br>
<br>
<blockquote class="blockquote">
  <p class="mb-0" data-aos="fade-right" data-aos-duration="1200">Dengan hadirnya situs SMK Negeri 1 Ciamis ini, <br>
semoga dapat memberikan informasi
kepada khalayak tentang <br> SMK Negeri 1 Ciamis.
SMK Bisa, SMKN 1 Ciamis Yakin Bisa.</p>
  <footer class="blockquote-footer">Dra. Hj. Ika Karniati Sardi, MM.Pd<cite title="Source Title">Kepala Sekolah SMKN 1 Ciamis</cite></footer>
</blockquote>
</div>
</div>
<br>
<br>

<div class="header2 col-10 mt-5 text-center mx-auto" id="profile">
    <h1 data-aos="fade-right" data-aos-duration="1200" style="font-family: 'Arial', sans-serif; color: #4CAF50;">Visi dan Misi SMKN 1 Ciamis</h1>

    <div class="row mt-4" data-aos="fade-right" data-aos-duration="1200">
        <!-- Identitas Sekolah Card (top card) -->
        <div class="col-10 mx-auto">
            <div class="card shadow-sm" style="border-radius: 15px; border: 1px solid #ddd;">
                <div class="card-body">
                    <h2 class="card-title">A. Identitas Sekolah</h2>
                    <p style="text-align: justify !important; font-size: 1rem; color: #333; line-height: 1.6;">
                        SMK Negeri 1 Ciamis mempunyai izin pendirian sekolah tersurat, pada Nomor 326/B3/KEJ dan berdiri sejak bulan Agustus Tahun 1964.
                        Posisi sekolah berada di Jln. Jend. Sudirman No. 269 Telp./Fax. (0265) 771204 – 776955 Desa/Kelurahan : Sindangrasa, Kecamatan Ciamis,
                        Kab./Kota : Ciamis, Email: smkn1cms@indo.net.id, Website : www.smkn1-cms.sch.id. NSS/NDS : 341021401001.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4" data-aos="fade-right" data-aos-duration="1200">
        <!-- Visi Card (middle card) with specific class for hover animation -->
        <div class="col-md-5 mx-auto">
            <div class="card shadow-sm visi-card" style="border-radius: 15px; border: 1px solid #ddd;">
                <div class="card-body" onclick="toggleContent()">
                    <h2 class="card-title">B. Visi</h2>
                    <p class="card-text">
                        “Terwujudnya SMK Bertaraf Internasional Pada Tahun 2010”.
                    </p>
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
                    <h2 class="card-title">C. Misi</h2>
                    <ul>
                        <li>Bersikap profesional dalam melakukan segala tindakan dan perbuatan pada keimanan dan ketakwaan kepada Allah SWT.</li>
                        <li>Membangun kemitraan yang kokoh dengan pemerintahan daerah, masyarakat, institusi pasangan dan dunia usaha industri.</li>
                        <li>Melakukan inovasi dalam bidang ilmu pengetahuan dan teknologi.</li>
                        <li>Memberikan bekal pengetahuan dan keterampilan kepada seluruh warga sekolah agar mampu bersaing dalam era global.</li>
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

<div class="header2 col-10 mt-5 text-center mx-auto"><h1>Prestasi SDN Pasarejo 01</h1>
<br>
<div class="row"  data-aos="fade-left" data-aos-duration="1200" id="ak">
    <div class="col-6" >
    <div class="card mb-5">
  <img src="img/juara mapel ipa.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Jurusan Akutansi</h5>
    <p class="card-text">Mewujudkan Kompetensi Keahlian Akuntansi yang berkualitas dan religius di bidang bisnis dan manajemen untuk menanggapi persaingan di era global <br> <br></p>
    <p class="card-text"><small class="text-muted">SMKN 1 CIAMIS</small></p>
  </div>
</div>
    </div>


<br>
    <div class="col-6">
    <div class="card mb-5">
  <img src="img/juara perpus.jpeg" class="card-img-top img-fluid" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Jurusan Pemasaran</h5>
    <p class="card-text">Menjadi lembaga diklat yang menghasilkan sumber daya manusia yang profesional yang mampu berkompetisi di tingkat nasional dan internasional. SMKN 1 CIAMIS Yakin Bisa! <br> <br></p>
    <p class="card-text"><small class="text-muted">SMKN 1 CIAMIS</small></p>
  </div>
</div>
    </div>
</div>
<br>

<div class="row"  data-aos="fade-right" data-aos-duration="1200" id="">
    <div class="col-6" id="adper">
    <div class="card mb-3">
  <img src="img/juara mb.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Jurusan Administrasi Perkantoran</h5>
    <p class="card-text">Mencetak calon sekretaris, dan profesional. <br>  <br> <br> </p>
    <p class="card-text"><small class="text-muted">SMKN 1 CIAMIS</small></p>
  </div>
</div>
    </div>


<br>

    <div class="col-6">
    <div class="card mb-3">
  <img src="img/juara gatau.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Jurusan Akomodasi Perhotelan</h5>
    <p class="card-text">Menjadi lembaga diklat yang menghasilkan sumber daya manusia yang profesional yang mampu berkompetisi di tingkat nasional dan internasional.</p>
    <p class="card-text"><small class="text-muted">SMKN 1 CIAMIS</small></p>
  </div>
</div>
    </div>
    </div>

<br>

<div class="row"  data-aos="fade-left" data-aos-duration="1200">
    <div class="col-6 mx-auto" id="jb">
    <div class="card mb-3">
  <img src="img/juara dm.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Jurusan Jasa Boga</h5>
    <p class="card-text">Menjadi lembaga diklat yang menghasilkan sumber daya manusia yang profesional yang mampu berkompetisi di tingkat nasional dan internasional.</p>
    <p class="card-text"><small class="text-muted">SMKN 1 CIAMIS</small></p>
  </div>
</div>
    </div>


<br>

    <div class="col-6 mx-auto">
    <div class="card mb-3">
  <img src="img/juara pramuka.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="color:#3498db !important; font-weight: 800 !important; font-size:30px !important;">Jurusan Multimedia</h5>
    <p class="card-text">Multimedia adalah Kompetensi Keahlian pada SMK Negeri 1 Ciamis yang berada di lingkungan Dinas Pendidikan Provinsi Jawa Barat, tepatnya di Kabupaten Ciamis.</p>
    <p class="card-text"><small class="text-muted">SMKN 1 CIAMIS</small></p>
  </div>
</div>
    </div>
    </div>



  <div class="row"  data-aos="fade-right" data-aos-duration="1200">
    <div class="col-12" id="rpl">
   
    <div class="card mb-3">
  <img src="img/kay.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="color:#3498DB !important; font-weight: 800 !important; font-size:30px !important;">Jurusan Rekayasa Perangkat Lunak</h5>
    <p class="card-text">Mencetak dan menghasilkan generasi millenial yang Mahir dalam hal IT Yaitu coding,tech enterpreneur,Leadership dan serta memiliki attitude baik dalam keseharian</p>
    <p class="card-text"><small class="text-muted">SMKN 1 CIAMIS</small></p>
  </div>
</div>
</div>
  </div>

  <br>
  <br>
  <div class="row"  data-aos="fade-left" data-aos-duration="1200">
  <div class="header2 col-10 mt-5 text-left mx-auto"><h1>&mdash;&mdash;&mdash;& Maps SMKn 1 Ciamis</h1>
  <br>
  <br>
</div>
  <br>
  <br>

  <div class="row mx-auto">
  <div class="col-8">
  <div class="mapouter mx-auto"><div class="gmap_canvas"><iframe width="748" height="476" id="gmap_canvas" src="https://www.google.com/maps/@-7.9059823,113.8952509,947m/data=!3m1!1e3?entry=ttu&g_ep=EgoyMDI0MTAwMi4xIKXMDSoASAFQAw%3D%3D" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/nordvpn-coupon-code/">embedgooglemap.net</a></div><style>.mapouter{position:relative;text-align:right;height:476px;width:748px;}.gmap_canvas {overflow:hidden;background:none!important;height:476px;width:748px;}</style></div>
  </div>
  
  </div>  
  <br>
  <br>
  <br>
  <br>
  
<div class="row mx-auto">
  <div class="header2 col-12 mt-5 text-center mx-auto"><h1> <br>
  <br>
  <br> Testimonial Alumni SMKn 1 Ciamis! <br>
<br> <br></h1>
  </div>
<div class="col-6"  data-aos="fade-left" data-aos-duration="1000">
<!-- HTML GOES HERE  -->


<div class="testimonial" >
	<div class="testimonial-body">
		<p>Sekolah nya bagus banget . guru nya ramah. aku juga suka kantinya. pokok nya sekolahnya keren dan gak ngebosenin!</p>
		<i class="fas fa-quote-right"></i>
	</div>
	<div class="testimonial-footer">
		<img src="img/uqy.jpg" alt="user" />
		<h3>Syauqi Zaidan</h3>
		<h4 class="text-center">bla bla bla</h4>
	</div>
</div>
</div>
<div class="col-6" data-aos="fade-left" data-aos-duration="1200"  >
<!-- HTML GOES HERE  -->

<div class="testimonial">
	<div class="testimonial-body">
		<p>Sekolah nya bagus banget . guru nya ramah. aku juga suka kantinya. pokok nya sekolahnya keren dan gak ngebosenin!</p>
		<i class="fas fa-quote-right"></i>
	</div>
	<div class="testimonial-footer">
		<img src="img/anto.png" alt="user" />
		<h3>Supryanto wp</h3>
		<h4 class="text-center">bla bla bla</h4>
	</div>
</div>

</div>
  </div>
<br>
<br>

<div class="row mx-auto">
  <div class="header2 col-12 mt-5 text-center mx-auto"><h1></h1>
  </div>
<div class="col-6"  data-aos="fade-right" data-aos-duration="1500">
<!-- HTML GOES HERE  -->


<div class="testimonial">
	<div class="testimonial-body">
		<p>Sekolah nya bagus banget . guru nya ramah. aku juga suka kantinya. pokok nya sekolahnya keren dan gak ngebosenin!</p>
		<i class="fas fa-quote-right"></i>
	</div>
	<div class="testimonial-footer">
		<img src="img/uqy.jpg" alt="user" />
		<h3>Syauqi Zaidan</h3>
		<h4 class="text-center">bla bla bla</h4>
	</div>
</div>
</div>
<div class="col-6" data-aos="fade-right" data-aos-duration="1800">
<!-- HTML GOES HERE  -->

<div class="testimonial">
	<div class="testimonial-body">
		<p>Sekolah nya bagus banget . guru nya ramah. aku juga suka kantinya. pokok nya sekolahnya keren dan gak ngebosenin!</p>
		<i class="fas fa-quote-right"></i>
	</div>
	<div class="testimonial-footer">
		<img src="img/anto.png" alt="user" />
		<h3>Syauqi Zaidan</h3>
		<h4 class="text-center">bla bla bla</h4>
	</div>
</div>
<br>
<br>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>