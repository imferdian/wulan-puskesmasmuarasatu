<?php
// Mulai session untuk keamanan
require 'functions.php';
session_start();

// Cek cookie
// if( isset($_COOKIE["id"]) && isset($_COOKIE["key"]) ) {
//   checkCookie();
// }

if(isset($_SESSION["login"])) {
  if($_SESSION["role"] === "admin") {
    header("Location: admin.php");
    exit;
  } else {
    header("Location: index.php");
    exit;
  }
}

if(isset($_POST["login"])) {
    // Sanitasi input
    $nip = mysqli_real_escape_string($koneksi, trim($_POST["nip"]));
    $password = $_POST["password"];

    // Gunakan prepared statement untuk mencegah SQL Injection
    $stmt = $koneksi->prepare("SELECT * FROM users WHERE nip = ?");
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if( password_verify($password, $row["password"]) ) {
            if(isset($_POST['remember'])) {
              // Set cookie selama
              setcookie('id', $row['id_user'], time() + 60 * 5);
              setcookie('key', hash('sha256', $row['nip']), time() + 60 * 5); 
            }
            $_SESSION['login'] = true;
            $_SESSION['id'] = $row['id_user'];

            if($row["role"] === "admin") {
                $_SESSION["role"] = "admin";
                header("Location: admin.php");
                exit;
            } else {
                $_SESSION["nama"] = $row["nama"];
                $_SESSION["role"] = "pegawai";
                header("Location: index.php");
                exit;
            }
        } else {
            $error_message = "Password salah";
        }
    } else {
        $error_message = "NIP tidak ditemukan";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!--  -->
  <link rel="stylesheet" href="./dist/css/login.css">
</head>
<body class="hold-transition register-page">
  <div class="container-fluid px-1 mx-auto">
      <div class="row d-flex justify-content-center">
          <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center d-flex justify-content-center">
              <div class="card">

                  <h1 class="text-center mb-2">Puskesmas Muara Satu</h1>
                  <h5 class="text-center mb-4">Login</h5>

                  <?php if(isset($error_message)): ?>
                    <p class="text-danger">
                      <?= $error_message; ?>
                    </p>
                  <?php endif; ?>

                  <form class="form-card" id="formLogin" action="login.php" method="post">
                    <div class="form-group col-sm-6 flex-column d-flex text-left">
                      <label class="form-control-label px-1" for="nip">NIP<span class="text-danger"> *</span></label>
                      <input type="text" id="nip" name="nip" placeholder="Masukan NIP anda" required>
                    </div>
                    <div class="form-group col-sm-6 flex-column d-flex text-left">
                      <label class="form-control-label px-1" for="password">Password<span class="text-danger"> *</span></label>
                      <input type="password" id="password" name="password" placeholder="Masukan Password anda" required>
                      <div class="row ">
                        <div class="col icheck-primary">
                          <input type="checkbox" name="remember" id="remember">
                          <label for="remember">Ingat Saya</label>
                        </div>
                        <a href="forgot-password.php">Lupa Password?</a>
                      </div>
                    </div>
                    <div class="form-group col-sm-6 mt-4">
                        <button type="submit" name="login" class="btn-block btn-primary">Login</button>
                    </div>
                  </form>
                  <p class="text-center mt-1 fs"> Belum punya akun? <a href="register.php">Daftar</a></p>
              </div>
          </div>
      </div>
  </div>

    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <!-- ScriptJS -->
    <script src="dist/js/script.js"></script>
</body>
</html>
