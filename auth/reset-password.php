<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>

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
                <h5 class="text-center mb-4">Masukan Password Baru</h5>
                <form class="form-card" method="post">
                    <div class="form-group col-sm-6 flex-column d-flex text-left">
                        <label class="form-control-label px-1">Password Baru<span class="text-danger"> *</span></label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="form-group col-sm-6 flex-column d-flex text-left">
                        <label class="form-control-label px-1">Konfirmasi Password<span class="text-danger"> *</span></label>
                        <input type="password" name="konfirmasi" required>
                    </div>
                    <div class="form-group col-sm-6 mt-4">
                        <button type="submit" name="reset" class="btn-block btn-primary">Reset Password</button>
                    </div>
                </form>
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

// Cek jika belum verifikasi
if(!isset($_SESSION['reset_id'])) {
    header("Location: forgot-password.php");
    exit;
}

if(isset($_POST["reset"])) {
    $password = mysqli_real_escape_string($koneksi, $_POST["password"]);
    $konfirmasi = mysqli_real_escape_string($koneksi, $_POST["konfirmasi"]);
    
    if($password !== $konfirmasi) {
        echo "<script>
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'error',
                title: 'Oops...',
                text: 'Password tidak sama!',
                showConfirmButton: false,
                timer: 2000
            })
        </script>";
    } else {
        $id = $_SESSION['reset_id'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $koneksi->prepare("UPDATE users SET password = ? WHERE id_user = ?");
        $stmt->bind_param("si", $password, $id);
        
        if($stmt->execute()) {
            unset($_SESSION['reset_id']);
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Password berhasil diubah',
                    confirmButtonText: 'Login'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php';
                    }
                });
            </script>";
        }
    }
}
?>