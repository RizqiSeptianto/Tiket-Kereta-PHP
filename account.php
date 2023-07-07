<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('Location: login.php');
} 
require 'functions.php';


$email = $_SESSION['email'];
$akun = query("SELECT * FROM users WHERE email='$email'")[0];

if ($_POST) {
  $name = ucwords($_POST['name']);
  $birthdate = $_POST['birthdate'];
  $gender = $_POST['gender'];

  if (!$name || !$birthdate || !$gender || $gender == "Pilih jenis kelamin") {
    $pesan_error = "Nama Pengguna, Tanggal Lahir, atau Jenis Kelamin diperlukan.";
  } else {
    $query_update = "UPDATE users SET name='$name', birthdate='$birthdate', gender='$gender' WHERE email='$email'";
    if (mysqli_query($connection, $query_update)) {
      $has_update = true;
      $akun = query("SELECT * FROM users WHERE email='$email'")[0];
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <title>Triple-A Train</title>
</head>

<body>
  <?php require('_navbar.php'); ?>
  <section style="background-color: #181F31;">
    <div class="container">
      <div class="row pt-4">
        <div class="col-md-3">
          <div class="card" style="min-height: 82.1vh; background-color: #212a42; color: white; border: 1px solid #4c4c6d !important;">
            <div class="card-body">
              <img src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png" class="border-radius: 50%;" style="height: 80px;">
              <h5 class="card-title"><?= $akun['name']; ?></h5>
              <h6 class="card-subtitle mb-2 text-muted">Member</h6>
              <a href="account.php" class="btn btn-light btn-block text-left mt-4 active"><i class="fas fa-cog" style="margin-right: 10px;"></i>Pengaturan Saya</a>
              <a href="my_ticket.php" class="btn btn-light btn-block text-left"><i class="fas fa-sticky-note" style="margin-right: 10px;"></i>Tiket Saya</a>
              <a href="logout.php" class="btn btn-light btn-block text-left"><i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i>Keluar</a>
            </div>
          </div>
        </div>
        <div class="col-md-9" style='background-color: #212a42; color: white; border: 1px solid #4c4c6d !important;'>
          <div class="card" style="background-color: #212a42; color: white;">
            <div class="card-body">
              <?php if ($_POST) : ?>
                <?php if (isset($has_update)) : ?>
                  <div class="alert alert-success" role="alert">
                    Berhasil! Data akun berhasil diubah.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php elseif ($pesan_error) : ?>
                  <div class="alert alert-warning" role="alert">
                    <?= $pesan_error ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php else : ?>
                  <div class="alert alert-warning" role="alert">
                    Maaf! Data akun gagal diubah.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
              <form method="POST">
                <div class="row pt-3">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alamat_email">Alamat Email</label>
                      <input type="email" class="form-control" id="alamat_email" value="<?= $akun['email']; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama_pengguna">Nama Pengguna</label>
                      <input name="name" type=" text" class="form-control" id="nama_pengguna" value="<?= $akun['name']; ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal_lahir">Tanggal Lahir</label>
                      <input name="birthdate" type="date" class="form-control" id="tanggal_lahir" value="<?= $akun['birthdate'] ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="jenis_kelamin">Jenis Kelamin</label>
                      <select name="gender" class="custom-select" id="jenis_kelamin">
                        <option>Pilih jenis kelamin</option>
                        <option value="pria" <?= strtolower($akun['gender']) == "pria" ? "selected" : "" ?>>Pria</option>
                        <option value="wanita" <?= strtolower($akun['gender']) == "wanita" ? "selected" : "" ?>>Wanita</option>
                      </select>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-orange btn-block rounded-pill text-white">Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php require('_footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>