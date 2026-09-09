<?php
/**
 * charts_patched.php
 * Laporan Pendapatan Bulanan (TRANSAKSI BERHASIL saja) + Export PNG
 * Perbaikan: deteksi kolom "Nama layanan" lebih cerdas (prioritaskan kolom layanan/service, hindari kolom nama customer/user).
 */

// ====================== KONFIGURASI DASAR ======================
$TABLE_NAME     = isset($TABLE_NAME)    ? $TABLE_NAME    : 'jasa';      // nama tabel transaksi/jasa
$DATE_COLUMN    = isset($DATE_COLUMN)   ? $DATE_COLUMN   : 'tanggal';   // kolom tanggal (DATE/DATETIME)
$AMOUNT_COLUMN  = isset($AMOUNT_COLUMN) ? $AMOUNT_COLUMN : 'harga';     // kolom jumlah/pendapatan (numeric)

// Override manual (opsional): isi nama kolom layanan jika mau paksa pakai kolom tertentu
$SERVICE_COLUMN_OVERRIDE = isset($SERVICE_COLUMN_OVERRIDE) ? $SERVICE_COLUMN_OVERRIDE : '';

// Identitas usaha untuk header laporan
$LOGO_URL   = isset($LOGO_URL)   ? $LOGO_URL   : (function_exists('base_url') ? base_url('assets/img/kartimans1.png') : 'assets/img/kartimans1.png');
$SHOP_NAME  = isset($SHOP_NAME)  ? $SHOP_NAME  : 'Kartimans Barbershop';
$SHOP_ADDR  = isset($SHOP_ADDR)  ? $SHOP_ADDR  : 'Karangkobar, Purwanegara, Purwokerto Timur, Banyumas, Jawa Tengah 53116';
$OWNER_NAME = isset($OWNER_NAME) ? $OWNER_NAME : 'Bagus Pamungkas';

// Daftar kandidat kolom untuk STATUS (otomatis pilih yang ada)
$STATUS_COLUMNS_CANDIDATE = ['status','payment_status','pembayaran_status','trx_status','state'];
$SUCCESS_VALUES           = ['success','paid','settled','berhasil','lunas','completed','complete']; // nilai status sukses (lowercase)

// Ambil parameter bulan (YYYY-MM). Default: bulan berjalan
$month = isset($_GET['month']) && preg_match('/^\d{4}-\d{2}$/', $_GET['month']) ? $_GET['month'] : date('Y-m');
$startDate = $month . '-01';
$endDate   = date('Y-m-t', strtotime($startDate)); // hari terakhir di bulan tsb

// ====================== HELPER ======================
function ci_db_instance_or_null() {
  if (function_exists('get_instance')) {
    $ci = @get_instance();
    if ($ci && isset($ci->db)) return $ci->db;
  }
  return null;
}
$this->db->query("SET time_zone = '+07:00'");
function list_fields_safe($db, $table) {
  $cols = [];
  if ($db) {
    if (method_exists($db, 'list_fields')) {
      $cols = $db->list_fields($table);
    } else {
      try {
        $q = $db->query("SHOW COLUMNS FROM `{$table}`");
        foreach ($q->result_array() as $r) $cols[] = $r['Field'];
      } catch (\Throwable $e) {}
    }
  }
  return $cols;
}
function pick_status_column($available, $candidates){
  foreach ($candidates as $c) if (in_array($c, $available, true)) return $c;
  return null;
}
function pick_service_column($available, $override=''){
  if ($override && in_array($override, $available, true)) return $override;

  // Skor preferensi untuk kolom yang mengindikasikan "layanan"
  $prefer = ['layanan'=>100,'service'=>95,'jenis'=>90,'paket'=>85,'category'=>80,'tipe'=>75,'produk'=>70];
  $avoid  = ['nama'=>-200,'customer'=>-180,'pelanggan'=>-180,'user'=>-170,'username'=>-170,'member'=>-160,'client'=>-150,'buyer'=>-150];

  $winner = null; $best = -99999;
  foreach ($available as $col) {
    $lc = strtolower($col);
    $score = 0;
    foreach ($prefer as $k=>$v) { if (strpos($lc, $k)!==false) $score += $v; }
    foreach ($avoid  as $k=>$v) { if (strpos($lc, $k)!==false) $score += $v; }
    if (preg_match('/(_id|id_)$/', $lc)) $score -= 40; // kemungkinan FK, turunkan skor
    if ($score > $best) { $best = $score; $winner = $col; }
  }

  if ($best < 10) return null; // terlalu lemah, kemungkinan salah kolom
  return $winner;
}
function rupiah($n) {
  if (!is_numeric($n)) $n = 0;
  return number_format((float)$n, 0, ',', '.');
}

// ====================== AMBIL DATA ======================
$rows = [];
$error = null;

