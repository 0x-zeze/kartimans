<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="page-kicker">Kartimans Barbershop</p>
        </div>
    </div>

    <?php if ($msg = $this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-autohide="3000">
            <?= html_escape($msg) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <?php $level = $this->session->userdata('level'); ?>
        <?php if($level == "1" || $level == "2" || $level == "3") : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 stat-label">Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo $pendapatan->harga ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 stat-label">Total Penjualan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $penjualan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 stat-label">Total Pengguna</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $pengguna ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 stat-label">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pending ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Pie Chart -->
        <!-- Invoice Example -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Invoice</h6>
                </div>
                <div class="table-responsive">
                <?php if($level == "1" || $level == "2" || $level == "3") : ?>
                    <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                             <tr>
                                 <th>No</th>
                                 <th>Kode</th>
                                 <th>Nama</th>
                                 <th>Status</th>
                                 <th>Jenis Pelayanan</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($listdata as $key => $value) {
                                ?>
                                 <tr>
                                     <td><a href="#"><?= $no++ ?></a></td>
                                     <td><?= $value->kode ?></td>
                                     <td><?= $value->nama ?></td>
                                     <td><?= $value->status ?></td>
                                     <td><?= $value->jenis ?></td>
                                 </tr>
                             <?php
                                }
                                ?>
                         </tbody>
                     </table>
                     <?php endif; ?>


                     <?php if($level == "4") : ?>
<table class="table align-items-center table-flush" id="invoice-table-level4">
  <thead class="thead-light">
    <tr>
      <th>No</th>
      <th>Kode</th>
      <th>Nama</th>
      <th>Status</th>
      <th>Jenis Pelayanan</th>
      <th>Tanggal</th>
      <th>Jam</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; foreach ($listdatapel as $key => $value): ?>
    <tr id="row-<?= html_escape($value->kode) ?>">
      <td><a href="#"><?= $no++ ?></a></td>
      <td><?= html_escape($value->kode) ?></td>
      <td><?= html_escape($value->nama) ?></td>
      <td><?= html_escape($value->status) ?></td>
      <td><?= html_escape($value->jenis) ?></td>
      <td><?= !empty($value->tanggal_pesan) ? date('d/m/Y', strtotime($value->tanggal_pesan)) : '-' ?></td>
      <td><?= !empty($value->waktu_booking) ? date('H:i', strtotime($value->waktu_booking)) : '-' ?></td>
      <td>
        <?php if($value->status === 'PESAN'): ?>
          <button type="button" class="btn btn-sm btn-danger btn-cancel" data-kode="<?= html_escape($value->kode) ?>">Cancel</button>
          <noscript>
            <a href="<?= base_url('element/canceldata/'.rawurlencode($value->kode)) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Batalkan pesanan ini?')">Cancel</a>
          </noscript>
        <?php else: ?>
          <span class="badge badge-secondary">-</span>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>


                </div>
                <div class="card-footer"></div>
            </div>
        </div>
        <!-- Message From Customer-->
        <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Jasa</h6>
                </div>
                <div class="card-body jasa-card-body">
                    <div class="jasa-grid">
                        <div class="jasa-item">
                            <div class="icon">
                                <svg class="service-icon" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
                                    <path d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zM19 3l-6 6 2 2 7-7V3z"/>
                                </svg>
                            </div>
                            <h3>Haircut (Keramas, Hair Tonic, Styling, Hot Towel)</h3>
                        </div>
                        <div class="jasa-item">
                            <div class="icon">
                                <svg class="service-icon" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
                                    <path d="M7 14c-1.66 0-3 1.34-3 3 0 1.31-1.16 2-2 2 .92 1.22 2.49 2 4 2 2.21 0 4-1.79 4-4 0-1.66-1.34-3-3-3zm13.71-9.37-1.34-1.34c-.39-.39-1.02-.39-1.41 0L9 12.25 11.75 15l8.96-8.96c.39-.39.39-1.02 0-1.41z"/>
                                </svg>
                            </div>
                            <h3>Basic Coloring</h3>
                        </div>
                        <div class="jasa-item">
                            <div class="icon">
                                <svg class="service-icon" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
                                    <path d="M5 2h14a1 1 0 0 1 1 1v3H4V3a1 1 0 0 1 1-1z"/>
                                    <path d="M5.25 7h1.9v14.2a.95.95 0 1 1-1.9 0V7zm3.85 0h1.9v14.2a.95.95 0 1 1-1.9 0V7zm3.85 0h1.9v14.2a.95.95 0 1 1-1.9 0V7zm3.85 0h1.9v14.2a.95.95 0 1 1-1.9 0V7z"/>
                                </svg>
                            </div>
                            <h3>Bleaching</h3>
                        </div>
                        <div class="jasa-item">
                            <div class="icon">
                                <svg class="service-icon" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
                                    <path d="M3.5 3.25h17a1.25 1.25 0 0 1 0 2.5h-.75v1.5a1 1 0 0 1-1 1h-4.5V11H16a1 1 0 0 1 1 1v7.25a3 3 0 0 1-6 0V12a1 1 0 0 1 1-1h1.75V8.25h-4.5a1 1 0 0 1-1-1v-1.5h-.75a1.25 1.25 0 0 1 0-2.5z"/>
                                </svg>
                            </div>
                            <h3>Shaving</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->
</div>
<!---Container Fluid-->




    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="swal-cancel-script">
    (function(){
      if (window.__swalCancelBound) return; // avoid double-binding
      window.__swalCancelBound = true;
      var tokenName = "<?= isset($this->security) ? $this->security->get_csrf_token_name() : '' ?>";
      var tokenVal  = "<?= isset($this->security) ? $this->security->get_csrf_hash() : '' ?>";

      function extractKode(el){
        if (!el) return null;
        var node = el;
        while (node && node !== document){
          if (node.dataset && node.dataset.kode) return node.dataset.kode;
          node = node.parentElement;
        }
        var tr = el.closest && el.closest('tr');
        if (tr && tr.id && tr.id.indexOf('row-') === 0) return tr.id.slice(4);
        var a = el.closest && el.closest('a');
        if (a && a.href){
          var m = a.href.match(/canceldata\/([^\/?#]+)/i);
          if (m) return decodeURIComponent(m[1]);
        }
        return null;
      }

      document.addEventListener('click', async function(ev){
        var btn = ev.target.closest && ev.target.closest('#invoice-table-level4 .btn-cancel');
        if (!btn) return;

        var kode = extractKode(btn);
        if (!kode) return;

        ev.preventDefault();
        ev.stopPropagation();

        try{
          var ask = await Swal.fire({
            title: 'Kartimans Barbershop',
            text: 'Batalkan pesanan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, batalkan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            confirmButtonColor: '#cc1616',
            cancelButtonColor: '#6c6c6c'
          });
          if (!ask.isConfirmed) return;

          var body = '';
          if (tokenName && tokenVal){
            body = encodeURIComponent(tokenName) + '=' + encodeURIComponent(tokenVal);
          }

          var url = "<?= site_url('element/canceldata/') ?>" + encodeURIComponent(kode);
          var res = await fetch(url, {
            method: 'POST',
            headers: {
              'X-Requested-With':'XMLHttpRequest',
              'Content-Type':'application/x-www-form-urlencoded'
            },
            body: body
          });

          // ---- tolerant success detection ----
          var okFlag = false;
          var rawText = '';
          try { rawText = await res.text(); } catch(e) { rawText = ''; }
          // Try JSON
          try {
            var j = rawText ? JSON.parse(rawText) : null;
            if (j && (j.ok === true || j.ok === 1 || j.status === 'ok')) okFlag = true;
          } catch(e) {}
          // Fallbacks (empty 200/204, '1', 'ok', 'success', redirected after update)
          if (!okFlag) {
            var t = (rawText || '').trim().toLowerCase();
            if ((res.ok && (t === '' || res.status === 204)) ||
                t === 'ok' || t === '1' || t === 'true' || t === 'success') {
              okFlag = true;
            }
          }
          if (!okFlag && res.redirected) okFlag = true;

          if (okFlag){
            var row = document.getElementById('row-' + kode) || btn.closest('tr');
            if (row && row.parentNode) row.parentNode.removeChild(row);
            var table = btn.closest('table');
            var rows = (table ? table.querySelectorAll('tbody tr') : document.querySelectorAll('tbody tr'));
            rows.forEach(function(r, i){
              var firstCell = r.querySelector('td');
              if (firstCell) firstCell.textContent = (i + 1);
            });
            Swal.fire({title:'Dibatalkan', text:'Pesanan berhasil dibatalkan.', icon:'success', timer:1500, showConfirmButton:false});
          } else {
            Swal.fire('Gagal', 'Tidak dapat membatalkan pesanan.', 'error');
          }
        }catch(err){
          Swal.fire('Error', 'Kesalahan jaringan.', 'error');
        }
      }, true);
    })();
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function(){
  var table = document.getElementById('invoice-table-level4');
  if (!table) return;
  var rows = table.querySelectorAll('tbody tr');
  rows.forEach(function(r){
    var statusCell = r.querySelector('td:nth-child(4)');
    if (statusCell && statusCell.textContent.trim().toUpperCase() === 'CANCEL'){
      r.parentNode.removeChild(r);
    }
  });
  var remaining = table.querySelectorAll('tbody tr');
  remaining.forEach(function(r,i){
    var first = r.querySelector('td');
    if (first) first.textContent = i + 1;
  });
});
</script>
