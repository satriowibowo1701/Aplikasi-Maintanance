<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
        </div>
        <div class="card-body">

            <form action="<?= base_url('admin/tambah_user') ?>" method="POST">
                <div class="mb-3"><label for="exampleFormControlInput1">Nama</label><input class="form-control" name="nama" type="text" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Email</label><input class="form-control" name="email" id="exampleFormControlInput1" type="email" placeholder="name@example.com" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Password</label><input class="form-control" name="password" id="exampleFormControlInput1" type="password" required></div>
                <div class="mb-3">
                    <label for="exampleFormControlSelect1">Role</label><select class="form-control" id="role" name="role" required>
                        <option>Pilih Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Operator">Operator</option>
                        <option value="Direktur">Direktur</option>
                    </select>
                </div>
                <div id="form-role" style="display: none;">
                <div class="mb-3"><label for="exampleFormControlInput1">Pilih Mesin</label>
                <select class="form-control" name="mesin">
                <option >- Pilih Mesin -</option>
                <?php foreach($mesin as $data) { ?>
                    <option  value="<?= $data->nama_mesin ?>"><?=$data->nama_mesin ?></option>
                    <?php } ?>
              </select>
            </div>
                </div>
                <button class="btn btn-primary">
                    <i class="fa fa-check"> </i> Kirim
                </button>
            </form>

        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    $('#role').change(function() {
    var value = $(this).val();
    if (value == 'Operator') {
        $('#form-role').show();
    }else{
        $('#form-role').hide();
    }
    })

</script>