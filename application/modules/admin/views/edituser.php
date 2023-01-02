<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Form Edit User</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/edit_user') ?>" method="POST">
            <input type="hidden" name="id" value="<?=$data[0]->id ?>">
                <div class="mb-3"><label for="exampleFormControlInput1">Nama</label><input class="form-control" name="nama" type="text" value="<?=$data[0]->nama ?>" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Email</label><input class="form-control" name="email" id="exampleFormControlInput1" value="<?=$data[0]->email ?>" type="email" placeholder="name@example.com" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Password</label><input class="form-control" name="password" id="exampleFormControlInput1" type="password" ></div>
                <div class="mb-3">
                    <label for="exampleFormControlSelect1">Role</label><select class="form-control" id="exampleFormControlSelect1" name="role" readonly>
                        <?php switch($data[0]->role) { 
                         case "Admin":
                               echo ' <option value="Admin" selected>Admin</option>';
                               break;
                        case "Operator":
                            echo'<option value="Operator" selected>Operator</option>';
                               break;
                        case "Direktur" :
                            echo '<option value="Direktur" selected>Direktur</option>';
                            break;
                            
                        }?>
                    </select>
                </div>
                        <?php
                        if($data[0]->role == "Operator"){ ?>
                            <div class="mb-3"><label for="exampleFormControlInput1">Divisi Mesin</label>
                            <select class="form-control" name="mesin">
                                <option >- Pilih Mesin -</option>
                                <?php foreach($mesin as $datas) { 
                                    if ($datas->nama_mesin == $data[0]->mesin ){
                                        echo '<option value="'.$datas->nama_mesin.'" selected>'.$datas->nama_mesin.'</option>';
                                    }else {
                    echo '<option value="'.$datas->nama_mesin.'">'.$datas->nama_mesin.'</option>';
                }
            } ?>
              </select>
            </div>
            <?php } ?>
            <button class="btn btn-primary">
                <i class="fa fa-check"> </i> Ubah Data
                </button>
            </form>

        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>