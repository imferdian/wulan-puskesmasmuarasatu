<?php 
session_start();

if(!isset($_SESSION["login"]) || $_SESSION["role"] !== "admin") {
  header("Location: login.php");
  exit;
}

require "functions.php";

// cek apakah parameter id_user ada
if(!isset($_GET["id"])) {
  header("Location: index.php");
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
  <link rel="stylesheet" href="dist/css/style.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Profile style -->
  <link rel="stylesheet" href="dist/css/profile.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include "layout/navbar.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "layout/sidebar.php" ?>
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-3">
      <div class="container">
        <div class="col">
          <a href="index.php" class="ml-3">&laquo; Kembali</a>
        </div>
        <div class="main-body">
          <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center justify-content-center text-center mb-0">
                  <img src="dist/img/user-profile.png" alt="Admin" class="rounded-circle border" width="150">
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
                      <a href="" class="btn btn-primary btn-sm">
                        <i class="fas fa-download"></i>
                      </a>
                      <a href="" class="btn btn-success btn-sm">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="hapus-dokumen.php?id=<?= $file['id']; ?>&user_id=<?= $id_user; ?>" class="btn btn-danger btn-sm hapus-dokumen">
                        <i class="fas fa-trash"></i>
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
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <!-- SweetAlert -->
  <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <!-- Page specific script -->
<script>
  $(function () {
    $("#dokumen").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "pageLength": 5,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "Semua"]
      ],
      "lengthChange": true,
      "language": {
        "search": "Cari:",
        "searchPlaceholder": "Cari data...",
        "emptyTable": "Tidak ada dokumen yang diupload",
        "zeroRecords": "Tidak menemukan data yang sesuai",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data yang tersedia",
        "infoFiltered": "(disaring dari _MAX_ total data)",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "previous": "Sebelumnya",
          "next": "Selanjutnya"
        }
      }
    });
  });

  $(".hapus-dokumen").click( async function(e) {
    e.preventDefault();
    const href = $(this).attr("href");
    try {      
      const result = await Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        })
        if (result.isConfirmed) {
          // Tampilkan Loading
          Swal.fire({
                  title: 'Memproses...',
                  html: 'Mohon tunggu sebentar',
                  allowOutsideClick: false,
                  showConfirmButton: false,
                  willOpen: () => {
                      Swal.showLoading()
                  }
                });
          document.location.href = href;
        }
    } catch (error) {
      console.error('Error:', error);
      Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Silakan coba lagi'
      });
    }
  });
</script>
</body>
</html>