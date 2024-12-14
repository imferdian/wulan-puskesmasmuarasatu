<?php
require "functions.php";
session_start();

// Cek Session
if(!isset($_SESSION["login"])) {
  // Jika tidak ada session, cek cookie
  if(!checkCookie()) {
      header("Location: login.php");
      exit;
  }
}

// Setelah ada session baru cek role
if($_SESSION["role"] !== "admin") {
  header("Location: login.php");
  exit;
}

$users = query("SELECT * FROM users WHERE role = 'pegawai'");

$currentPage = "index";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include "layout/navbar.php" ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "layout/sidebar.php" ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 fw-semibold"><b>Sistem Informasi Kepegawaian (SIMPEG) Puskesmas Muara Satu</b></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Pegawai</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body overflow-auto">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">No</th>
                <th style="width: 150px">NIP</th>
                <th>Nama</th>
                <th style="width: 50px">Golongan</th>
                <th>Jabatan</th>
                <th style="width: 150px">Aksi</th>
              </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            <?php foreach ($users as $user) : ?>
              <tr>
                <td><?= $i; ?></td>
                <td><?= $user['nip']; ?></td>
                <td><?= $user['nama']; ?></td>
                <td><?= $user['golongan']; ?></td>
                <td><?= $user['jabatan']; ?></td>
                <td>
                  <a href="detail.php?id=<?= $user['id_user']; ?>" class="btn btn-success badge">Lihat Detail</a>
                  <a href="hapus.php?id=<?= $user['id_user']; ?>" class="btn btn-danger badge" onclick="return confirm('Apakah Anda yakin ingin menghapus data?');">Hapus</a>
                </td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
          </ul>
        </div>
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- ScriptJS -->

</body>
</html>