$db = ci_db_instance_or_null();
if ($db) {
  try {
    $table = method_exists($db, 'dbprefix') ? $db->dbprefix($TABLE_NAME) : $TABLE_NAME;

    // cek kolom yang tersedia
    $available = list_fields_safe($db, $table);
    $statusCol = pick_status_column($available, $STATUS_COLUMNS_CANDIDATE);
    $serviceCol= pick_service_column($available, $SERVICE_COLUMN_OVERRIDE);

    // build filter tanggal & status
    $db->where("DATE(`{$DATE_COLUMN}`) >=", $startDate);
    $db->where("DATE(`{$DATE_COLUMN}`) <=", $endDate);
    if ($statusCol) {
      $caseExpr = "LOWER(`{$statusCol}`)";
      $db->where("(" . implode(' OR ', array_map(function($v) use ($caseExpr){
        return "{$caseExpr} = " . "'" . strtolower($v) . "'";
      }, $SUCCESS_VALUES)) . ")", null, false);
    }

    // select
    $selectCols = [
      "`{$DATE_COLUMN}` as tgl",
      "`{$AMOUNT_COLUMN}` as nominal",
    ];
    if ($serviceCol) {
      $selectCols[] = "`{$serviceCol}` as layanan";
    } else {
      $selectCols[] = "'' as layanan";
    }
    $db->select(implode(',', $selectCols), false);
    $db->from($table);
    $db->order_by("DATE(`{$DATE_COLUMN}`)", "ASC");

    $q = $db->get();
    foreach ($q->result_array() as $r) {
      $rows[] = [
        'tgl'     => $r['tgl'],
        'layanan' => isset($r['layanan']) ? $r['layanan'] : '',
        'harga'   => (float)$r['nominal'],
      ];
    }
  } catch (\Throwable $e) {
    $error = $e->getMessage();
  }

} else {
  // Fallback PDO (opsional)
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=database;charset=utf8mb4', 'user', 'pass', [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $colsStmt = $pdo->prepare("SHOW COLUMNS FROM `{$TABLE_NAME}`");
    $colsStmt->execute();
    $available = array_map(function($r){ return $r['Field']; }, $colsStmt->fetchAll(PDO::FETCH_ASSOC));

    $statusCol = pick_status_column($available, $STATUS_COLUMNS_CANDIDATE);
    $serviceCol= pick_service_column($available, $SERVICE_COLUMN_OVERRIDE);

    $where = "DATE(`{$DATE_COLUMN}`) BETWEEN :start AND :end";
    $params = [':start' => $startDate, ':end' => $endDate];
    if ($statusCol) {
      $lowerList = implode(",", array_map(function($v){ return "'" . strtolower($v) . "'"; }, $SUCCESS_VALUES));
      $where .= " AND LOWER(`{$statusCol}`) IN ({$lowerList})";
    }

    $select = "`{$DATE_COLUMN}` AS tgl, `{$AMOUNT_COLUMN}` AS nominal";
    $select .= $serviceCol ? ", `{$serviceCol}` AS layanan" : ", '' AS layanan";

    $sql = "SELECT {$select} FROM `{$TABLE_NAME}` WHERE {$where} ORDER BY DATE(`{$DATE_COLUMN}`) ASC";
    $st = $pdo->prepare($sql);
    $st->execute($params);
    while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
      $rows[] = [
        'tgl'     => $r['tgl'],
        'layanan' => isset($r['layanan']) ? $r['layanan'] : '',
        'harga'   => (float)$r['nominal'],
      ];
    }
  } catch (\Throwable $e) {
    $error = $e->getMessage();
  }
}

// Hitung total
$total = 0;
foreach ($rows as $r) $total += (float)$r['harga'];

