<?php
require_once('koneksi.php');

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Tambah data tamu
function tambah_tamu($data) {
    global $koneksi;

    $kode        = htmlspecialchars($data["id_tamu"]);
    $tanggal     = date("Y-m-d");
    $nama_tamu   = htmlspecialchars($data["nama_tamu"]);
    $alamat      = htmlspecialchars($data["alamat"]);
    $no_hp       = htmlspecialchars($data["no_hp"]);
    $bertemu     = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);

    // Upload gambar
    $gambar = uploadGambar();
    if (!$gambar) {
        return 0;
    }

    $query = "INSERT INTO buku_tamu
              VALUES ('$kode', '$tanggal', '$nama_tamu', '$alamat', '$no_hp', '$bertemu', '$kepentingan', '$gambar')";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    return mysqli_affected_rows($koneksi);
}

// ubah data tamu
function ubah_tamu($data)
{
    global $koneksi;

    $id             = htmlspecialchars($data["id_tamu"]);
    $nama_tamu      = htmlspecialchars($data["nama_tamu"]);
    $alamat         = htmlspecialchars($data["alamat"]);
    $no_hp          = htmlspecialchars($data["no_hp"]);
    $bertemu        = htmlspecialchars($data["bertemu"]);
    $kepentingan    = htmlspecialchars($data["kepentingan"]);
    $gambarLama     = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = uploadGambar();
    }

$query = "UPDATE buku_tamu SET
          nama_tamu     = '$nama_tamu',
          alamat        = '$alamat',
          no_hp         = '$no_hp',
          bertemu       = '$bertemu',
          kepentingan   = 'kepentingan',
          gambar        = '$gambar'
          WHERE id_tamu = '$id'";
          
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    return mysqli_affected_rows($koneksi);
}

// hapus data tamu
function hapus_tamu($id) {
    global $koneksi;
    $query = "DELETE FROM buku_tamu WHERE id_tamu = '$id'";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// tambah data user
function tambah_user($data){
    global $koneksi;

    $kode           = htmlspecialchars($data["id_user"]);
    $username       = htmlspecialchars($data["username"]);
    $password       = htmlspecialchars($data["password"]);
    $user_role      = htmlspecialchars($data["user_role"]);


    $password_hash = password_hash($password,PASSWORD_DEFAULT);
    $query = "INSERT INTO users VALUES ('$kode', '$username', '$password_hash', '$user_role')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}   

// ubah data user
function ubah_user($data)
{
    global $koneksi;

    $kode           = htmlspecialchars($data["id_user"]);
    $username       = htmlspecialchars($data["username"]);
    $user_role      = htmlspecialchars($data["user_role"]);

    $query = "UPDATE users SET
              username      = '$username',
              user_role     = '$user_role'
              WHERE id_user = '$kode'";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// hapus data user
function hapus_user($id) {
    global $koneksi;
    $query = "DELETE FROM users WHERE id_user = '$id'";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// ganti password user
function ganti_password($data) {
    global $koneksi;

    $kode               = htmlspecialchars($data["id_user"]);
    $password           = htmlspecialchars($data["password"]);
    $password_hash      = password_hash($password,PASSWORD_DEFAULT);

    $query = "UPDATE users SET
              password      = '$password_hash'
              WHERE id_user = '$kode'";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// apload gambar
function uploadGambar() {
    // ambil data file gambar dari variable $_FILES
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diunggah
    if ($error === 4) {
        echo "<script>alert('pilih gambar terlebih dahulu!');</script>";
        return false;
    }

     // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang anda upload bukan gambar!');</script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
        return false;
    }

    // lolos pengecekan, generate nama file unik
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
    move_uploaded_file($tmpName, 'assets/upload_gambar/' . $namaFileBaru);

    return $namaFileBaru;
}

?>