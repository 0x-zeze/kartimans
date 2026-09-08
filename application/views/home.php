<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Kartimans Barbershop</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/kartimans1.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css?v=5" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Day
  * Template URL: https://bootstrapmade.com/day-multipurpose-html-template-for-free/
  * Updated: Mar 19 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <header id="header" class="header fixed-top">

    <div class="branding">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="<?= base_url(); ?>" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="">KARTIMANS</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="">Beranda</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#services">Layanan</a></li>
            <li><a href="#contact">Kontak</a></li>
            <li><a href="<?= base_url('ControllerLogin'); ?>">Login</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>
    </div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <img src="assets/img/barber.jpg" alt="" data-aos="fade-in">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-start">
          <div class="col-lg-8">
            <h2 class="">SELAMAT DATANG</h2>
            <p>Kartimans Barbershop</p>
            <a href="#about" class="btn-get-started">Good Looking Good Feels</a>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="">Tentang Kartimans<br></span>
        <h2 class="">Tentang Kartimans<br></h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/kartimans.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>KARTIMANS</h3>
            <p class="fst-italic">
            Pada tahun 2019, The Kartimans pertama kali didirikan di kota Purwokerto. Awalnya, The Kartimans hanya berada dirumah sendiri saja. Namun, seiring berjalannya waktu, The Kartimans mulai membuka gerai di tengah-tengah kota Purwokerto yaitu sebelah SMA N 2 Purwokerto.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>The Kartimans meyakini bahwa barbershop seharusnya tidak hanya memperhatian hasil potongan rambut saja, tetapi juga pelayanan dan kesan yang dirasakan pengunjung saat mendapatkannya.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>The Kartimans berkomitmen untuk selalu memberikan pengalaman lebih saat potong rambut serta perawatan yang berkesan kepada setiap pelanggan kami dengan pelayanan yang profesional.</span></li>
            </ul>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Cards Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">

      <div class="container">

        <div class="swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>

      </div>

    </section><!-- /Clients Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="">Layanan</span>
        <h2>Layanan Kartimans</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item  position-relative">
              <div class="icon">
                <svg class="service-icon" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                  <path d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zM19 3l-6 6 2 2 7-7V3z"/>
                </svg>
              </div>
              <h3>Haircut (Keramas, Hair Tonic, Styling, Hot Towel)</h3>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item  position-relative">
              <div class="icon">
                <svg class="service-icon" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                  <path d="M7 14c-1.66 0-3 1.34-3 3 0 1.31-1.16 2-2 2 .92 1.22 2.49 2 4 2 2.21 0 4-1.79 4-4 0-1.66-1.34-3-3-3zm13.71-9.37-1.34-1.34c-.39-.39-1.02-.39-1.41 0L9 12.25 11.75 15l8.96-8.96c.39-.39.39-1.02 0-1.41z"/>
                </svg>
              </div>
              <h3>Basic Coloring</h3>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon">
                <svg class="service-icon" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                  <path d="M5 2h14a1 1 0 0 1 1 1v3H4V3a1 1 0 0 1 1-1z"/>
                  <path d="M5.25 7h1.9v14.2a.95.95 0 1 1-1.9 0V7zm3.85 0h1.9v14.2a.95.95 0 1 1-1.9 0V7zm3.85 0h1.9v14.2a.95.95 0 1 1-1.9 0V7zm3.85 0h1.9v14.2a.95.95 0 1 1-1.9 0V7z"/>
                </svg>
              </div>
              <h3>Bleaching</h3>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon">
                <svg class="service-icon" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                  <path d="M3.5 3.25h17a1.25 1.25 0 0 1 0 2.5h-.75v1.5a1 1 0 0 1-1 1h-4.5V11H16a1 1 0 0 1 1 1v7.25a3 3 0 0 1-6 0V12a1 1 0 0 1 1-1h1.75V8.25h-4.5a1 1 0 0 1-1-1v-1.5h-.75a1.25 1.25 0 0 1 0-2.5z"/>
                </svg>
              </div>
              <h3>Shaving</h3>
            </div>
          </div><!-- End Service Item -->


        </div>

      </div>

    </section><!-- /Services Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section">

      <img src="assets/img/barber.jpg" alt="">

    </section><!-- /Call To Action Section -->


    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="">Kontak</span>
        <h2 class="">Kontak</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-stretch">

          <div class="col-lg-6">
            <div class="info-item h-100 d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt"></i>
              <h3>Alamat</h3>
              <p>Karangkobar, Purwanegara, Purwokerto Timur<br>x`Banyumas Regency, Central Java 53116</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6">
            <div class="info-item h-100 d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone"></i>
              <h3>Hubungi Kami</h3>
              <p>0882005518510</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6">
            <div class="info-item h-100 d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-instagram"></i>
              <h3>Instagram</h3>
              <p>@thekartimanshaircuts</p>
            </div>
          </div><!-- End Info Item -->

        </div>

        <div class="row gy-4 mt-3">
          <div class="col-12" data-aos="fade-up" data-aos-delay="300">
            <div class="map-embed">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.400824256799!2d109.23380291057998!3d-7.4208151925587575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655e882c8e5933%3A0x11e105768180127d!2sThe%20Kartimans!5e0!3m2!1sen!2sid!4v1719481423407!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div><!-- End Google Maps -->
        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer position-relative">


    <div class="container copyright text-center mt-4">
      <p><strong>The Kartimans Barbershop</strong></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>