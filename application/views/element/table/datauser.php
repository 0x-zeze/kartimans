 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <div>
             <h1 class="h3 mb-0 text-gray-800">Data User</h1>
             <p class="page-kicker mb-0">Kartimans Barbershop</p>
         </div>
     </div>
     <?php if ($msg = $this->session->flashdata('success')): ?>
         <div class="alert alert-success alert-dismissible fade show" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?= html_escape($msg) ?>
         </div>
     <?php endif; ?>

     <div class="row">
         <div class="col-lg-12 mb-4">
             <!-- Data User -->
             <div class="card">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                 </div>
                 <div class="table-responsive p-3">
                     <table id="example1" class="table align-items-center table-flush">
                         <thead class="thead-light">
                             <tr>
                                 <th>Nomor</th>
                                 <th>Username</th>
                                 <th>Nama</th>
                                 <th>Email</th>
                                 <th>Status</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($listdata as $key => $value) {
                                ?>
                                 <tr>
                                     <td><?= $no++ ?></td>
                                     <td><?= html_escape($value->username) ?></td>
                                     <td><?= html_escape($value->nama) ?></td>
                                     <td><?= html_escape($value->email) ?></td>
                                     <td><?= html_escape($value->status) ?></td>
                                     <td>
                                         <div class="table-actions">
                                             <a href="<?= base_url('Element/detail_user/' . $value->id_user) ?>" class="btn btn-sm btn-light">Detail</a>
                                             <?php if($_SESSION['level'] == "1" || $_SESSION['level'] == "2") : ?>
                                                 <a href="<?= base_url('Element/edit_user/' . $value->id_user) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                 <a href="<?= base_url('Element/hapususer/' . $value->id_user) ?>" class="btn btn-sm btn-danger">Hapus</a>
                                             <?php endif; ?>
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