<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Registration</title>

  <!-- Google Font: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../dist/css/style.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../dist/css/register.css">
</head>
<body class="hold-transition register-page">
  <div class="container-fluid px-1 mx-auto">
      <div class="row d-flex justify-content-center">
          <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
              <div class="card">
                  <h1 class="text-center mb-2">Puskesmas Muara Satu</h1>
                  <h5 class="text-center mb-4">Daftar Akun</h5>
                  <form class="form-card" id="formRegister" action="" method="post">
                      <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3" for="nama">Nama<span class="text-danger"> *</span></label>
                            <input type="text" id="nama" name="nama" placeholder="Masukkan nama anda" onblur="validate(1)" required>
                        </div>
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3" for="nip">NIP<span class="text-danger"> *</span></label>
                            <input type="text" id="nip" name="nip" placeholder="Masukkan NIP anda" onblur="validate(2)" required>
                        </div>
                      </div>
                      <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3" for="golongan">Golongan<span class="text-danger"> *</span></label>
                            <input type="text" id="golongan" name="golongan" placeholder="Masukan golongan anda" onblur="validate(3)" required>
                        </div>
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3" for="jabatan">Jabatan<span class="text-danger"> *</span></label>
                            <input type="text" id="jabatan" name="jabatan" placeholder="Masukan jabatan anda" onblur="validate(4)" required>
                        </div>
                      </div>
                      <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3" for="password">Password (Minimal 6 Karakter)<span class="text-danger"> *</span></label>
                            <input type="password" id="password" name="password" placeholder="Masukan password anda" onblur="validate(5)" required>
                        </div>
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3" for="password2">Konfirmasi Password<span class="text-danger"> *</span></label>
                            <input type="password" id="password2" name="password2" placeholder="Masukan konfirmasi password anda" onblur="validate(6)" required>
                        </div>
                      </div>
                      <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3" for="role">Kode Role (optional)</label>
                            <input type="text" id="role" name="role" placeholder="Masukan kode role anda">
                        </div>
                        <div class="form-group col-sm-6 mt-4">
                            <button type="submit" name="register" class="btn-block btn-primary">Daftar</button>
                        </div>
                      </div>
                  </form>
                  <p class="text-center mt-2 fs"> Sudah punya akun? <a href="login.php">Login</a></p>
              </div>
          </div>
      </div>
  </div>

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- ScriptJS -->
    <script src="../dist/js/script.js"></script>

</body>
</html>

<?php
require "../config/functions.php";

if(isset($_POST["register"])){

    if(register($_POST) > 0){
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil',
            text: 'Silahkan login menggunakan akun yang sudah terdaftar',
            confirmButtonText: 'Login'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
        });</script>";
    }else{
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal',
            text: 'Silahkan coba lagi',
            confirmButtonText: 'Coba Lagi'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'register.php';
            }
        });</script>";
    }
}