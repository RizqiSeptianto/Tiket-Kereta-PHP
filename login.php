<?php
session_start();

if (isset($_SESSION['email'])) header('Location: index.php');

require('functions.php');
$pesan_error = "";
if ($_POST) {
  $email = strtolower($_POST['email']);
  $password = $_POST['password'];
  if (!$email || !$password) {
    $pesan_error = "Alamat Email dan Password diperlukan.";
  } else {
    $result = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
      $result = mysqli_fetch_assoc($result);

      if (password_verify($password, $result['password'])) {
        $_SESSION["name"] = $result['name'];
        $_SESSION["email"] = $result['email'];
        header("Location: index.php");
        exit();
      } else {
        $pesan_error = "Alamat Email dan Password salah atau tidak ditemukan.";
      }
    } else {
      $pesan_error = "Alamat Email dan Password salah atau tidak ditemukan.";
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
          <h3>Masuk Yuk ke e-kereta</h3>
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
          <?php endif; ?>
          <form method="POST">
            <div class="form-group">
              <label for="alamat_email">Alamat Email</label>
              <input type="email" class="form-control" id="alamat_email" aria-describedby="emailHelp" name="email">
              <small id="emailHelp" class="form-text text-muted">Kita tidak pernah membagikan alamat email kamu ke orang
                lain.</small>
            </div>
            <div class="form-group">
              <label for="passowrd">Password</label>
              <input type="password" class="form-control" id="passowrd" name="password">
            </div>
            <button type="submit" class="btn btn-orange btn-block rounded-pill" style="color: white;">Masuk</button>
            <hr>
            <a class="btn btn-secondary btn-block rounded-pill" href="register.php">Registrasi ke e-kereta</a>
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