 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <div>
             <h1 class="h3 mb-0 text-gray-800">Edit Harga</h1>
             <p class="page-kicker mb-0">Kartimans Barbershop</p>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 </div>
                 <div class="card-body">
                     <form action="<?= base_url('element/edit_harga/'. $brg_masuk->id) ?>" method="POST" role="form">
                         <div class="form-group">
                             <label for="exampleInputPassword1">ID</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->id ?>" name="kode" id="kode" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Jenis</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->jenis ?>" name="nama" id="nama" readonly>
                         </div>
                        <div class="form-group">
                            <label for="harga_label">Harga (Rp)</label>
                            <input type="text"
                                   class="form-control"
                                   id="harga_label"
                                   name="label_harga"
                                   value="<?= number_format((int)$brg_masuk->data_harga, 0, ',', '.') ?>">
                        </div>
                        <input type="hidden" id="harga" name="harga" value="<?= (int)$brg_masuk->data_harga ?>">
                         <button type="submit" class="btn btn-success">UPDATE</button>
                         <a type="submit" href="javascript:window.history.go(-1);" class="btn btn-primary">Kembali </a>
                     </form>
                 </div>
             </div>

         </div>
         <!---Container Fluid-->

         <script>

(function () {
  const vis = document.getElementById('harga_label');
  const hid = document.getElementById('harga');

  function formatRupiah(nStr) {
    let s = nStr.replace(/\D/g, '');            
    if (!s) { hid.value = ''; return ''; }
    hid.value = s; // angka murni untuk DB
    return s.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  // init
  vis.value = formatRupiah(vis.value);

  vis.addEventListener('input', function() {
    const caret = vis.selectionStart;
    const beforeLen = vis.value.length;
    vis.value = formatRupiah(vis.value);
    const afterLen = vis.value.length;
    const diff = afterLen - beforeLen;
    vis.setSelectionRange(caret + diff, caret + diff);
  });
})();
</script>