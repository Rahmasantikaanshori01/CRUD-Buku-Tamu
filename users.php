<?php
require_once('function.php');
include_once('templates/header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Data User</h1>

<?php
if(isset($_POST['simpan'])) {
    if(tambah_user($_POST) > 0) {
    ?>
        <div class="alert alert-success" role="alert">
            Data berhasil disimpan!
        </div>
    <?php
    } else {
    ?>
    <div class="alert alert-danger" role="alert">
        Data gagal disimpan!
    </div>
<?php
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
            <span class="text">Data User</span>
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
                        <td class="text-cente">
                            <!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#gantiPassword" data-id="<?= $user['id_user'] ?>">
  Ganti Password
</button>

                            <a class="btn btn-success" href="edit-user.php?id=<?= $user['id_user']?>">Ubah</a>
                            <a onclick="confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger" href="hapus-user.php?id=<?= $user['id_user'] ?>">Hapus</a>
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
$data = mysqli_fetch_array($query);
$KodeUser = $data['kodeTerbesar'];

$urutan = (int) substr($KodeUser, 3, 2);

$urutan++;

$huruf = "usr";
$KodeUser = $huruf . sprintf("%02s", $urutan);
?>



<!-- Modal -->
<div class="modal fade" id="gantiPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
                    <input type="hidden" name="id_user" id="id_user">
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Password Baru</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
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



<!-- Modal User -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
            <input type="hidden" name="id_user" value="<?= $KodeUser ?>">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="username" name="username">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="form-group row">
                <label for="user_role" class="col-sm-3 col-form-label">User Role</label>
                <div class="col-sm-8">
                    <select class="form-control" name="user_role" id="user_role">
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

<?php
include_once('templates/footer.php');
?>