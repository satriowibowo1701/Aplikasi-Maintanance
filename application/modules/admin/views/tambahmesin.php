<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Form Tambah Mesin</h6>
        </div>
        <div class="card-body">

            <form action="<?= base_url('admin/tambah_mesin') ?>" method="POST">
                <div class="mb-3"><label for="exampleFormControlInput1">ID Mesin</label><input class="form-control" name="id_mesin" type="text" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Nama Mesin</label><input class="form-control" name="nama" type="text" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Merk Mesin</label><input class="form-control" name="merk" id="exampleFormControlInput1" type="text" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Tahun Pembuatan</label><input class="form-control" name="tanggal_buat" type="text"  required id="datepicker"></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Tahun Periode</label><input class="form-control" name="tanggal_pakai" type="text" placeholder="periode pakai" id="datepicker2"  required></div>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script> 
  $(function() {
    $( "#datepicker" ).datepicker({
        format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose:true //to close picker once year is selected
    });
    $( "#datepicker2" ).datepicker({
        format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose:true //to close picker once year is selected
    });
  } );
  </script>