// Nama Bulan (Indonesia)
$namaBulanIndo = [
  '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
  '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
  '07' => 'Juli',    '08' => 'Agustus',  '09' => 'September',
  '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];
$mNum = date('m', strtotime($startDate));
$yNum = date('Y', strtotime($startDate));
$bulanNama = (isset($namaBulanIndo[$mNum]) ? $namaBulanIndo[$mNum] : date('F', strtotime($startDate))) . ' ' . $yNum;
?>

<!-- Container Fluid -->
<div class="container-fluid" id="container-wrapper">
  <!-- Page Header & Action Bar -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
      <p class="page-kicker mb-0">Kartimans Barbershop</p>
    </div>

    <!-- Toolbar Filter & Tombol Export PNG -->
    <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-sm-0">
      <form method="get" id="monthForm" class="form-inline mr-2">
        <label for="monthInput" class="mr-2 text-xs font-weight-bold text-gray-600 d-none d-md-inline">Periode:</label>
        <input type="month" id="monthInput" name="month" class="form-control form-control-sm" value="<?= htmlspecialchars($month) ?>" style="border-radius: 8px; font-size: 13px; height: 36px;" onchange="this.form.submit();">
      </form>
      <button type="button" class="btn btn-sm btn-primary" id="btnExportPNG" style="background-color: #cc1616; border-color: #cc1616; font-weight: 600; border-radius: 8px; padding: 6px 14px; height: 36px; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fas fa-file-download"></i> Export PNG
      </button>
    </div>
  </div>

  <!-- Wrapper Lembar Dokumen Laporan -->
  <div class="row justify-content-center">
    <div class="col-12 col-xl-11">
      <div class="report-paper-wrapper">
        <div class="print-card" id="monthlyReportCard">
          <!-- Kop Laporan -->
          <div class="print-header">
            <img src="<?= htmlspecialchars($LOGO_URL) ?>" alt="Logo Kartimans">
            <div class="title-wrap">
              <h3 class="shop-name"><?= htmlspecialchars($SHOP_NAME) ?></h3>
              <div class="shop-addr"><?= htmlspecialchars($SHOP_ADDR) ?></div>
              <div class="shop-currency">(Dalam Rp)</div>
            </div>
          </div>

          <!-- Periode Bulan (Teks murni, tanpa kontrol/tombol) -->
          <div class="header-meta">
            <div class="bulan">Bulan: <?= htmlspecialchars($bulanNama) ?></div>
          </div>

      <table class="report-table">
        <thead>
          <tr>
            <th style="width:56px">No</th>
            <th style="width:140px">Tanggal</th>
            <th>Nama Layanan</th>
            <th style="width:140px">Harga</th>
            <th style="width:180px">Pendapatan</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($error): ?>
          <tr><td colspan="5">Error: <?= htmlspecialchars($error) ?></td></tr>
        <?php elseif (empty($rows)): ?>
          <tr><td colspan="5">Tidak ada transaksi berhasil di bulan ini.</td></tr>
        <?php else: ?>
          <?php $no=1; foreach ($rows as $r): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars(date('Y-m-d', strtotime($r['tgl']))) ?></td>
              <td><?= htmlspecialchars($r['layanan'] ?: '-') ?></td>
              <td style="text-align:right"><?= rupiah($r['harga']) ?></td>
              <td style="text-align:right"><?= rupiah($r['harga']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" style="text-align:left">Jumlah</th>
            <th style="text-align:right"><?= rupiah($total) ?></th>
          </tr>
        </tfoot>
      </table>

      <div class="signature-row">
        <div class="sig-box">
          <div class="sig-name"><?= htmlspecialchars($OWNER_NAME) ?></div>
          <img class="sig-img" src="<?= function_exists('base_url') ? base_url('assets/img/ttd.png') : 'assets/img/ttd.png' ?>" alt="Tanda tangan">
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!---Container Fluid closed by _layout/footer.php-->

<style>
  .report-paper-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 2.5rem;
  }
  .print-card {
    background: #ffffff;
    width: 100%;
    max-width: 980px;
    padding: 32px 36px 28px 36px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    color: #111827;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  }
  .print-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 8px;
  }
  .print-header img {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }
  .title-wrap .shop-name {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    line-height: 1.25;
  }
  .title-wrap .shop-addr {
    font-size: 13px;
    color: #64748b;
    margin-top: 3px;
    line-height: 1.35;
  }
  .title-wrap .shop-currency {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-top: 2px;
  }
  .header-meta {
    margin: 12px 0 14px 0;
  }
  .header-meta .bulan {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
  }
  .report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
    color: #111827;
  }
  .report-table th,
  .report-table td {
    border: 1px solid #e5e7eb;
    padding: 9px 12px;
    vertical-align: middle;
  }
  .report-table thead th {
    background-color: #f8fafc;
    font-weight: 600;
    color: #111827;
  }
  .report-table tfoot th {
    background-color: #f8fafc;
    color: #111827;
  }
  .signature-row {
    display: flex;
    justify-content: flex-end;
    margin-top: 24px;
  }
  .sig-box {
    width: 220px;
    text-align: center;
  }
  .sig-name {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 6px;
  }
  .sig-img {
    height: 66px;
    width: auto;
    object-fit: contain;
    display: block;
    margin: 0 auto;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
  document.getElementById('btnExportPNG').addEventListener('click', function(e) {
    e.preventDefault();
    var btn = this;
    var originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengekspor...';
    btn.disabled = true;

    var node = document.getElementById('monthlyReportCard');

    html2canvas(node, {
      scale: 2,
      useCORS: true,
      backgroundColor: '#ffffff',
      logging: false,
      onclone: function(clonedDoc) {
        var card = clonedDoc.getElementById('monthlyReportCard');
        if (card) {
          card.style.borderRadius = '0px';
          card.style.boxShadow = 'none';
          card.style.border = 'none';
          card.style.padding = '36px 40px 32px 40px';
          card.style.width = '960px';
          card.style.maxWidth = '960px';
          card.style.margin = '0 auto';
          card.style.backgroundColor = '#ffffff';
        }
      }
    }).then(function(canvas) {
      var link = document.createElement('a');
      var yymm = "<?= preg_replace('/[^0-9\-]/','',$month) ?>".replace('-', '_');
      link.download = 'Laporan_Bulanan_' + yymm + '.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
      btn.innerHTML = originalHtml;
      btn.disabled = false;
    }).catch(function(err) {
      console.error('Export PNG failed:', err);
      alert('Gagal mengekspor laporan: ' + err.message);
      btn.innerHTML = originalHtml;
      btn.disabled = false;
    });
  });
</script>
