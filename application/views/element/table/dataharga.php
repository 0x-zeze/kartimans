 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <div>
             <h1 class="h3 mb-0 text-gray-800">Data Harga</h1>
             <p class="page-kicker mb-0">Kartimans Barbershop</p>
         </div>
         <a href="<?= base_url('element/form_tambah') ?>" class="btn btn-primary btn-sm btn-tambah-data">
             <i class="fas fa-plus"></i> Tambah Data
         </a>
     </div>
     <?php if ($msg = $this->session->flashdata('success')): ?>
         <div class="alert alert-success alert-dismissible fade show" role="alert">
             <?= $msg ?>
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
     <?php endif; ?>
     <?php
        if ($this->session->userdata('success')) {
            $this->session->unset_userdata('success');
        }
     ?>

     <div class="row">
         <div class="col-lg-12 mb-4">
             <!-- Data Harga -->
             <div class="card">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Data Harga</h6>
                 </div>
                 <div class="table-responsive p-3">
                    <table id="example1" class="table align-items-center table-flush">
                         <thead class="thead-light">
                             <tr>
                                 <th>Nomor</th>
                                 <th>Jenis</th>
                                 <th>Label</th>
                                 <th>Label Harga</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($listdata as $key => $value) {
                                $angka_murni = isset($value->data_harga)
                                    ? (int)$value->data_harga
                                    : (int)preg_replace('/\D/', '', (string)$value->harga);

                                $label_rp = 'Rp ' . number_format($angka_murni, 0, ',', '.');
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= html_escape($value->jenis) ?></td>
                                    <td><?= html_escape($value->label) ?></td>
                                    <td><?= $label_rp ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="<?= base_url('Element/edit_harga/' . $value->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="<?= base_url('Element/hapus_harga/' . $value->id) ?>" class="btn btn-danger btn-sm btn-delete">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
     <!--Row-->
 </div>
 <!---Container Fluid-->

<script>
  window.addEventListener('DOMContentLoaded', function () {
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (el) {
      setTimeout(function () {

        el.classList.remove('show');
        el.classList.add('fade');
        setTimeout(function () {
          if (el && el.parentNode) el.parentNode.removeChild(el);
        }, 300);
      }, 3000);
    });
  });
</script>

<!-- ====== Modal Tambah Data (Auto-Injected) ====== -->
<div class="modal fade" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('element/simpan') ?>" method="post" id="formTambahData" autocomplete="off" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahLabel">Tambah Jenis Layanan & Harga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="jenis_layanan">Jenis Layanan</label>
          <input type="text" name="nama" id="jenis_layanan" class="form-control" placeholder="Contoh: Haircut, Coloring" required>
        </div>
        <div class="form-group">
          <label for="harga_visible">Harga</label>
          <input type="text" id="harga_visible" class="form-control" placeholder="Rp 0">
          <input type="hidden" id="harga_hidden" name="harga_hidden" value="0">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
// Delegasi: cari tombol/anchor berlabel "Tambah Data" di tabel, buka modal
document.addEventListener('click', function(e){
  var el = e.target.closest('a,button');
  if (!el) return;
  var label = (el.textContent || '').trim().toLowerCase();
  if (label === 'tambah data') {
    e.preventDefault();
    // reset form
    var f = document.getElementById('formTambahData');
    if (f) f.reset();
    document.getElementById('harga_hidden').value = 0;
    document.getElementById('harga_visible').value = 'Rp 0';
    if (window.jQuery && $('#modalTambahData').modal) {
      $('#modalTambahData').modal('show');
    } else {
      // fallback sederhana jika tidak pakai Bootstrap JS
      document.getElementById('modalTambahData').style.display = 'block';
    }
  }
});

// Formatter rupiah realtime
(function(){
  var visible = document.getElementById('harga_visible');
  var hidden  = document.getElementById('harga_hidden');
  if (!visible || !hidden) return;
  var fmt = new Intl.NumberFormat('id-ID');
  function onlyDigits(s){ return (s || '').toString().replace(/[^\d]/g, ''); }
  visible.addEventListener('input', function(){
    var raw = onlyDigits(this.value);
    var n = parseInt(raw || '0', 10) || 0;
    hidden.value = n;
    this.value = 'Rp ' + fmt.format(n);
  });
  // init
  var n0 = parseInt(hidden.value || '0', 10) || 0;
  visible.value = 'Rp ' + fmt.format(n0);
})();
</script>

<script>
function confirmDelete(event, url) {
    event.preventDefault(); // cegah aksi langsung

    Swal.fire({
        title: 'Yakin mau menghapus?',
        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#cc1616',
        cancelButtonColor: '#6c6c6c',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // jalankan delete
        }
    })
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  .swal2-popup.custom-pop { border-radius: 12px; }
  .swal2-title.custom-title { font-size: 28px; font-weight: 700; color: #374151; }
  .swal2-html-container.custom-text { font-size: 16px; color: #6b7280; margin-top:.25rem; }
  .custom-icon{ width:86px;height:86px;margin:0 auto 10px;border-radius:9999px;border:4px solid #f59e0b;
    display:flex;align-items:center;justify-content:center;font-size:44px;font-weight:700;color:#f59e0b;}
  .swal2-actions{ gap:12px; }
  .swal2-styled.btn-confirm{ background:#cc1616;border:2px solid #a81212;color:#fff;border-radius:12px;padding:10px 16px;font-weight:600; }
  .swal2-styled.btn-cancel{ background:#6c6c6c;color:#fff;border-radius:12px;padding:10px 16px;font-weight:600; }
</style>

<script>
(function () {
  document.addEventListener('click', function (e) {
    // tangkap .btn-delete, .btn-pop-cancel, atau elemen yang punya data-confirm
    const el = e.target.closest('.btn-delete, .btn-pop-cancel, [data-confirm]');
    if (!el) return;

    e.preventDefault(); // tahan aksi default

    const title = el.dataset.title || 'Kartimans Barbershop';
    const text  = el.dataset.text  || 'Hapus data ini?';

    // ambil URL dari href atau data-*
    const href = el.getAttribute('href') || el.dataset.href || el.dataset.url || null;
    const form = el.closest('form'); // jika tombol berada di dalam form

    Swal.fire({
      width: '36rem',
      html: `<div class="custom-icon">!</div>`,
      title: title,
      didOpen: () => {
        const c = Swal.getHtmlContainer();
        const p = document.createElement('p');
        p.className = 'custom-text';
        p.textContent = text;
        c.appendChild(p);
      },
      iconHtml: '',
      showCancelButton: true,
      confirmButtonText: el.dataset.confirmText || 'Ya, hapus',
      cancelButtonText: el.dataset.cancelText || 'Batal',
      reverseButtons: true,
      focusCancel: true,
      customClass: { popup:'custom-pop', title:'custom-title', confirmButton:'btn-confirm', cancelButton:'btn-cancel' }
    }).then((res) => {
      if (!res.isConfirmed) return;
      if (form) { form.submit(); return; }   // versi POST/DELETE
      if (href) { window.location.assign(href); return; } // versi GET
      console.warn('Tidak ada href/form pada tombol konfirmasi.');
    });
  });
})();
</script>