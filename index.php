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
if($_SESSION["role"] !== "pegawai") {
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
            <h1 class="m-0 font-weight-bold">Sistem Informasi Kepegawaian (SIMPEG) Puskesmas Muara Satu</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Upload File</h3>
              </div>
              <!-- <div class="card-body">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="custom-file mb-3">
                      <input type="file" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">Pilih file...</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                    </div>
                  </div>
                </form>
              </div> -->
              <div class="card-body">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Judul Dokumen</label>
                    <input type="text" name="judul" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <div class="custom-file mb-3">
                      <input type="file" class="custom-file-input " id="customFile" name="file[]" multiple required>
                      <label class="custom-file-label" for="customFile">Pilih file...</label>
                    </div>
                    <small class="text-muted">Format yang diizinkan: JPG, PNG, DOCX, PDF, XLSX (Max. 5MB)</small>
                  </div>
                  <div class="text-center">
                    <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
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
<script src="dist/js/upload.js"></script>
</body>
</html>
