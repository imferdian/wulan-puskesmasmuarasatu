<?php

$koneksi = mysqli_connect("localhost", "root", "", "puskesmas_muara_satu");

function query($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function hapus($id){
    global $koneksi;
    
    // Ambil semua file yang dimiliki oleh user yang akan dihapus
    $query = "SELECT path FROM files WHERE id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Hapus semua file fisik
    while($file = $result->fetch_assoc()) {
        if(file_exists("../" . $file['path'])) {
            unlink("../" . $file['path']);
        }
    }

    // Hapus data user
    $query = "DELETE FROM users WHERE id_user = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_affected_rows($stmt);
}


function hapus_dokumen($id){
    global $koneksi;
    
    // Ambil informasi file sebelum dihapus
    $query = "SELECT path FROM files WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $file = mysqli_fetch_assoc($result);
    
    // Hapus file fisik jika ada
    if($file && file_exists("../" . $file['path'])) {
        unlink("../" . $file['path']);
    }
    
    // Hapus record dari database
    $query = "DELETE FROM files WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    return mysqli_affected_rows($koneksi);
}


function register($data) {
    global $koneksi;
    
    // Validasi input
    if (empty($data["nama"]) || empty($data["nip"]) || empty($data["password"])) {
        echo "<script>alert('Semua field harus diisi!');</script>";
        return false;
    }

    // Sanitasi input
    $nama = strtolower(strip_tags($data["nama"]));
    $nip = mysqli_real_escape_string($koneksi, $data["nip"]);
    $golongan = mysqli_real_escape_string($koneksi, $data["golongan"]);
    $jabatan = mysqli_real_escape_string($koneksi, $data["jabatan"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
    $kode_role = mysqli_real_escape_string($koneksi, $data["role"]);

    // Cek NIP duplikat
    $result = mysqli_query($koneksi, "SELECT nip FROM users WHERE nip = '$nip'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal',
            text: 'NIP Sudah Terdaftar',
            confirmButtonText: 'Coba Lagi'
        }).then((result) => {
            if (result.isConfirmed) {
                window.history.back();
            }
        });
        </script>";
        exit;
    } 

    // Tentukan role
    $kode_role_admin = "ADM123";
    
    // Validasi kode role admin
    if (!empty($kode_role)) {
        if ($kode_role === $kode_role_admin) {
            $role = "admin";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Registrasi Gagal',
                    text: 'Kode role salah! Silakan masukkan kode role yang benar atau kosongkan jika Anda bukan admin.',
                    confirmButtonText: 'Coba Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();
                    }
                });
                </script>";
            exit;
        }
    } else {
        $role = "pegawai";
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambah user baru
    $query = "INSERT INTO users (nama, nip, golongan, jabatan, password, role) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $nama, $nip, $golongan, $jabatan, $password, $role);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}


function ubah($data)
{
    global $koneksi;

    // validasi input
    if(empty($data["nip"]) || empty($data["nama"]) ){
        echo "<script>alert('Data tidak boleh kosong');
        window.history.back();
        </script>";
        return false;
    }

    // sanitasi input
    $id = mysqli_real_escape_string($koneksi, $data["id"]);
    $nip = htmlspecialchars($data["nip"]);
    $nama = htmlspecialchars($data["nama"]);
    $golongan = htmlspecialchars($data["golongan"]);
    $jabatan = htmlspecialchars($data['jabatan']);
    
    // Cek NIP duplikat  (kecuali untuk user yang sedang diedit)
    $kueri = "SELECT nip FROM users WHERE nip = '$nip' AND id_user != $id";
    $result = mysqli_query($koneksi, $kueri);
    if(mysqli_fetch_assoc($result)){
        echo "<script>alert('NIP Sudah Terdaftar');
        window.history.back();
        </script>";
        return false;
    }

    // Query Update data menggunakan prepared steatment
    $query = "UPDATE users SET
    nip = ?,
    nama = ?,
    golongan = ?,
    jabatan = ?
    WHERE id_user = ?
    ";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $nip, $nama, $golongan, $jabatan, $id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}

function checkCookie() {
    global $koneksi;
    
    if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];
        
        // Ambil data user berdasarkan id
        $result = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id'");
        $row = mysqli_fetch_assoc($result);
        
        // Cek cookie dan nip
        if($key === hash('sha256', $row['nip'])) {
            // Set session
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['id'] = $row['id_user'];
            $_SESSION['login'] = true;
            $_SESSION['role'] = $row['role'];
            return true;
        }
    }
    return false;
}
