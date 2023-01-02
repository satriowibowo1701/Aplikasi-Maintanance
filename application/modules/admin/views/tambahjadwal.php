<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Form Tambah Jadwal</h6>
        </div>
        <div class="card-body">

            <form action="<?= base_url('admin/tambah_jadwal') ?>" method="POST">
                <div class="mb-3"><label for="exampleFormControlInput1">Kode Jadwal</label><input class="form-control" name="id_jadwal" type="text" value="<?= $kode?>" readonly ></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Tanggal Buat</label><input class="form-control" name="tanggal" type="date" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Pilih Mesin</label>
                <select class="form-control" name="mesin">
                <option >- Pilih Mesin -</option>
                <?php foreach($mesin as $data) { ?>
                    <option  value="<?= $data->nama_mesin ?>"><?=$data->nama_mesin ?></option>
                    <?php } ?>
              </select>
            </div>
                <div class="mb-3"><label for="exampleFormControlInput1">Point Check</label>

                <div class="row">
                <div class="radio col-md-4">
                <label>
                <input type="radio" name="point" id="optionsRadios1" value="Filter Oil"> Filter Oil 
                </label>
                </div>
                <div class="radio col-md-4">
                <label>
                <input type="radio" name="point" id="optionsRadios1" value="Filter Pelumas"> Filter Pelumas 
                </label>
                </div>
                <div class="radio col-md-4">
                <label>
                <input type="radio" name="point" id="optionsRadios1" value="Oil Coller"> Oil Coller 
                </label>
                </div>
                <div class="radio col-md-4">
                <label>
                <input type="radio" name="point" id="optionsRadios1" value="Pembersih Stainer"> Pembersih Stainer
                </label>
                </div>
                <!-- end row -->
                </div>
                </div>
                <div class="mb-3"><label for="exampleFormControlInput1">Tanggal Jadwal</label><input class="form-control" name="tanggal_jadwal" type="date" id="datepicker2"  required></div>
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



