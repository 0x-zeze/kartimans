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
                 <div class="table-responsive p-3">
                     <table id="example1" class="table align-items-center table-flush">
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
                                    $status = strtoupper(trim((string) $value->status));
                                    $badge = 'badge-secondary';
                                    if ($status === 'BERHASIL') {
                                        $badge = 'badge-dark';
                                    } elseif ($status === 'CANCEL') {
                                        $badge = 'badge-danger';
                                    } elseif ($status === 'PESAN') {
                                        $badge = 'badge-light';
                                    }
                                ?>
                                 <tr>
                                     <td><?= $no++ ?></td>
                                     <td><?= html_escape($value->kode) ?></td>
                                     <td><?= html_escape($value->nama) ?></td>
                                     <td><span class="badge <?= $badge ?>"><?= html_escape($value->status) ?></span></td>
                                     <td><?= html_escape($value->jenis) ?></td>
                                     <td>
                                         <div class="table-actions">
                                             <a href="<?= base_url('Element/detail_transaksi/' . $value->kode) ?>" class="btn btn-sm btn-light">Detail</a>
                                             <a href="<?= base_url('Element/berhasildata/' . $value->kode) ?>" class="btn btn-sm btn-success">Berhasil</a>
                                             <a href="<?= base_url('Element/canceldata/' . $value->kode) ?>" class="btn btn-sm btn-danger">Cancel</a>
                                         </div>
                                     </td>
                                 </tr>
                             <?php
                                }
                                ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
     <!--Row-->
 </div>
 <!---Container Fluid-->