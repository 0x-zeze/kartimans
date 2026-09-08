<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
              <h1 class="h3 mb-0 text-gray-800">Data Berhasil</h1>
              <p class="page-kicker mb-0">Kartimans Barbershop</p>
            </div>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Data Berhasil -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Data Berhasil</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                      <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Jenis Pelayanan</th>
                        <th>Total Harga</th>
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
                                     <td><?= $value->time ?></td>
                                     <td><?= $value->jenis ?></td>
                                     <td><?= "Rp " . number_format($value->harga, 0, ',', '.') ?></td>
                                 </tr>
                             <?php
                                }
                                ?>
                         </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- DataTable with Hover -->
          </div>
          <!--Row-->

        </div>
        <!---Container Fluid-->