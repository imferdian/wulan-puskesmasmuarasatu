<?php
session_start();
require "config/functions.php";

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

$idUser = $_SESSION['id'];
$fotoUser = query("SELECT foto FROM users WHERE id_user = '$idUser'")[0];

$_SESSION['foto'] = $fotoUser['foto'];

$users = query("SELECT * FROM users WHERE role = 'pegawai'")[0];

$currentPage = "index";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Index</title>

   <!-- Google Font: Poppins -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="dist/css/style.css">
  <!-- bootsrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

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
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Judul Dokumen</label>
                    <input type="text" name="judul" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <div class="custom-file mb-1">
                      <input type="file" class="custom-file-input " id="customFile" name="file[]" multiple required>
                      <label class="custom-file-label" for="customFile">Pilih file...</label>
                    </div>
                    <small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG, PDF, DOCX, DOC  (Max. 5MB)</small>
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
<!-- SweetAlert -->
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>

</body>
</html>

<?php 
require 'actions/upload.php';


?>