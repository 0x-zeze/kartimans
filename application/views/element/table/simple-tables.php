 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <div>
             <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
             <p class="page-kicker mb-0">Kartimans Barbershop</p>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12 mb-4">
             <!-- Data Transaksi -->
             <div class="card">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
                 </div>
                 <div class="table-responsive">
                     <table id="example1" class="table table-bordered table-striped">
                         <thead class="thead-light">
                             <tr>
                                 <th>No</th>
                                 <th>Kode</th>
                                 <th>Nama</th>
                                 <th>Status</th>
                                 <th>Jenis Pelayanan</th>
                                 <th>Action</th>
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
                                     <td><a href="<?= base_url('Element/detail_transaksi/' . $value->kode) ?>" class="btn btn-sm btn-primary">Detail</a>
                                         <a href="<?= base_url('Element/berhasildata/' . $value->kode) ?>" class="btn btn-sm btn-success">Berhasil</a>
                                         <a href="<?= base_url('Element/canceldata/' . $value->kode) ?>" class="btn btn-sm btn-danger">Cancel</a>
                                     </td>
                                 </tr>
                             <?php
                                }
                                ?>
                         </tbody>
                     </table>
                 </div>
                 <div class="card-footer"></div>
             </div>
         </div>
     </div>
     <!--Row-->
 </div>
 <!---Container Fluid-->