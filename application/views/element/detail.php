 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <div>
             <h1 class="h3 mb-0 text-gray-800">Detail Pesanan</h1>
             <p class="page-kicker mb-0">Kartimans Barbershop</p>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 </div>
                 <div class="card-body">
                     <form action="<?= base_url('element/form') ?>" method="POST" role="form">
                         <div class="form-group">
                             <label for="exampleInputPassword1">Kode</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->kode ?>" name="kode" id="kode" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Nama Pelanggan</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->nama ?>" name="nama" id="nama" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Tanggal Layanan</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->time ?>" name="tgl" id="tgl" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Jenis Layanan</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->jenis ?>" name="jenis" id="jenis" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Status</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->status ?>" name="jenis" id="jenis" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Total Harus Dibayarkan</label>
                             <input type="text" class="form-control" 
                                value="Rp <?= number_format($brg_masuk->harga, 0, ',', '.') ?>" 
                                name="total" id="total" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Waktu Booking</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->waktu_booking ?>" name="jenis" id="jenis" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Tanggal Booking</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->tanggal_pesan ?>" name="jenis" id="jenis" readonly>
                         </div>
                         <a type="submit" href="javascript:window.history.go(-1);" class="btn btn-primary">Kembali </a>
                     </form>
                 </div>
             </div>

         </div>
         <!---Container Fluid-->