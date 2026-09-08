<style>
  /* Multiselect dropdown (tanpa library) */
  .ms-wrap { position: relative; font-family: inherit; }
  .ms-ctrl {
    display:flex; align-items:center; gap:.5rem;
    width:100%; min-height:38px; padding:.375rem .75rem;
    border:1px solid #ccc; border-radius:.35rem; background:#fff; cursor:pointer;
  }
  .ms-ctrl .ms-placeholder { color:#888; }
  .ms-caret {
    margin-left:auto; width:0; height:0;
    border-left:6px solid transparent; border-right:6px solid transparent; border-top:6px solid #555;
  }
  .ms-drop {
    position:absolute; left:0; right:0; z-index:9999;
    background:#fff; border:1px solid rgba(0,0,0,.15); border-radius:.35rem;
    box-shadow:0 .5rem 1rem rgba(0,0,0,.15);
    margin-top:.25rem; display:none;
  }
  .ms-list { max-height:220px; overflow:auto; padding:.25rem 0; }
  .ms-item { display:flex; gap:.5rem; align-items:center; padding:.375rem .75rem; }
  .ms-item:hover { background:#f6f7fb; }
  .ms-actions { display:flex; justify-content:space-between; padding:.5rem .75rem; border-top:1px solid #eee; background:#f6f7fb; position:sticky; bottom:0; }
  .ms-actions a { font-size:.875rem; text-decoration:none; }
  .ms-actions a:hover { text-decoration:underline; }
  .ms-badge {
    display:inline-flex; align-items:center; gap:.25rem;
    border:1px solid #e3e6f0; border-radius:999px;
    padding:.125rem .5rem; font-size:.75rem; background:#fafbff; margin:.125rem;
  }
</style>

<!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <div>
             <h1 class="h3 mb-0 text-gray-800">Pilih Layanan</h1>
             <p class="page-kicker mb-0">Kartimans Barbershop</p>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <!-- Form Basic -->
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Masukan Pesanan</h6>
                 </div>
                 <div class="card-body">
                     <form action="<?= base_url('element/pesan') ?>" method="POST" role="form">
                         <div class="form-group">
                             <label for="exampleInputPassword1">Kode</label>
                             <input type="text" class="form-control" value="<?= $kode ?>" name="kode" id="kode" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Username Pengguna</label>
                             <input type="text" class="form-control" value="<?php echo $_SESSION['username'] ?>" name="username" id="username" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Nama Pelanggan</label>
                             <input type="text" class="form-control" name="nama" id="nama">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Tanggal Booking</label>
                             <input type="date" class="form-control" name="tgl" id="tgl">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Waktu Booking</label>
                             <input type="time" class="form-control" name="waktu" id="waktu">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Jenis Pelayanan</label><br>
                             <div class="ms-wrap" id="ms-jenis">
                <div class="ms-ctrl" tabindex="0" aria-haspopup="listbox" aria-expanded="false">
                  <div class="ms-placeholder">Pilih jenis pelayanan…</div>
                  <div class="ms-selected" aria-live="polite"></div>
                  <div class="ms-caret"></div>
                </div>
                <div class="ms-drop" role="listbox" aria-multiselectable="true">
                  <div class="ms-list">
                    <?php foreach ($listdata as $key => $value):
                      $jenis = is_object($value) ? ($value->jenis ?? $value->id ?? $value->kode ?? $key)
                             : ($value['jenis'] ?? $value['id'] ?? $value['kode'] ?? $key);
                      $label = is_object($value) ? ($value->label ?? $value->nama ?? $value->title ?? $value->jenis ?? ('Item '.$key))
                             : ($value['label'] ?? $value['nama'] ?? $value['title'] ?? $value['jenis'] ?? ('Item '.$key));
                      $hargaRaw = is_object($value) ? ($value->harga ?? $value->harga_jual ?? $value->price ?? $value->nominal ?? null)
                                : ($value['harga'] ?? $value['harga_jual'] ?? $value['price'] ?? $value['nominal'] ?? null);
                      $hargaNum = is_null($hargaRaw) ? 0 : (int) preg_replace('/[^\d]/', '', (string) $hargaRaw);
                      $hargaFmt = number_format($hargaNum, 0, ',', '.');
                    ?>
                    <label class="ms-item">
                    <input type="checkbox" name="jenis[]" value="<?= htmlspecialchars($jenis, ENT_QUOTES) ?>">
                    <span><?= htmlspecialchars($label) ?></span>
                    <small class="text-muted ml-auto">Rp <?= $hargaFmt ?></small>
                    </label>
                    <?php endforeach; ?>
                  </div>
                  <div class="ms-actions">
                    <a href="#" data-action="select-all">Pilih semua</a>
                    <a href="#" data-action="clear">Bersihkan</a>
                  </div>
                </div>
              </div>
              <small class="form-text text-muted">Kamu bisa memilih lebih dari satu.</small>
            </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                 </div>
                </div>

         </div>
         <!---Container Fluid-->

         <script>
(function () {
  const wrap = document.getElementById('ms-jenis');
  if (!wrap) return;

  const ctrl = wrap.querySelector('.ms-ctrl');
  const drop = wrap.querySelector('.ms-drop');
  const list = wrap.querySelector('.ms-list');
  const placeholder = wrap.querySelector('.ms-placeholder');
  const selected = wrap.querySelector('.ms-selected');

  function openDrop() {
    drop.style.display = 'block';
    ctrl.setAttribute('aria-expanded', 'true');
    document.addEventListener('click', handleOutside);
  }
  function closeDrop() {
    drop.style.display = 'none';
    ctrl.setAttribute('aria-expanded', 'false');
    document.removeEventListener('click', handleOutside);
  }
  function toggleDrop() {
    if (drop.style.display === 'block') { closeDrop(); } else { openDrop(); }
  }
  function handleOutside(e) {
    if (!wrap.contains(e.target)) closeDrop();
  }

  ctrl.addEventListener('click', function (e) {
    e.preventDefault(); toggleDrop();
  });
  ctrl.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault(); toggleDrop();
    } else if (e.key === 'Escape') {
      closeDrop();
    }
  });

  function refreshBadges() {
    const checks = list.querySelectorAll('input[type="checkbox"]');
    const chosen = [];
    selected.innerHTML = '';
    checks.forEach(function (ch) {
      if (ch.checked) {
        const text = ch.nextElementSibling ? ch.nextElementSibling.textContent.trim() : ch.value;
        chosen.push(text);
        const badge = document.createElement('span');
        badge.className = 'ms-badge';
        badge.textContent = text;
        selected.appendChild(badge);
      }
    });
    placeholder.style.display = chosen.length ? 'none' : '';
  }

  list.addEventListener('change', refreshBadges);

  const selectAllBtn = wrap.querySelector('[data-action="select-all"]');
  const clearBtn = wrap.querySelector('[data-action="clear"]');

  selectAllBtn.addEventListener('click', function (e) {
    e.preventDefault();
    list.querySelectorAll('input[type="checkbox"]').forEach(function (ch) { ch.checked = true; });
    refreshBadges();
  });

  clearBtn.addEventListener('click', function (e) {
    e.preventDefault();
    list.querySelectorAll('input[type="checkbox"]').forEach(function (ch) { ch.checked = false; });
    refreshBadges();
  });

  // Inisialisasi (mis. saat form repopulate)
  refreshBadges();
})();
</script>