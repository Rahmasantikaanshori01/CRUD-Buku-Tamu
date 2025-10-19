<?php
require_once 'function.php';

// jika ada id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapus_tamu($id) > 0) {
        echo "<script>alert('Data Berhasil di hapus!')</script>";
        echo "<script>window.location.href='buku-tamu.php'</script>";
    } else {
        echo "<script>alert('Data gagal di hapus!')</script>";
    }
}
?>