<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lupa Password</title>

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
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../dist/css/login.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
</head>
<body class="hold-transition register-page">
  <div class="container-fluid px-1 mx-auto">
      <div class="row d-flex justify-content-center">
          <div class="col-xl-10 col-lg-10 col-md-9 col-11 text-center d-flex justify-content-center">
            <div class="card card-reset-password">
              <h5 class="text-center mb-4">Reset Password</h5>
              <form class="form-card" id="formForgot" method="post">
                <div class="form-group col-sm-6 flex-column d-flex text-left">
                  <label class="form-control-label px-1">NIP<span class="text-danger"> *</span></label>
                  <input type="text" name="nip" placeholder="Masukan NIP anda" required>
                </div>
                <div class="form-group col-sm-6 flex-column d-flex text-left">
                  <label class="form-control-label px-1">Nama Lengkap<span class="text-danger"> *</span></label>
                  <input type="text" name="nama" placeholder="Masukan Nama Lengkap" required>
                </div>
                <div class="form-group col-sm-6 flex-column d-flex text-left">
                  <label class="form-control-label px-1">Golongan<span class="text-danger"> *</span></label>
                  <input type="text" name="golongan" placeholder="Masukan Golongan" required>
                </div>
                <div class="form-group col-sm-6 flex-column d-flex text-left">
                  <label class="form-control-label px-1">Jabatan<span class="text-danger"> *</span></label>
                  <input type="text" name="jabatan" placeholder="Masukan Jabatan" required>
                </div>
                <div class="form-group col-sm-6 mt-4">
                  <button type="submit" name="verify" class="btn-block btn-primary">Verifikasi</button>
                </div>
              </form>
              <p class="text-center mt-1">Kembali ke <a href="login.php">Login</a></p>
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
<!-- SweetAlert -->
<script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>

</body>
</html>

<?php
require "../config/functions.php";
session_start();

if(isset($_POST["verify"])) {
    $nip = mysqli_real_escape_string($koneksi, $_POST["nip"]);
    $nama = mysqli_real_escape_string($koneksi, $_POST["nama"]);
    $golongan = mysqli_real_escape_string($koneksi, $_POST["golongan"]);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST["jabatan"]);

    // Cek data user
    $stmt = $koneksi->prepare("SELECT * FROM users WHERE nip = ? AND nama = ? AND golongan = ? AND jabatan = ?");
    $stmt->bind_param("ssss", $nip, $nama, $golongan, $jabatan);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['reset_id'] = $row['id_user'];
        header("Location: reset-password.php");
        exit;
    } else {
        echo "<script>
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'error',
                title: 'Oops...',
                text: 'Data yang anda masukan tidak sesuai!',
                showConfirmButton: false,
                timer: 2000
            });
        </script>";
    }
}