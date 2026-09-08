<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('element/simpan') ?>" method="post" id="formTambahData" autocomplete="off" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahLabel">Tambah Jenis Layanan & Harga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Jenis Layanan -->
        <div class="form-group">
          <label for="jenis_layanan">Jenis Layanan</label>
          <input type="text" name="nama" id="jenis_layanan" class="form-control" placeholder="Contoh: Haircut, Coloring" required>
        </div>

        <!-- Harga (format rupiah otomatis) -->
        <div class="form-group">
          <label for="harga_visible">Harga</label>
          <input type="text" id="harga_visible" class="form-control" placeholder="Rp 0">
          <input type="hidden" id="harga_hidden" name="harga_hidden" value="0">
          <small class="text-muted">Ketik angka saja, sistem memformat otomatis ke Rupiah.</small>
        </div>

        <!-- (opsional) status / username dsb -->
        <!-- <input type="hidden" name="status" value="Aktif"> -->
        <!-- <input type="hidden" name="username" value="<?= $this->session->userdata('username') ?>"> -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
// Buka modal saat tombol 'Tambah Data' diklik (di baris mana pun)
document.addEventListener('click', function(e){
  if (e.target.closest('.btn-tambah-data')) {
    // reset form setiap kali buka
    document.getElementById('formTambahData').reset();
    // reset hidden harga
    document.getElementById('harga_hidden').value = 0;
    document.getElementById('harga_visible').value = 'Rp 0';
    $('#modalTambahData').modal('show');
  }
});

// Format Rupiah realtime
(function(){
  const visible = document.getElementById('harga_visible');
  const hidden  = document.getElementById('harga_hidden');
  const fmt = new Intl.NumberFormat('id-ID');
  const onlyDigits = s => (s || '').toString().replace(/[^\d]/g, '');

  if (visible) {
    visible.addEventListener('input', function(){
      const raw = onlyDigits(this.value);
      const n = parseInt(raw || '0', 10) || 0;
      hidden.value = n;
      this.value = 'Rp ' + fmt.format(n);
    });
    // init
    visible.value = 'Rp ' + fmt.format(parseInt(hidden.value || '0', 10) || 0);
  }
})();
</script>