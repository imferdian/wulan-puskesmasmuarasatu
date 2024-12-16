<?php
session_start();

// Cek login
if(!isset($_SESSION["login"])) {
  header("Location: ../auth/login.php");
  exit;
}

// Cek parameter file dan kategori
if(!isset($_GET['file']) || !isset($_GET['kategori'])) {
  header("Location: ../index.php"); 
  exit;
}

$filename = $_GET['file'];
$kategori = $_GET['kategori'];

// Validasi kategori
$allowed_categories = ['dokumen', 'gambar'];
if(!in_array($kategori, $allowed_categories)) {
  echo "Kategori tidak valid";
  exit;
}

// Set path sesuai kategori
$filepath = "../uploads/" . $kategori . "/" . $filename;

// Cek apakah file ada
if(!file_exists($filepath)) {
  echo "File tidak ditemukan.";
  exit;
}

// Dapatkan ekstensi file
$file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// Set content type berdasarkan ekstensi file
switch($file_extension) {
    case 'pdf':
        header('Content-Type: application/pdf');
        break;
    case 'jpg':
    case 'jpeg':
        header('Content-Type: image/jpeg');
        break;
    case 'png':
        header('Content-Type: image/png');
        break;
    default:
        // Jika tipe file tidak didukung, tampilkan pesan
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Jika request AJAX
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Tipe file tidak didukung untuk pratinjau']);
        } else {
            echo "Tipe file tidak didukung untuk pratinjau";
        }
        exit;
}

// Untuk file PDF dan gambar, tampilkan langsung di browser
if(in_array($file_extension, ['pdf', 'jpg', 'jpeg', 'png'])) {
    header('Content-Disposition: inline; filename="' . $filename . '"');
    readfile($filepath);
    exit;
}