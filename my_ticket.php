<?php
session_start();
if (!isset($_SESSION['email'])) header('Location: login.php');
require 'functions.php';

$email = $_SESSION['email'];
$akun = query("SELECT * FROM users WHERE email='$email'")[0];
$user_id = $akun['id'];
// $akun_birthdate = $akun['birthdate'];
// $akun_birthdate = explode('-', $akun_birthdate);
// $akun_birthdate = $akun_birthdate[1] . '-' . $akun_birthdate[2] . '-' . $akun_birthdate[0];
if ($_POST) {
  $name = ucwords($_POST['name']);
  $birthdate = $_POST['birthdate'];
  $gender = $_POST['gender'];

  if (!$name || !$birthdate || !$gender || $gender == "Pilih jenis kelamin") {
    $pesan_error = "Nama Pengguna, Tanggal Lahir, atau Jenis Kelamin diperlukan.";
  } else {
    // $birthdate = explode('/', $birthdate);
    // $birthdate = $birthdate[2] . '-' . $birthdate[1] . '-' . $birthdate[0];
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
              <a href="account.php" class="btn btn-light btn-block text-left mt-4"><i class="fas fa-cog" style="margin-right: 10px;"></i>Pengaturan Saya</a>
              <a href="my_ticket.php" class="btn btn-light btn-block text-left active"><i class="fas fa-sticky-note" style="margin-right: 10px;"></i>Tiket Saya</a>
              <a href="logout.php" class="btn btn-light btn-block text-left"><i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i>Keluar</a>
            </div>
          </div>
        </div>
        <div class="col-md-9" style='background-color: #212a42; color: white; border: 1px solid #4c4c6d !important;'>
          <div class="card" style="background-color: #212a42; color: white;">
            <?php
            $tickets = query("SELECT * FROM transactions WHERE user_id=$user_id"); ?>
            <div class="card-body">
              <h5 class="mt-3">Berikut tiket yang pernah kamu pesan :</h5>
              <?php if ($tickets) : ?>
                <ul class="list-group">
                  <?php foreach ($tickets as $ticket) : ?>
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-md-6">
                          Order #<?= $ticket['id']; ?>
                        </div>
                        <div class="col-md-6 text-right">
                          <a href="./ticket.php?trans_id="<?= $ticket['id']; ?>">Cek Tiket</a>
                        </div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php else : ?>
                <div class="alert alert-info mt-3" role="alert">
                  Kamu belum pernah melalukan pemesanan tiket apapun :(
                </div>
              <?php endif; ?>
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