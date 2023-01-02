<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Form Edit User</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/edit_perbaikan') ?>" method="POST">
            <input type="hidden" name="id" value="<?=$data[0]->id ?>">
            <div class="mb-3"><label for="exampleFormControlInput1">ID Perbaikan</label><input class="form-control" name="id_perbaikan" type="text" value="<?= $data[0]->id_perbaikan ?>" required></div>
            <div class="mb-3"><label for="exampleFormControlInput1">Tanggal perbaikan</label><input class="form-control" name="tanggal" type="date" value="<?= $data[0]->tanggal ?>" required></div>
            <div class="mb-3"><label for="exampleFormControlInput1">Mesin</label><select class="form-control" id="exampleFormControlSelect1" name="mesin" required>
                        <option>- Pilih Mesin -</option>
                        <?php foreach($mesin as $datas) { 
                             if ($datas->nama_mesin == $data[0]->mesin) {
                                echo '<option selected value="'.$datas->nama_mesin.'">'.$datas->nama_mesin.'</option>';
                            }else {
                                echo '<option value="'.$datas->nama_mesin.'">'.$datas->nama_mesin.'</option>';
                            } 
                       }?>
                    </select></div>
                    <div class="mb-3"><label for="exampleFormControlInput1">Jenis Tindakan</label>
                <select class="form-control" name="jenis">
                <option >- Pilih Tindakan -</option>
                <?php  if($data[0]->tindakan == 'Segera') {
                  echo'<option value="Tidak"> Tidak </option>';
                  echo '<option value="Segera" selected>Segera</option>';
                }else if ($data[0]->tindakan == 'Tidak') {
                    echo'<option value="Tidak" selected> Tidak </option>';
                    echo '<option value="Segera">Segera</option>';
                }else {
                    echo '<option value="Tidak">Tidak</option>';
                    echo '<option value="Segera">Segera</option>';
                } ?>
              </select>
            </div>
                <div class="mb-3"><label for="exampleFormControlInput1">Judul</label><input class="form-control" name="judul" type="text" value="<?= $data[0]->judul ?>" required></div>
                <div class="mb-3"><label for="exampleFormControlInput1">Keterangan</label><input class="form-control" name="keterangan" id="exampleFormControlInput1" type="text" value="<?= $data[0]->keterangan ?>" required></div>

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

