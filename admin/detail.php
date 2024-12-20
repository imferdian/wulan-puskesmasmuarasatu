<?php 
session_start();
require "../config/functions.php";

// Cek Session
if(!isset($_SESSION["login"])) {
  // Jika tidak ada session, cek cookie
  if(!checkCookie()) {
      header("Location: auth/login.php");
      exit;
  }
}


if($_SESSION["role"] !== "admin") {
  header("Location: ../login.php");
  exit;
}

// cek apakah parameter id_user ada
if(!isset($_GET["id"])) {
  header("Location: ../index.php");
  exit;
}

$id_user = $_GET["id"];
$user = query("SELECT * FROM users WHERE id_user = $id_user")[0];
$files = query("SELECT * FROM files WHERE id_user = $id_user");

$currentPage = "index";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Detail</title>

  <!-- Google Font: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../dist/css/style.css">
  <!-- Bootstrap Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Profile style -->
  <link rel="stylesheet" href="../dist/css/profile.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include "../layout/navbar.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "../layout/sidebar.php" ?>
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-3">
      <div class="container">
        <div class="col">
          <a href="../admin.php" class="ml-3">&laquo; Kembali</a>
        </div>
        <div class="main-body">
          <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center justify-content-center text-center mb-0">
                  <img src="../dist/img/<?= $user['foto'] ?? 'user-profile.png' ?>" alt="Admin" class="rounded-circle border" width="150" height="150" style="object-fit: cover;">
                  <div class="mt-3">
                    <h4 class="mb-1 text-uppercase font-weight-bold"><?=  $user['nama'] ?></h4>
                    <p class="text-secondary mb-0  text-uppercase"><?= $user['role'] ?></p>
                    <p class="text-muted font-size-sm"><?= $user['nip'] ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 ">
            <div class="card pt-3">
              <div class="card-body p-4">
                <div class="row content-profile">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Nama</h6>
                  </div>
                  <div class="col-sm-9 text-secondary text-uppercase">
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
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card">
              <div class="card-header">
                <h5 class="">Dokumen yang diupload</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dokumen" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 10px">No</th>
                    <th>Nama Dokumen</th>
                    <th style="width: 150px">Tanggal Upload</th>
                    <th style="width: 90px">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($files as $file) : ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td><?= $file['judul']; ?></td>
                    <td><?= $file['tanggal_upload']; ?></td>
                    <td>
                     <a href="../actions/download-dokumen.php?file=<?= $file['nama_file'];?>&kategori=<?= $file['kategori'];?>&judul=<?= $file['judul'];?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-download"></i>
                      </a>
                      <button type="submit" class="btn btn-success btn-sm preview-btn" data-toggle="modal" data-target="#previewModal" 
                              data-file="<?= $file['nama_file']; ?>" 
                              data-kategori="<?= $file['kategori']; ?>"
                              data-judul="<?= $file['judul']; ?>">
                        <i class="bi bi-eye-fill"></i>
                      </button>
                    <!-- Modal Preview -->
                      <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="previewModalLabel">Preview Dokumen</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body text-center">
                              <div id="preview-content"></div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <a href="../actions/hapus-dokumen.php?id=<?= $file['id']; ?>&user_id=<?= $id_user; ?>" class="btn btn-danger btn-sm hapus-dokumen">
                      <i class="bi bi-trash-fill"></i>
                    </a>
                    </td>
                  </tr>
                  <?php $i++; ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <!-- SweetAlert -->
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="../dist/js/detail.js"></script>
</body>
</html>