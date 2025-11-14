<?php
include_once('templates/header.php');
include_once('function.php');

// Hanya ADMIN yang boleh akses halaman User
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
            alert('Halaman User hanya bisa diakses oleh Admin!');
            window.location.href = 'index.php';
          </script>";
    exit;
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Data User</h1>

<?php
// Simpan user baru
if(isset($_POST['simpan'])) {
    if(tambah_user($_POST) > 0) {
        echo '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>';
    }
}

// Ganti password
if (isset($_POST['ganti_password'])) {
    if (ganti_password($_POST) > 0) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Password berhasil diubah!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Password gagal diubah!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
    }
}
?>

</div>
<!-- /.container-fluid -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#tambahModal">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah User</span>
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>User Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $users = query("SELECT * FROM users");
                foreach($users as $user) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['user_role']; ?></td>
                        <td>
                            <button type="button" class="btn btn-info" 
                                    data-toggle="modal" 
                                    data-target="#gantiPassword" 
                                    data-id="<?= $user['id_user'] ?>">
                              Ganti Password
                            </button>

                            <a class="btn btn-success" href="edit-user.php?id=<?= $user['id_user']?>">Ubah</a>
                            <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" 
                               class="btn btn-danger" 
                               href="hapus-user.php?id=<?= $user['id_user'] ?>">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$query = mysqli_query($koneksi, "SELECT max(id_user) as kodeTerbesar FROM users");
$data = mysqli_fetch_assoc($query);
$KodeUser = $data['kodeTerbesar'];

$urutan = (int) substr($KodeUser, 3, 2);
$urutan++;

$huruf = "usr";
$KodeUser = $huruf . sprintf("%02s", $urutan);
?>

<!-- Modal Ganti Password -->
<div class="modal fade" id="gantiPassword" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form method="post" action="">
      <div class="modal-body">
            <input type="hidden" name="id_user" id="id_user">
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" class="form-control" name="password">
            </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        <button type="submit" name="ganti_password" class="btn btn-primary">Simpan</button>
      </div>
      </form>

    </div>
  </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form method="post" action="">
      <div class="modal-body">
            <input type="hidden" name="id_user" value="<?= $KodeUser ?>">

            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
                <label>User Role</label>
                <select class="form-control" name="user_role">
                    <option value="admin">Administrator</option>
                    <option value="operator">Operator</option>
                </select>
            </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
      </div>
      </form>

    </div>
  </div>
</div>

<?php include_once('templates/footer.php'); ?>
