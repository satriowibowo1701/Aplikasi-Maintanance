<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Kartu Riwayat Mesin</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/cetak_mesin') ?>" method="POST">
            <div class="mb-3"><label for="exampleFormControlInput1">Pilih Nama Mesin</label><select class="form-control" id="exampleFormControlSelect1" name="mesin" required>
                        <option>- Pilih Mesin -</option>
                        <?php foreach($mesin as $datas) { 
                                echo '<option value="'.$datas->nama_mesin.'">'.$datas->nama_mesin.'</option>';
                       }?>
                    </select></div>
                    <div class="mb-3"><label for="exampleFormControlInput1">Pilih Opsi Laporan</label><select class="form-control" id="exampleFormControlSelect1" name="opsi" required>
                        <option>- Pilih Opsi -</option>
                <option value="Perbaikan">Perbaikan</option>
                <option value="Penjadwalan">Penjadwalan</option>
                    </select></div>
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