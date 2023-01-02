<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Data Total Perbaikan Mesin</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $perbaikan  ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-wrench fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                Data Total Jadwal Mesin</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jadwal ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                Data Total Mesin Belum Selesai</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $notfinish ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-wrench fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Data Total Perbaikan Mesin Selesai </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $finish ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row -->

  <div class="row">
    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Data Total Mesin Telah Diperbaiki Hari Ini</h6>
        </div>
        <!-- Card Body -->
        <?php if (count($perbaikan_today) == 0) { ?>
          <b class="text-center" style="margin-top:20px;">Tidak Ada Data</b>
        <?php } ?>
        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <canvas id="myPieChart"></canvas>
          </div>

        </div>
      </div>
    </div>

    <!-- Project Card Example -->
    <div class="col-xl-6 col-lg-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Progres Perbaikan Hari Ini</h6>
        </div>
        <div class="card-body">
          <h4 class="small font-weight-bold">Selesai<span class="float-right"><?= ceil($perbaikan_sukses) ?>%</span></h4>
          <div class="progress mb-4">
            <div class="progress-bar bg-success" role="progressbar" style="width: <?= ceil($perbaikan_sukses) ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <h4 class="small font-weight-bold">Belum Selesai <span class="float-right"><?= ceil($perbaikan_belum) ?>%</span></h4>
          <div class="progress mb-4">
            <div class="progress-bar bg-danger" role="progressbar" style="width: <?= ceil($perbaikan_belum) ?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Content Row -->

  <!-- Content Column -->
  <!-- /.container-fluid -->


  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          <?php
          foreach ($perbaikan_today as $data) {
            echo '"' . $data->mesin . '"';
            echo ',';
          }

          ?>
        ],
        datasets: [{
          data: [
            <?php
            foreach ($perbaikan_today as $data) {
              echo $data->jumlah;
              echo ',';
            }
            ?>
          ],
          backgroundColor: [
            <?php
            foreach ($warna as $newwarna) {
              echo '"' . $newwarna . '"';
              echo ',';
            }

            ?>
          ],
        }],
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: true,
          position: 'bottom',
        },
      },
    });
  </script>