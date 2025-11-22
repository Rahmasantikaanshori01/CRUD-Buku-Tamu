<?php
require 'koneksi.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // cek token valid
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE reset_token='$token'");
    if (mysqli_num_rows($query) === 1) {
        if (isset($_POST['submit'])) {
            $newpass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            mysqli_query($koneksi, "UPDATE users SET password='$newpass', reset_token=NULL WHERE reset_token='$token'");
            $success = "Password berhasil diubah. Silakan login kembali.";
        }
    } else {
        $error = "Token tidak valid atau sudah digunakan.";
    }
} else {
    header("Location: forgot_password.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <?php if (isset($success)) : ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php else : ?>
                <div class="card">
                    <div class="card-header text-center">Reset Password</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success mt-3">Simpan Password</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>