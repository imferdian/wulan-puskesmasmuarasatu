<?php
require "functions.php";
session_start();
$_SESSION['profile'] = true;

// Cek Session
if(!isset($_SESSION["login"])) {
  // Jika tidak ada session, cek cookie
  if(!checkCookie()) {
      header("Location: login.php");
      exit;
  }
}

$id = $_SESSION['id'];
$user = query("SELECT * FROM users WHERE id_user = $id")[0];

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$currentPage = "profile";

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Profile</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Profile style -->
  <link rel="stylesheet" href="dist/css/profile.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include "layout/navbar.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "layout/sidebar.php" ?>
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-3 ">
      <div class="container">
        <div class="main-body ">
        <div class="row gutters-sm">
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                  <img src="dist/img/user-profile.png" alt="Admin" class="rounded-circle" width="150">
                  <div class="my-3">
                    <h4 class="mb-1 text-uppercase font-weight-bold"><?=  $user['nama'] ?></h4>
                    <p class="text-secondary mb-0  text-uppercase"><?= $user['role'] ?></p>
                    <p class="text-muted font-size-sm"><?= $user['nip'] ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card mb-3">
              <div class="card-body p-4">
                <div class="row content-profile">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Nama</h6>
                  </div>
                  <div class="col-sm-9 text-secondary text-capitalize">
                    <?= $user['nama'] ?>
                  </div>
                </div>
                <hr>
                <div class="row content-profile">
                  <div class="col-sm-3">
                    <h6 class="mb-0">NIP</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?= $user['nip'] ?>
                  </div>
                </div>
                <hr>
                <div class="row content-profile">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Golongan</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?= $user['golongan'] ?>
                  </div>
                </div>
                <hr>
                <div class="row content-profile">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Jabatan</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?= $user['jabatan'] ?>
                  </div>
                </div>
                <hr>
                <div class="row mt-4">
                  <div class="col-sm-12">
                    <a class="btn btn-info" href="ubah.php?id=<?= $user["id_user"] ?>">Edit</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
</body>
</html>
