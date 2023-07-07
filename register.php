<?php
session_start();

if (isset($_SESSION['email'])) header('Location: index.php');

require('functions.php');
$pesan_error = "";
if ($_POST) {
  $name = ucwords($_POST['name']);
  $email = strtolower($_POST['email']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (!$name || !$email || !$password || !$confirm_password) {
    $pesan_error = "Alamat Email, Nama Pengguna, Password atau Konfirmasi Password diperlukan.";
  } else {
    if ($password !== $confirm_password) {
      $pesan_error = "Password dan Konfirmasi Password tidak sama!";
    } else {
      $result = mysqli_query($connection, "SELECT email FROM users WHERE email='$email'");
      if (mysqli_fetch_assoc($result)) {
        $pesan_error = "Alamat Email sudah digunakan oleh pengguna lain.";
      } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($connection, "INSERT INTO users VALUES('', '$name', '$email', '$password', '' , '')");
        $register_status = mysqli_affected_rows($connection);
      }
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
  <section style="background-color: #1A2132 !important; height: 90%; display: block; box-sizing: border-box;">
    <div class="container pt-4">
      <div class="text-center pb-4">
        <span class="text-light" style="font-weight: 400; color: black;">
          <h3>Registrasi Yuk ke e-kereta</h3>
        </span>
      </div>
      <div class="card card-train" style="border-radius: 20px; padding: 8px;">
        <div class="card-body">
          <?php if ($_POST && $pesan_error !== "") : ?>
            <div class="alert alert-warning" role="alert">
              <?= $pesan_error; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php elseif ($_POST && $register_status == 1) : ?>
            <div class="alert alert-info" role="alert">
              Register berhasil! Silahkan login untuk melanjutkan!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>
          <form method="POST">
            <div class="form-group">
              <label for="alamat_email">Alamat Email</label>
              <input type="text" class="form-control" name="email" id="alamat_email">
            </div>
            <div class="form-group">
              <label for="nama_lengkap">Nama Lengkap</label>
              <input type="text" class="form-control" name="name" id="nama_lengkap">
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" id="password">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="konfirmasi_password">Konfirmasi Password</label>
                  <input type="password" class="form-control" name="confirm_password" id="konfirmasi_password">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-orange btn-block rounded-pill mt-4" style="color: white;">Registrasi</button>
            <hr>
            <a class="btn btn-secondary btn-block rounded-pill" href="login.php">Masuk ke e-kereta</a>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php require('_footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>