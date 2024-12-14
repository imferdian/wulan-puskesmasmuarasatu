<?php 
session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';
$id = $_GET["id"];

if (hapus_dokumen($id) > 0) {
    echo "
    <script> 
        alert('Dokumen berhasil dihapus');
        document.location.href = 'detail.php'
    </script>
    ";
}else{
    echo "
    <script> 
        alert('Dokumen gagal dihapus');
        document.location.href = 'detail.php'
    </script>
    ";
}

?>