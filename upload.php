<?php
require "functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


// if(isset($_POST["upload"])) {
//     $judul = htmlspecialchars($_POST["judul"]);
//     $file = $_FILES["file"];
    
//     // Validasi ukuran file (5MB)
//     $maxSize = 5 * 1024 * 1024;
//     if($file["size"] > $maxSize) {
//         echo "<script>
//                 alert('Ukuran file terlalu besar! Maksimal 5MB');
//                 window.location.href = 'index.php';
//               </script>";
//         exit;
//     }
    
//     // Mendapatkan ekstensi file
//     $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    
//     // Menentukan kategori berdasarkan ekstensi
//     $kategori = '';
//     switch($fileExt) {
//         case 'jpg':
//         case 'jpeg':
//         case 'png':
//             $kategori = 'gambar';
//             break;
//         case 'doc':
//         case 'docx':
//         case 'pdf':
//             $kategori = 'dokumen';
//             break;
//         case 'xls':
//         case 'xlsx':
//             $kategori = 'excel';
//             break;
//         default:
//             echo "<script>
//                     alert('Format file tidak didukung!');
//                     window.location.href = 'index.php';
//                   </script>";
//             exit;
//     }
    
//     // Array tipe MIME yang diizinkan
//     $allowedTypes = [
//         'gambar' => ['image/jpeg', 'image/png', 'image/jpg'],
//         'dokumen' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
//         'excel' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
//     ];
    
//     // Validasi tipe MIME
//     if(!in_array($file["type"], $allowedTypes[$kategori])) {
//         echo "<script>
//                 alert('Tipe file tidak sesuai!');
//                 window.location.href = 'index.php';
//               </script>";
//         exit;
//     }
    
//     // Generate nama file unik
//     $newFileName = uniqid() . '.' . $fileExt;
    
//     // Buat direktori jika belum ada
//     $uploadDir = "uploads/" . $kategori . "/";
//     if(!is_dir($uploadDir)) {
//         // Membuat direktori dengan mode 0777
//         mkdir($uploadDir, 0777, true);
//     }
    
//     // Upload file
//     $uploadPath = $uploadDir . $newFileName;
//     if(move_uploaded_file($file["tmp_name"], $uploadPath)) {
//         // Simpan ke database 
//         $query = "INSERT INTO files (judul, kategori, nama_file, ukuran, tipe, path, tanggal_upload, id_user) 
//                   VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
//         $stmt = mysqli_prepare($koneksi, $query);
//         mysqli_stmt_bind_param($stmt, "ssssssi", 
//             $judul,
//             $kategori,
//             $newFileName,
//             $file["size"],
//             $file["type"],
//             $uploadPath,
//             $_SESSION["id"]
//         );
        
//         if(mysqli_stmt_execute($stmt)) {
//             echo "<script>
//                     alert('File berhasil diupload!');
//                     window.location.href = 'index.php';
//                   </script>";
//         } else {
//             echo "<script>
//                     alert('Gagal menyimpan data ke database!');
//                     window.location.href = 'index.php';
//                   </script>";
//         }
//     } else {
//         echo "<script>
//                 alert('Gagal mengupload file!');
//                 window.location.href = 'index.php';
//               </script>";
//     }
// } else {
//     header('Location: index.php');
//     exit;
// }

if(isset($_POST["upload"])) {
    $judul = htmlspecialchars($_POST["judul"]);
    $files = $_FILES["file"];
    $uploadSuccess = 0;
    $uploadFailed = 0;
    
    // Loop through each uploaded file
    for($i = 0; $i < count($files["name"]); $i++) {
        $file = array(
            "name" => $files["name"][$i],
            "type" => $files["type"][$i],
            "tmp_name" => $files["tmp_name"][$i],
            "error" => $files["error"][$i],
            "size" => $files["size"][$i]
        );
        
        // Validasi ukuran file (5MB)
        $maxSize = 5 * 1024 * 1024;
        if($file["size"] > $maxSize) {
            $uploadFailed++;
            continue;
        }
        
        // Mendapatkan ekstensi file
        $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        
        // Menentukan kategori berdasarkan ekstensi
        $kategori = '';
        switch($fileExt) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                $kategori = 'gambar';
                break;
            case 'doc':
            case 'docx':
            case 'pdf':
                $kategori = 'dokumen';
                break;
            case 'xls':
            case 'xlsx':
                $kategori = 'excel';
                break;
            default:
                $uploadFailed++;
                continue 2;
        }
        
        // Array tipe MIME yang diizinkan
        $allowedTypes = [
            'gambar' => ['image/jpeg', 'image/png', 'image/jpg'],
            'dokumen' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'excel' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        ];
        
        // Validasi tipe MIME
        if(!in_array($file["type"], $allowedTypes[$kategori])) {
            $uploadFailed++;
            continue;
        }
        
        // Generate nama file unik
        $newFileName = uniqid() . '.' . $fileExt;
        
        // Buat direktori jika belum ada
        $uploadDir = "uploads/" . $kategori . "/";
        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Upload file
        $uploadPath = $uploadDir . $newFileName;
        if(move_uploaded_file($file["tmp_name"], $uploadPath)) {
            // Simpan ke database
            $query = "INSERT INTO files (judul, kategori, nama_file, ukuran, tipe, path, tanggal_upload, id_user) 
                      VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
            $stmt = mysqli_prepare($koneksi, $query);

            $judulFile = $judul . " (" . ($i + 1) . ")" ;

            mysqli_stmt_bind_param($stmt, "ssssssi", 
                $judulFile,
                $kategori,
                $newFileName,
                $file["size"],
                $file["type"],
                $uploadPath,
                $_SESSION["id"]
            );
            
            if(mysqli_stmt_execute($stmt)) {
                $uploadSuccess++;
            } else {
                $uploadFailed++;
            }
        } else {
            $uploadFailed++;
        }
    }
    
    // Tampilkan pesan hasil upload
    $message = "";
    if($uploadSuccess > 0) {
        $message .= "$uploadSuccess file berhasil diupload.\n";
    }
    if($uploadFailed > 0) {
        $message .= "$uploadFailed file gagal diupload.";
    }
    
    echo "<script>
            alert('$message');
            window.location.href = 'index.php';
          </script>";
    
} else {
    header('Location: index.php');
    exit;
}

?>   