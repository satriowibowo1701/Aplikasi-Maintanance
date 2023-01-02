<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Form Tambah Perbaikan</h6>
        </div>
        <div class="card-body">

            <form action="<?= base_url('operator/tambah_perbaikan') ?>" method="POST">
                <div class="mb-3"><label for="exampleFormControlInput1">Kode Perbaikan</label><input class="form-control" value="<?= $kode ?>" name="id_perbaikan" type="text" readonly></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Tanggal Perbaikan</label><input class="form-control" name="tanggal" type="date" required></div>
            <div class="mb-3"><label for="exampleFormControlInput1">Jenis Tindakan</label>
                <select class="form-control" name="jenis">
                <option >- Pilih Tindakan -</option>
                <option value="Segera"> Segera </option>
                <option value="Tidak"> Tidak </option>
              </select>
            </div>
                <div class="mb-3"><label for="exampleFormControlInput1">Judul</label><input class="form-control" name="judul" type="text" id="datepicker2"  required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Keterangan</label><input class="form-control" name="keterangan" type="text" id="datepicker2"  required></div>
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



