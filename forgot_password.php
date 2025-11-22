<?php
require 'koneksi.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];

    // cek apakah username ada di database
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($query) > 0) {
        // buat token unik
        $token = md5(uniqid(rand(), true));
        mysqli_query($koneksi, "UPDATE users SET reset_token='$token' WHERE username='$username'");

        // redirect ke halaman reset password
        header("Location: reset_password.php?token=$token");
        exit;
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header text-center">Lupa Password</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Masukkan Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary mt-3">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>