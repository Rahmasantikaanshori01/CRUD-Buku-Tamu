<?php
require 'koneksi.php';

if (isset($_POST['register'])) {
    $id_user   = $_POST['id_user'];
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $role      = $_POST['role'];

    // hash password agar aman
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // simpan ke database
    $query = "INSERT INTO users (id_user, username, password, user_role) 
              VALUES ('$id_user', '$username', '$hashedPassword', '$role')";
    if (mysqli_query($koneksi, $query)) {
        echo "<div class='alert alert-success'>Akun berhasil dibuat. Silakan login.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal membuat akun: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Create Account</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label>ID User</label>
                            <input type="text" name="id_user" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="operator">Operator</option>
                            </select>
                        </div>
                        <button type="submit" name="register" class="btn btn-success mt-3">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>