<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pegawai</title>
      <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/style.css">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
</head>
<body>
    
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script>

</script>
</body>
</html>





<?php
session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';
$id = $_GET["id"];


if (hapus($id) > 0) {
    echo "
    <script> 
        Swal.fire({
            icon: 'success',
            title: 'Data pegawai berhasil dihapus',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            document.location.href = 'admin.php';
        });
    </script>
    ";
}else{
    echo "
    <script> 
        Swal.fire({
            icon: 'error',
            title: 'Data pegawai gagal dihapus',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = 'admin.php'
        });
    </script>
    ";
}

?>