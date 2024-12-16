<?php
session_start();

// Cek login
if(!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}

// Cek parameter file dan kategori
if(!isset($_GET['file']) || !isset($_GET['kategori']) || !isset($_GET['judul'])) {
  header("Location: ../index.php"); 
  exit;
}

$filename = $_GET['file'];
$kategori = $_GET['kategori'];
$judul = $_GET['judul'];

$file_extension = pathinfo($filename, PATHINFO_EXTENSION);
$download_filename = $judul . "." . $file_extension;

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

// Set header untuk download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $download_filename . '"');
header('Content-Length: ' . filesize($filepath));
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Expires: 0');

// Output file
readfile($filepath);
exit;
?>