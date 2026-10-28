<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= html_escape($title); ?></title>
  <meta name="description" content="Booking jadwal potong rambut online di The Kartimans Haircut Purwokerto. Cepat, praktis, dan tanpa antre.">

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/kartimans1.png'); ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3.3 & Bootstrap Icons -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">

  <!-- Booking Custom Minimalist CSS -->
  <link href="<?= base_url('assets/css/booking.css?v=' . time()); ?>" rel="stylesheet">
</head>
<body class="booking-body">

  <!-- A. Navbar -->
  <header class="booking-navbar">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        <a href="<?= base_url(); ?>" class="brand-logo">
          <img src="<?= base_url('assets/img/kartimans1.png'); ?>" alt="The Kartimans Haircut Logo">
          <span>KARTIMANS</span>
        </a>
        <a href="<?= base_url(); ?>" class="btn-nav-back">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali ke Beranda</span>
        </a>
      </div>
    </div>
  </header>

  <!-- B. Header Halaman -->
  <section class="booking-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <span class="badge-kicker">
            <i class="bi bi-scissors"></i> Reservasi Online
          </span>
          <h1>Booking Jadwal Cukur</h1>
          <p>Pilih barber dan waktu yang paling cocok untukmu tanpa antre lama.</p>

  <!-- Main Booking Content -->
  <main class="container pb-5">
    <div id="bookingAlert" class="alert alert-danger py-2 px-3 mb-3" style="display:none;" role="alert"></div>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger py-2 px-3 mb-3" role="alert">
        <?= html_escape($this->session->flashdata('error')); ?>
      </div>
    <?php endif; ?>

    <form id="bookingForm" action="<?= base_url('booking/submit'); ?>" method="POST" novalidate>
      <div class="row g-4">
        
        <!-- Left Column: Selection & Form -->
        <div class="col-lg-8">
          
          <!-- C. Informasi Layanan -->
          <div class="km-card">
            <div class="km-card-header">
              <h2 class="km-card-title">
                <i class="bi bi-tag-fill"></i> Layanan Terpilih
              </h2>
              <span class="badge bg-secondary-subtle text-secondary" style="font-size:0.75rem; padding: 0.35rem 0.65rem; border-radius: 999px;">
                Paket Utama
              </span>
            </div>
            
            <div class="service-preview-card">
              <div class="service-preview-info">
                <h3><?= html_escape($service->jenis ?? 'Regular Haircut'); ?></h3>
                <p><?= html_escape($service->deskripsi ?? 'Potong rambut reguler'); ?></p>
                <div class="service-meta-tags">
                  <span class="service-meta-tag"><i class="bi bi-clock"></i> ~45 Menit</span>
                  <span class="service-meta-tag"><i class="bi bi-check2-circle"></i> Termasuk Cuci & Tonic</span>
                  <span class="service-meta-tag"><i class="bi bi-stars"></i> Pomade Styling</span>
                </div>
              </div>
              <div class="service-price-pill">
                <span class="service-price-amount">
                  Rp <?= number_format((float)($service->data_harga ?? 35000), 0, ',', '.'); ?>
                </span>
                <span class="service-price-label">Tarif Resmi</span>
              </div>
            </div>
          </div>

          <!-- D. Pilih Barber -->
          <div class="km-card">
            <div class="km-card-header">
              <h2 class="km-card-title">
                <i class="bi bi-person-badge-fill"></i> 1. Pilih Barber
              </h2>
              <small class="text-muted" style="font-size:0.8rem;">Pilih capster favoritmu</small>
            </div>

            <?php if (empty($barbers)): ?>
              <div class="text-center py-4 text-muted">
                <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                <p class="mb-0">Belum ada data barber aktif tersedia.</p>
              </div>
            <?php else: ?>
              <div class="barber-grid">
                <?php foreach ($barbers as $idx => $b): ?>
                  <label class="barber-card-option">
                    <input type="radio" name="barber_id" value="<?= $b->id_barber; ?>" data-name="<?= html_escape($b->nama); ?>" <?= $idx === 0 ? 'checked' : ''; ?>>
                    <div class="barber-card-inner">
                      <div class="barber-check-badge">
                        <i class="bi bi-check-lg"></i>
                      </div>
                      <div class="barber-avatar-wrap">
                        <img src="<?= base_url($b->foto ? $b->foto : 'assets/img/team/team-1.jpg'); ?>" alt="<?= html_escape($b->nama); ?>" class="barber-avatar" onerror="this.src='<?= base_url('assets/img/barber.jpg'); ?>'">
                      </div>
                      <div class="barber-name"><?= html_escape($b->nama); ?></div>
                      <div class="barber-spec"><?= html_escape($b->spesialisasi ?? 'Barber Stylist'); ?></div>
                    </div>
                  </label>
                <?php endforeach; ?>

          <!-- E. Pilih Tanggal & Jam -->
          <div class="km-card">
            <div class="km-card-header">
              <h2 class="km-card-title">
                <i class="bi bi-calendar3"></i> 2. Pilih Tanggal & Jam
              </h2>
              <small class="text-muted" style="font-size:0.8rem;">Slot real-time</small>
            </div>

            <div class="mb-3">
              <label for="bookingDate" class="form-label-km">Pilih Tanggal</label>
              <input type="date" id="bookingDate" name="tanggal" class="form-control-km" min="<?= $today; ?>" value="<?= $today; ?>" required>
            </div>

            <div>
              <label class="form-label-km">Pilih Slot Waktu</label>
              
              <div id="slotsPlaceholder" class="slots-empty-notice" style="display:none;">
                <i class="bi bi-clock-history fs-3 d-block mb-1"></i>
                Pilih barber dan tanggal terlebih dahulu untuk menampilkan slot waktu.
              </div>

              <div id="slotsLoading" class="slots-loading-notice" style="display:none;">
                <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>
                Memuat ketersediaan slot waktu...
              </div>

              <div id="slotsEmpty" class="slots-empty-notice" style="display:none;">
                Tidak ada slot yang tersedia untuk jadwal ini.
              </div>

              <div id="slotsContainer" class="slots-grid"></div>
            </div>
          </div>

          <!-- F. Data Pelanggan -->
          <div class="km-card">
            <div class="km-card-header">
              <h2 class="km-card-title">
                <i class="bi bi-person-lines-fill"></i> 3. Data Pelanggan
              </h2>
              <small class="text-muted" style="font-size:0.8rem;">Kontak konfirmasi</small>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label for="custName" class="form-label-km">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" id="custName" name="nama" class="form-control-km" placeholder="Contoh: Budi Santoso" required autocomplete="name">
              </div>

              <div class="col-md-6">
                <label for="custWa" class="form-label-km">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                <input type="tel" id="custWa" name="no_wa" class="form-control-km" placeholder="Contoh: 081234567890" required autocomplete="tel">
              </div>

              <div class="col-12">
                <label for="custNotes" class="form-label-km">Catatan Tambahan (Opsional)</label>
                <textarea id="custNotes" name="catatan" rows="2" class="form-control-km" placeholder="Contoh: Minta model low fade atau datang bersama anak."></textarea>
              </div>
            </div>
          </div>

        </div>

        <!-- Right Column: Sticky Summary & CTA -->
        <div class="col-lg-4">
          <div class="sticky-summary">
            <div class="summary-card">
              <div class="summary-title">
                <span>Ringkasan Booking</span>
                <i class="bi bi-receipt text-muted"></i>
              </div>

              <div class="summary-row">
                <span class="label">Layanan</span>
                <span class="val"><?= html_escape($service->jenis ?? 'Regular Haircut'); ?></span>
              </div>

              <div class="summary-row">
                <span class="label">Barber</span>
                <span class="val" id="sumBarber">-</span>
              </div>

              <div class="summary-row">
                <span class="label">Tanggal</span>
                <span class="val" id="sumDate"><?= date('d F Y', strtotime($today)); ?></span>
              </div>

              <div class="summary-row">
                <span class="label">Jam</span>
                <span class="val" id="sumTime">-</span>
              </div>

              <div class="summary-divider"></div>

              <div class="summary-total">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-amount" id="sumPrice">
                  Rp <?= number_format((float)($service->data_harga ?? 35000), 0, ',', '.'); ?>
                </span>
              </div>

              <p class="text-muted small mb-3" style="font-size: 0.78rem;">
                <i class="bi bi-info-circle me-1"></i> Pembayaran dilakukan di kasir setelah proses potong rambut selesai.
              </p>

              <!-- H. Tombol Konfirmasi CTA -->
              <button type="submit" id="submitBookingBtn" class="btn-km-primary" disabled>
                <span id="submitSpinner" class="spinner-border spinner-border-sm" style="display:none;" role="status"></span>
                <span id="submitText">Konfirmasi Booking</span>
              </button>
            </div>
          </div>
        </div>

      </div>
    </form>
  </main>

  <!-- Script Configuration & Assets -->
  <script>
    window.KARTIMANS_CONFIG = {
      baseUrl: '<?= base_url(); ?>',
      csrfName: '<?= $this->security ? $this->security->get_csrf_token_name() : ''; ?>',
      csrfHash: '<?= $this->security ? $this->security->get_csrf_hash() : ''; ?>'
    };
  </script>
  <script src="<?= base_url('assets/js/booking.js?v=' . time()); ?>"></script>
</body>
</html>

              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </section>
