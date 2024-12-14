<?php
require "functions.php";
session_start();

$id = $_GET['id'];

$user = query("SELECT * FROM users WHERE id_user = $id")[0];

if(!isset($_SESSION["login"]) || $_SESSION['profile'] !== true) {
  header("Location: login.php");
  exit;
}

if(isset($_POST["submit"])) {
  if(ubah($_POST) > 0) {
    echo "
        <script> 
            alert('data berhasil diubah');
            document.location.href = 'profile.php'
        </script>
        ";
  } else {
    echo "
        <script> 
            alert('data gagal diubah');
            document.location.href = 'profile.php'
        </script>
        ";
  }
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
      <div class="col">
        <a href="profile.php" class="ml-3">&laquo; Kembali</a>
      </div>  
      <div class="main-body">
        <div class="row">
          <div class="col-lg-4">
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
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body p-4">
                <form action="" method="post">
                <input type="hidden" name="id" value="<?= $user["id_user"]; ?>">
                <div class="row mb-3">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Nama</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <input type="text" name="nama" class="form-control text-capitalize" value="<?= $user['nama'] ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-3">
                    <h6 class="mb-0">NIP</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <input type="text" name="nip" class="form-control" value="<?= $user['nip'] ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-3">
                      <h6 class="mb-0">Golongan</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <input type="text" name="golongan" class="form-control" value="<?= $user['golongan'] ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Jabatan</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <input type="text" name="jabatan" class="form-control" value="<?= $user['jabatan'] ?>" required>
                  </div>
                </div>
                <div class="button-container w-100 d-flex justify-content-between">
                  <div class="">
                    <button type="submit" name="submit" class="btn btn-primary px-4">Simpan</button>
                  </div>
                </div>
                </form>
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
