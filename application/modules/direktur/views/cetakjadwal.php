<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Pilih Tanggal Jadwal</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('direktur/cetak_jadwal') ?>" method="POST">
                <div class="mb-3"><label for="exampleFormControlInput1">Tanggal Awal</label><input class="form-control" name="first" type="date" required></div>
                <h4> S.d </h2>
                <div class="mb-3"><label for="exampleFormControlInput1">Tanggal Akhir</label><input class="form-control" name="end" id="exampleFormControlInput1" type="date" required></div>
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