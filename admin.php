<?php
require "functions.php";
session_start();

// Cek Session
if(!isset($_SESSION["login"])) {
  // Jika tidak ada session, cek cookie
  if(!checkCookie()) {
      header("Location: login.php");
      exit;
  }
}

// Setelah ada session baru cek role
if($_SESSION["role"] !== "admin") {
  header("Location: login.php");
  exit;
}

$users = query("SELECT * FROM users WHERE role = 'pegawai'");

$currentPage = "index";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Admin</title>


  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="dist/css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title font-weight-semibold">Data Pegawai</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body overflow-auto">
          <table class="table table-bordered" id="tabelPegawai">
            <thead>
              <tr>
                <th style="width: 10px">No</th>
                <th style="width: 150px">NIP</th>
                <th>Nama</th>
                <th style="width: 50px">Golongan</th>
                <th style="width: 150px">Jabatan</th>
                <th style="width: 109px">Aksi</th>
              </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            <?php foreach ($users as $user) : ?>
              <tr>
                <td><?= $i; ?></td>
                <td><?= $user['nip']; ?></td>
                <td class="text-capitalize"><?= $user['nama']; ?></td>
                <td><?= $user['golongan']; ?></td>
                <td><?= $user['jabatan']; ?></td>
                <td>
                  <a href="detail.php?id=<?= $user['id_user']; ?>" class="btn btn-success badge">Lihat Detail</a>
                  <a href="hapus.php?id=<?= $user['id_user']; ?>" class="btn btn-danger badge hapus-pegawai">Hapus</a>
                </td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
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
<script>
  $(function () {
    $("#tabelPegawai").DataTable({
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
        "emptyTable": "Tidak ada data yang tersedia",
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

  $(".hapus-pegawai").click( async function(e) {
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
