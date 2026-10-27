<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * THE KARTIMANS BARBERSHOP — CENTRALIZED BUSINESS CONFIGURATION
 * Verified Data Sources: data.sql, assets, verified location & contact
 */
$biz = [
    'name'           => "The Kartimans Barbershop",
    'brand_title'    => "Kartiman's Barbershop | Potong Rambut & Grooming Purwokerto",
    'tagline'        => "Potongan rapi. Gaya percaya diri.",
    'phone_display'  => "0882005518510",
    'whatsapp_num'   => "62882005518510", // Verified without + or special chars
    'instagram'      => "@thekartimanshaircuts",
    'instagram_url'  => "https://instagram.com/thekartimanshaircuts",
    'address'        => "Jl. Karangkobar, Purwanegara, Purwokerto Timur (Sebelah SMA N 2 Purwokerto), Banyumas, Jawa Tengah 53116",
    'maps_url'       => "https://maps.google.com/?q=-7.420815,109.233802",
    'maps_embed'     => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.400824256799!2d109.23380291057998!3d-7.4208151925587575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655e882c8e5933%3A0x11e105768180127d!2sThe%20Kartimans!5e0!3m2!1sen!2sid!4v1719481423407!5m2!1sen!2sid",
    'hours_display'  => "Setiap Hari, 10:00 - 21:00 WIB",
    'established'    => 2019
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= html_escape($biz['brand_title']); ?></title>
  <meta name="description" content="The Kartimans Barbershop Purwokerto — Barbershop pria modern dengan layanan potong rambut rapi, coloring, bleaching, dan shaving profesional.">
  <meta name="theme-color" content="#F7F5F0">

  <!-- Open Graph -->
  <meta property="og:title" content="<?= html_escape($biz['brand_title']); ?>">
  <meta property="og:description" content="Layanan potong rambut pria profesional, nyaman, dan ramah di Purwokerto.">
  <meta property="og:image" content="<?= base_url('assets/img/barber.jpg'); ?>">
  <meta property="og:type" content="website">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/kartimans1.png'); ?>">

  <!-- Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons & Warm Minimalist CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/kartimans-warm.css?v=' . time()); ?>">
</head>
<body>

  <!-- Navigation Bar -->
  <header class="km-header">
    <div class="km-container">
      <div class="km-nav-inner">
        <a href="<?= base_url(); ?>" class="km-brand">
          <img src="<?= base_url('assets/img/kartimans1.png'); ?>" alt="Logo" class="km-brand-logo">
          <span>KARTIMANS</span>
        </a>

        <ul class="km-nav-menu" id="kmNavMenu">
          <li><a href="#beranda" class="km-nav-link">Beranda</a></li>
          <li><a href="#layanan" class="km-nav-link">Layanan</a></li>
          <li><a href="#galeri" class="km-nav-link">Galeri</a></li>
          <li><a href="#tentang" class="km-nav-link">Tentang</a></li>
          <li><a href="#lokasi" class="km-nav-link">Lokasi</a></li>
          <li><a href="<?= base_url('ControllerLogin/register'); ?>" class="km-nav-link" style="color: var(--km-accent); font-weight: 700;">Registrasi</a></li>
          <li><a href="<?= base_url('ControllerLogin'); ?>" class="km-nav-link">Login</a></li>
        </ul>

        <div class="km-nav-actions">
          <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-btn km-btn-primary km-btn-sm">
            <i class="bi bi-person-plus-fill"></i> Registrasi
          </a>
          <button class="km-mobile-toggle" id="kmMobileToggle" aria-label="Buka Menu">
            <i class="bi bi-list"></i>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="km-section" id="beranda" style="padding-top: 32px;">
    <div class="km-container">
      <div class="km-hero-grid">
        <div>
          <div class="km-eyebrow">The Kartimans Barbershop</div>
          <h1 class="km-heading-lg">Potongan rapi.<br>Gaya percaya diri.</h1>
          <p class="km-lead">
            Baru pertama kali ingin potong rambut di The Kartimans? Lakukan registrasi akun Anda untuk menikmati layanan pangkas rambut profesional, fasilitas nyaman, dan pelayanan terbaik di Purwokerto.
          </p>
          <div style="display: flex; gap: 14px; flex-wrap: wrap;">
            <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-btn km-btn-primary">
              <i class="bi bi-person-plus-fill"></i> Registrasi Sekarang
            </a>
            <a href="<?= base_url('ControllerLogin'); ?>" class="km-btn km-btn-secondary">
              <i class="bi bi-box-arrow-in-right"></i> Masuk / Login
            </a>
          </div>
        </div>

        <div class="km-hero-visual">
          <div class="km-hero-frame">
            <img src="<?= base_url('assets/img/barber.jpg'); ?>" alt="Interior The Kartimans Barbershop" class="km-hero-img">
            <div class="km-hero-badge">
              <div>
                <p class="km-hero-badge-title"><span class="km-status-dot"></span> Buka Hari Ini</p>
                <p class="km-hero-badge-desc"><?= html_escape($biz['hours_display']); ?></p>
              </div>
              <a href="#lokasi" class="km-btn km-btn-secondary km-btn-sm" style="padding: 6px 12px; font-size: 12px;">Peta</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Services Section -->
  <section class="km-section km-section-soft" id="layanan">
    <div class="km-container">
      <div class="km-section-header">
        <div class="km-eyebrow">Daftar Layanan</div>
        <h2 class="km-heading-md">Layanan & Harga Transparan</h2>
        <p class="km-lead">
          Setiap paket dikerjakan dengan standar kebersihan tinggi, alat steril, dan produk perawatan berkualitas.
        </p>
      </div>

      <div class="km-services-grid">
        <!-- Service 1 -->
        <div class="km-service-card">
          <div class="km-service-top">
            <div class="km-service-icon"><i class="bi bi-scissors"></i></div>
            <h3 class="km-service-name">Haircut Signature</h3>
            <p class="km-service-desc">Potong rambut rapi sesuai bentuk wajah, keramas rileks, hair tonic, styling pomade/powder, dan hot towel hangat.</p>
          </div>
          <div class="km-service-bottom">
            <span class="km-service-price">Rp 25.000</span>
            <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-btn km-btn-primary km-btn-sm">
              <i class="bi bi-person-plus"></i> Registrasi
            </a>
          </div>
        </div>

        <!-- Service 2 -->
        <div class="km-service-card">
          <div class="km-service-top">
            <div class="km-service-icon"><i class="bi bi-palette"></i></div>
            <h3 class="km-service-name">Basic Coloring</h3>
            <p class="km-service-desc">Pewarnaan rambut dasar bernuansa natural (hitam pekat, cokelat tua/mocha) untuk kesegaran dan menutupi uban.</p>
          </div>
          <div class="km-service-bottom">
            <span class="km-service-price">Rp 75.000</span>
            <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-btn km-btn-primary km-btn-sm">
              <i class="bi bi-person-plus"></i> Registrasi
            </a>
          </div>
        </div>

        <!-- Service 3 -->
        <div class="km-service-card">
          <div class="km-service-top">
            <div class="km-service-icon"><i class="bi bi-droplet-half"></i></div>
            <h3 class="km-service-name">Hair Bleaching</h3>
            <p class="km-service-desc">Proses lifting warna rambut bertahap untuk warna-warna terang / fashion color dengan formula proteksi rambut.</p>
          </div>
          <div class="km-service-bottom">
            <span class="km-service-price">Rp 75.000</span>
            <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-btn km-btn-primary km-btn-sm">
              <i class="bi bi-person-plus"></i> Registrasi
            </a>
          </div>
        </div>

        <!-- Service 4 -->
        <div class="km-service-card">
          <div class="km-service-top">
            <div class="km-service-icon"><i class="bi bi-slash-circle"></i></div>
            <h3 class="km-service-name">Clean Shaving</h3>
            <p class="km-service-desc">Cukur kumis & jenggot bersih, perapihan garis jambang, softening cream, hot towel, dan aftershave soothing lotion.</p>
          </div>
          <div class="km-service-bottom">
            <span class="km-service-price">Rp 25.000</span>
            <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-btn km-btn-primary km-btn-sm">
              <i class="bi bi-person-plus"></i> Registrasi
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery / Lookbook Section -->
  <section class="km-section" id="galeri">
    <div class="km-container">
      <div class="km-section-header">
        <div class="km-eyebrow">Lookbook Portofolio</div>
        <h2 class="km-heading-md">Temukan Gaya Rambut Anda</h2>
        <p class="km-lead">
          Koleksi hasil potongan rambut pelanggan kami di Kartimans, mulai dari taper fade, crop, classic pompadour, hingga modern side-part.
        </p>
      </div>

      <div class="km-gallery-grid">
        <div class="km-gallery-item">
          <img src="<?= base_url('assets/img/masonry-portfolio/masonry-portfolio-1.jpg'); ?>" alt="Model Rambut Kartimans 1" class="km-gallery-img" loading="lazy">
        </div>
        <div class="km-gallery-item">
          <img src="<?= base_url('assets/img/masonry-portfolio/masonry-portfolio-2.jpg'); ?>" alt="Model Rambut Kartimans 2" class="km-gallery-img" loading="lazy">
        </div>
        <div class="km-gallery-item">
          <img src="<?= base_url('assets/img/masonry-portfolio/masonry-portfolio-3.jpg'); ?>" alt="Model Rambut Kartimans 3" class="km-gallery-img" loading="lazy">
        </div>
        <div class="km-gallery-item">
          <img src="<?= base_url('assets/img/masonry-portfolio/masonry-portfolio-4.jpg'); ?>" alt="Model Rambut Kartimans 4" class="km-gallery-img" loading="lazy">
        </div>
        <div class="km-gallery-item">
          <img src="<?= base_url('assets/img/masonry-portfolio/masonry-portfolio-5.jpg'); ?>" alt="Model Rambut Kartimans 5" class="km-gallery-img" loading="lazy">
        </div>
        <div class="km-gallery-item">
          <img src="<?= base_url('assets/img/masonry-portfolio/masonry-portfolio-6.jpg'); ?>" alt="Model Rambut Kartimans 6" class="km-gallery-img" loading="lazy">
        </div>
      </div>
    </div>
  </section>

  <!-- About & Barber Team Section -->
  <section class="km-section km-section-white" id="tentang">
    <div class="km-container">
      <div class="km-about-grid">
        <div class="km-about-frame">
          <img src="<?= base_url('assets/img/about.jpg'); ?>" alt="Tentang The Kartimans" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
        </div>

        <div>
          <div class="km-eyebrow">Tentang Kami</div>
          <h2 class="km-heading-md">Lebih dari Sekadar Potong Rambut</h2>
          <p class="km-lead" style="font-size: 16px;">
            Didirikan pada tahun 2019 di Purwokerto, The Kartimans bermula dari dedikasi menciptakan pengalaman pangkas rambut yang tidak hanya rapi, namun juga memberikan ketenangan dan rasa percaya diri.
          </p>
          <p style="color: var(--km-text-muted); font-size: 15px; margin-bottom: 24px;">
            Kini berlokasi strategis di sebelah SMA Negeri 2 Purwokerto, kami selalu mengedepankan konsultasi gaya sebelum pangkas, higienitas perlengkapan, serta suasana ramah yang membuat Anda merasa seperti di rumah sendiri.
          </p>

          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
            <div style="border-left: 2px solid var(--km-accent-sage); padding-left: 14px;">
              <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700;">Konsultasi Gaya</h4>
              <p style="margin: 0; font-size: 13.5px; color: var(--km-text-muted);">Disesuaikan dengan tekstur rambut dan proporsi wajah.</p>
            </div>
            <div style="border-left: 2px solid var(--km-accent-sage); padding-left: 14px;">
              <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700;">Higienis & Rileks</h4>
              <p style="margin: 0; font-size: 13.5px; color: var(--km-text-muted);">Perlengkapan steril dengan relaksasi hot towel hangat.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Barbers Showcase -->
      <div style="margin-top: 64px;">
        <div style="text-align: center; margin-bottom: 32px;">
          <h3 class="km-heading-sm">Barber & Stylist Kami</h3>
          <p style="font-size: 14.5px; color: var(--km-text-muted); margin: 0;">Tim profesional yang siap mewujudkan penampilan terbaik Anda.</p>
        </div>

        <div class="km-barbers-grid">
          <div class="km-barber-card">
            <img src="<?= base_url('assets/img/team/team-1.jpg'); ?>" alt="Bagus Pamungkas" class="km-barber-avatar">
            <h4 style="margin: 0 0 4px 0; font-size: 17px; font-weight: 700;">Bagus Pamungkas</h4>
            <p style="font-size: 13px; color: var(--km-accent-sage); font-weight: 600; margin: 0 0 6px 0;">Master Barber & Fade Expert</p>
            <p style="font-size: 12.5px; color: var(--km-text-light); margin: 0;">Pengalaman 6+ Tahun</p>
          </div>

          <div class="km-barber-card">
            <img src="<?= base_url('assets/img/team/team-2.jpg'); ?>" alt="Dimas Setiawan" class="km-barber-avatar">
            <h4 style="margin: 0 0 4px 0; font-size: 17px; font-weight: 700;">Dimas Setiawan</h4>
            <p style="font-size: 13px; color: var(--km-accent-sage); font-weight: 600; margin: 0 0 6px 0;">Classic Cut & Hot Towel Specialist</p>
            <p style="font-size: 12.5px; color: var(--km-text-light); margin: 0;">Pengalaman 4+ Tahun</p>
          </div>

          <div class="km-barber-card">
            <img src="<?= base_url('assets/img/team/team-3.jpg'); ?>" alt="Rian Pratama" class="km-barber-avatar">
            <h4 style="margin: 0 0 4px 0; font-size: 17px; font-weight: 700;">Rian Pratama</h4>
            <p style="font-size: 13px; color: var(--km-accent-sage); font-weight: 600; margin: 0 0 6px 0;">Modern Textured & Beard Styling</p>
            <p style="font-size: 12.5px; color: var(--km-text-light); margin: 0;">Pengalaman 3+ Tahun</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Location & Opening Hours Section -->
  <section class="km-section km-section-soft" id="lokasi">
    <div class="km-container">
      <div class="km-section-header">
        <div class="km-eyebrow">Kunjungi Kami</div>
        <h2 class="km-heading-md">Lokasi & Jam Operasional</h2>
        <p class="km-lead">
          Temukan kami dengan mudah di pusat kota Purwokerto dengan akses parkir yang nyaman.
        </p>
      </div>

      <div class="km-contact-grid">
        <div class="km-contact-info-list">
          <div class="km-contact-card">
            <div class="km-contact-card-title"><i class="bi bi-geo-alt"></i> Alamat Gerai</div>
            <p class="km-contact-card-val"><?= html_escape($biz['address']); ?></p>
            <div style="margin-top: 12px;">
              <a href="<?= $biz['maps_url']; ?>" target="_blank" rel="noopener noreferrer" class="km-btn km-btn-secondary km-btn-sm">
                <i class="bi bi-box-arrow-up-right"></i> Buka di Google Maps
              </a>
            </div>
          </div>

          <div class="km-contact-card">
            <div class="km-contact-card-title"><i class="bi bi-clock"></i> Jam Operasional</div>
            <p class="km-contact-card-val"><?= html_escape($biz['hours_display']); ?></p>
            <p style="font-size: 13px; color: var(--km-text-muted); margin: 4px 0 0 0;">(Buka setiap hari)</p>
          </div>

          <div class="km-contact-card">
            <div class="km-contact-card-title"><i class="bi bi-chat-dots"></i> Kontak & Media Sosial</div>
            <p class="km-contact-card-val" style="margin-bottom: 8px;">
              Telepon / WA: <?= html_escape($biz['phone_display']); ?>
            </p>
            <p class="km-contact-card-val">
              Instagram: <a href="<?= $biz['instagram_url']; ?>" target="_blank" rel="noopener noreferrer" style="text-decoration: underline;"><?= $biz['instagram']; ?></a>
            </p>
          </div>
        </div>

        <div class="km-map-container">
          <iframe src="<?= $biz['maps_embed']; ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta Lokasi The Kartimans"></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- Final Call to Action -->
  <section class="km-section" style="padding-bottom: 72px;">
    <div class="km-container">
      <div class="km-cta-box">
        <h2 class="km-heading-md">Baru Pertama Kali Cukur di The Kartimans?</h2>
        <p class="km-lead">
          Silakan registrasi akun Anda sekarang untuk menikmati kemudahan layanan potong rambut dan grooming terbaik kami.
        </p>
        <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
          <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-btn km-btn-primary" style="background-color: #FFFFFF; color: #1C1C1C !important;">
            <i class="bi bi-person-plus-fill"></i> Registrasi Sekarang
          </a>
          <a href="<?= base_url('ControllerLogin'); ?>" class="km-btn km-btn-secondary" style="border-color: #FFFFFF; color: #FFFFFF;">
            <i class="bi bi-box-arrow-in-right"></i> Masuk / Login
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="km-footer">
    <div class="km-container">
      <div class="km-footer-inner">
        <div>
          <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 800;">The Kartimans Barbershop</h3>
          <p style="margin: 0; font-size: 13.5px; color: var(--km-text-muted);">Good Looking, Good Feels — Purwokerto, Jawa Tengah</p>
        </div>

        <div style="display: flex; gap: 20px; font-size: 14px; flex-wrap: wrap;">
          <a href="#beranda" class="km-nav-link">Beranda</a>
          <a href="#layanan" class="km-nav-link">Layanan</a>
          <a href="#galeri" class="km-nav-link">Galeri</a>
          <a href="#tentang" class="km-nav-link">Tentang</a>
          <a href="#lokasi" class="km-nav-link">Lokasi</a>
          <a href="<?= base_url('ControllerLogin/register'); ?>" class="km-nav-link" style="color: var(--km-accent); font-weight: 700;">Registrasi</a>
          <a href="<?= base_url('ControllerLogin'); ?>" class="km-nav-link" style="opacity: 0.8;">Login</a>
        </div>
      </div>

      <div class="km-footer-copy" style="text-align: center; padding-top: 24px; font-size: 13.5px; color: var(--km-text-light);">
        &copy; <?= date('Y'); ?> <?= html_escape($biz['name']); ?>. Seluruh hak cipta dilindungi.
      </div>
    </div>
  </footer>

  <!-- Vanilla JavaScript for Navigation & Mobile Drawer -->
  <script>
    (function() {
      const toggleBtn = document.getElementById('kmMobileToggle');
      const navMenu = document.getElementById('kmNavMenu');

      if (toggleBtn && navMenu) {
        toggleBtn.addEventListener('click', function() {
          navMenu.classList.toggle('is-active');
          const isOpen = navMenu.classList.contains('is-active');
          toggleBtn.setAttribute('aria-expanded', isOpen);
          toggleBtn.innerHTML = isOpen ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-list"></i>';
        });

        navMenu.querySelectorAll('a').forEach(link => {
          link.addEventListener('click', () => {
            navMenu.classList.remove('is-active');
            toggleBtn.innerHTML = '<i class="bi bi-list"></i>';
          });
        });
      }
    })();
  </script>
</body>
</html>
