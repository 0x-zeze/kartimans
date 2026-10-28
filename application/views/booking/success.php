<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= html_escape($title); ?></title>

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/kartimans1.png'); ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Fonts & Bootstrap Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">

  <!-- Booking Custom CSS -->
  <link href="<?= base_url('assets/css/booking.css?v=' . time()); ?>" rel="stylesheet">
</head>
<body class="booking-body">

  <header class="booking-navbar">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        <a href="<?= base_url(); ?>" class="brand-logo">
          <img src="<?= base_url('assets/img/kartimans1.png'); ?>" alt="The Kartimans Haircut Logo">
          <span>KARTIMANS</span>
        </a>
        <a href="<?= base_url(); ?>" class="btn-nav-back">
          <i class="bi bi-house"></i>
          <span>Beranda</span>
        </a>
      </div>
    </div>
  </header>

  <main class="container py-4">
    <div class="voucher-card">
      <div class="success-icon-badge">
        <i class="bi bi-check-lg"></i>
      </div>

      <h1 class="h3 fw-bold mb-1">Booking Berhasil!</h1>
      <p class="text-muted small mb-3">Jadwal cukurmu sudah resmi terdaftar di sistem Kartimans.</p>

      <div class="voucher-code-wrap">
        <span class="voucher-code-label">Kode Booking</span>
        <span class="voucher-code-val"><?= html_escape($booking->kode); ?></span>
      </div>

      <div class="text-start bg-light p-3 rounded-3 mb-4" style="border: 1px solid var(--km-border);">
        <div class="d-flex justify-content-between mb-2 pb-1 border-bottom">
          <span class="text-muted small">Status Reservasi</span>
          <span class="badge bg-warning-subtle text-dark px-2 py-1" style="font-size:0.78rem;">
            <?= html_escape($booking->status); ?> (Terkonfirmasi)
          </span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted small">Nama Pelanggan</span>
          <span class="fw-semibold small"><?= html_escape($booking->nama); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted small">Layanan</span>
          <span class="fw-semibold small"><?= html_escape($booking->jenis); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted small">Barber</span>
          <span class="fw-semibold small"><?= html_escape($booking->barber ?: 'Bagus Pamungkas'); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted small">Tanggal</span>
          <span class="fw-semibold small"><?= date('d F Y', strtotime($booking->tanggal_pesan)); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted small">Waktu Booking</span>
          <span class="fw-semibold small text-primary"><?= html_escape($booking->waktu_booking); ?> WIB</span>
        </div>
        <div class="d-flex justify-content-between pt-2 border-top">
          <span class="fw-bold small">Total Pembayaran</span>
          <span class="fw-bold text-success">Rp <?= number_format((float)$booking->harga, 0, ',', '.'); ?></span>
        </div>
      </div>

      <?php
        $wa_msg = urlencode("Halo The Kartimans Haircut, saya ingin konfirmasi booking saya:\n" .
          "- Kode: " . $booking->kode . "\n" .
          "- Nama: " . $booking->nama . "\n" .
          "- Layanan: " . $booking->jenis . "\n" .
          "- Barber: " . ($booking->barber ?: 'Bagus Pamungkas') . "\n" .
          "- Tanggal: " . $booking->tanggal_pesan . "\n" .
          "- Jam: " . $booking->waktu_booking . " WIB");
      ?>

      <div class="d-grid gap-2">
        <a href="https://wa.me/62882005518510?text=<?= $wa_msg; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success fw-bold py-2 d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-whatsapp"></i> Konfirmasi via WhatsApp
        </a>
        <a href="<?= base_url('booking'); ?>" class="btn btn-outline-secondary py-2">
          Buat Booking Baru
        </a>
      </div>

      <small class="text-muted d-block mt-3" style="font-size:0.75rem;">
        *Silakan simpan atau screenshot bukti booking ini saat tiba di gerai Kartimans.
      </small>
    </div>
  </main>

</body>
</html>
