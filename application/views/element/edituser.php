 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
         <ol class="breadcrumb">
         </ol>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <!-- Form Basic -->
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 </div>
                 <div class="card-body">
                     <form action="<?= base_url('element/edit_user/'. $brg_masuk->id_user) ?>" method="POST" role="form">
                     <div class="form-group">
                             <label for="exampleInputPassword1">ID User</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->id_user ?>" name="kode" id="kode" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Username</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->username ?>" name="nama" id="nama" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Password</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->password ?>" name="password" id="password">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Nama</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->nama ?>" name="jenis" id="jenis" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Email</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->email ?>" name="jenis" id="jenis" readonly>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Status</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->status ?>" name="status" id="status">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Nomor Whatsapp</label>
                             <input type="text" class="form-control" value="<?= $brg_masuk->no_wa ?>" name="no_wa" id="no_wa">
                         </div>
                         <div class="form-group">
                             <label>Level User</label>
                             <select name="level" class="form-control">
                                 <option value="">---Pilih Level User---</option>
                                 <option value="1" <?php if ($brg_masuk->level_user == '1') {
                                                        echo 'selected';
                                                    } ?>>Pemilik</option>
                                 <option value="2" <?php if ($brg_masuk->level_user == '2') {
                                                        echo 'selected';
                                                    } ?>>Admin</option>
                                 <option value="3" <?php if ($brg_masuk->level_user == '3') {
                                                        echo 'selected';
                                                    } ?>>Karyawan</option>
                                 <option value="4" <?php if ($brg_masuk->level_user == '4') {
                                                        echo 'selected';
                                                    } ?>>Pelanggan</option>
                             </select>
                         </div>
                         <button type="submit" class="btn btn-success">UPDATE</button>
                         <a type="submit" href="javascript:window.history.go(-1);" class="btn btn-primary">Kembali </a>
                     </form>
                 </div>
             </div>

         </div>
         <!---Container Fluid-->