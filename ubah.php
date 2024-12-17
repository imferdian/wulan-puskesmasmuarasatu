<?php
require "config/functions.php";
session_start();

$id = $_GET['id'];

$user = query("SELECT * FROM users WHERE id_user = $id")[0];

if(!isset($_SESSION["login"]) || $_SESSION['profile'] !== true) {
  header("Location: auth/login.php");
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

  <!-- Google Font: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Bootstrap Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="dist/css/style.css">
  <link rel="stylesheet" href="dist/css/profile.css">
  <link rel="stylesheet" href="dist/css/ubah.css">
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
              <div class="d-flex flex-column align-items-center text-center ">
                <div class="foto-profile">
                  <img src="dist/img/<?= $user['foto'] ? $user['foto'] : 'default.png' ?>" alt="Foto Profil" class="rounded-circle " width="150" height="150" style="object-fit: cover;">
                  <button type="button" class="btn btn-primary btn-sm rounded-pill ubah-foto" data-toggle="modal" data-target="#modalGantiFoto">
                  <i class="bi bi-camera-fill"></i>
                  </button>
                </div>
                <!-- Modal Ganti Foto -->
                <div class="modal fade" id="modalGantiFoto" tabindex="-1" role="dialog" aria-labelledby="modalGantiFotoLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalGantiFotoLabel">Ganti Foto Profil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                          <input type="hidden" name="id" value="<?= $user['id_user'] ?>">
                          <input type="hidden" name="fotoLama" value="<?= $user['foto'] ?>">
                          <div class="form-group">
                            <label>Pilih Foto Baru</label>
                            <input type="file" class="form-control" name="foto" accept="image/*" required>
                            <small class="text-muted">Format: jpg, jpeg, png. Maksimal 2MB</small>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" name="gantiFoto" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
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
<!-- SweetAlert -->
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
</body>
</html>
<?php 

if(isset($_POST["submit"])) {
  if(ubah($_POST) > 0) {
    echo "
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil Mengubah Data Profil',
            text: 'Data profil telah diubah',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
          }).then(() => {
            document.location.href = 'profile.php';
          });
        </script>
        ";
  } else {
    echo "
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Gagal Mengubah Data Profil',
            text: 'Tidak ada data yang diubah',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
          }).then(() => {
            document.location.href = 'ubah.php?id=$id'
          });
        </script>
        ";
  }
}

if(isset($_POST["gantiFoto"])) {
    $id = $_POST["id"];
    $fotoLama = $_POST["fotoLama"];
    
    // Cek apakah ada file yang diupload
    if($_FILES['foto']['error'] === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
                document.location.href = 'ubah.php?id=$id';
              </script>";
        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $_FILES['foto']['name']);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal Mengubah Foto Profil',
                  text: 'Yang anda upload bukan gambar',
                  toast: true,
                  position: 'top',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true
              }).then(() => {
                document.location.href = 'ubah.php?id=$id'
                });
              </script>";
        return false;
    }

    // Cek ukuran file (maksimal 2MB)
    if($_FILES['foto']['size'] > 2000000) {
        echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal Mengubah Foto Profil',
                  text: 'Ukuran gambar terlalu besar (maks 2MB)',
                  toast: true,
                  position: 'top',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true
              }).then(() => {
                document.location.href = 'ubah.php?id=$id'
                });
              </script>";
        return false;
    }

    // Generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // Hapus foto lama jika bukan foto default
    if($fotoLama != 'default.png') {
        unlink('dist/img/' . $fotoLama);
    }

    // Upload file baru
    move_uploaded_file($_FILES['foto']['tmp_name'], 'dist/img/' . $namaFileBaru);

    // Update database
    $query = "UPDATE users SET foto = '$namaFileBaru' WHERE id_user = $id";
    mysqli_query($koneksi, $query);

    if(mysqli_affected_rows($koneksi) > 0) {
        echo "<script>
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil Mengubah Foto Profil',
                  text: 'Foto profil telah diubah',
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: true
                }).then(() => {
                  document.location.href = 'profile.php'
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal Mengubah Foto Profil',
                  text: 'Foto profil belum dibuah',
                  toast: true,
                  position: 'top',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true
              }).then(() => {
                document.location.href = 'ubah.php?id=$id'
                });
              </script>";
    }
}

?>