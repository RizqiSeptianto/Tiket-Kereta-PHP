<?php

session_start();
require 'functions.php';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if ($_GET['trans_id']) {
  $trans_id = $_GET['trans_id'];
  mysqli_query($connection, "UPDATE transactions SET is_success=1 WHERE id=$trans_id");
  $transaction = query("SELECT * FROM transactions WHERE id=$trans_id")[0];

  if (!$transaction) {
    header('Location: index.php');
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
  <link rel="stylesheet" href="./css/bootstrap-datepicker3.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <title>Triple-A Train</title>
</head>

<body>
  <?php require('_navbar.php'); ?>
  <section style="background-color: #181F31;">
    <div class="container">
      <nav>
        <ol class="breadcrumb justify-content-center" style="margin-bottom: 0px; background-color: #212a42 !important; color: white; border: 1px solid #4c4c6d !important;">
          <li class="breadcrumb-item active"><a href="#" style="text-decoration: none; cursor: default;">1. Memesan</a></li>
          <li class="breadcrumb-item active"><a href="#" style="text-decoration: none; cursor: default;">2. Membayar</a></li>
          <li class="breadcrumb-item active"><a href="#" style="text-decoration: none; cursor: default;">3. Selesai</a></li>
        </ol>
      </nav>
    </div>
  </section>
  <section style="background-color: #181F31;">
    <div class="container pt-5" style="padding-bottom: 50px;">
      <form action="ticket.php" method="post">
        <div class="row">
          <div class="col-md-12">
            <div class="card" style="margin-bottom: 0px; background-color: #212a42 !important; color: white; border: 1px solid #4c4c6d !important;">
              <div class="card-body">
                <h5 class="card-title">e-Ticket Kamu</h5>
                <?php if (isset($_SESSION['email'])) : ?>
                  <?php $email = $_SESSION['email']; ?>
                  <?php $akun = query("SELECT * FROM users WHERE email='$email'")[0] ?>
                  <div class="alert alert-primary" role="alert" style="background-color: #33415c; color: white; border: 1px solid #33415c;">
                    Halo, <?= $akun['name'] ?>! Berikut e-Ticket kamu.
                  </div>
                <?php else : ?>
                  <div class="alert alert-primary" role="alert" style="background-color: #33415c; color: white; border: 1px solid #33415c;">
                    Halo, <?= $transaction['booking_by']; ?>! Berikut e-Ticket kamu.
                  </div>
                      <h4>#<?= $trans_id; ?></h4>
                  <div class="alert alert-primary" role="alert" style="background-color: #33415c; color: white; border: 1px solid #33415c;">
                    Halo, Jhonson! Berikut e-Ticket kamu.
                  </div>
                <?php endif; ?>
                <hr />
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Kode Pemesanan</label>
                      <h4><?= $trans_id; ?></h4>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <h4><?= $transaction['train_name']; ?></h4>
                      <h6><?= $transaction['train_class']; ?></h6>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label>Tanggal Berangkat</label>
                    <h6><?= indo_day(date('N', strtotime($transaction['dept_time']))); ?>, <?= indo_date(date("Y-m-d", strtotime($transaction['dept_time']))) ?></h6>
                  </div>
                  <div class="col-md-3">
                    <label>Tanggal Tiba</label>
                    <h6><?= indo_day(date('N', strtotime($transaction['dept_time']))); ?>, <?= indo_date(date("Y-m-d", strtotime($transaction['dept_time']))) ?></h6>
                  </div>
                  <div class="col-md-3">
                    <label>Jam Berangkat</label>
                    <h6><?= $transaction['time'] ?></h6>
                  </div>
                  <div class="col-md-3">
                    <label>Jumlah Tiket</label>
                    <h6><?= $transaction['amount_ticket'] ?></h6>
                  </div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                  <?php $passengers = explode(",", $transaction['passengers_name']);
                  $count = 0; ?>
                  <div class="col-md-12">
                    <label><strong>Nama Penumpang</strong></label>
                    <?php foreach ($passengers as $passenger) : ?>
                      <label style="display: block;"><?= ++$count; ?>. <?= $passenger ?></label>
                    <?php endforeach; ?>
                  </div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                  <div class="col-md-6">
                    <label><strong>Harga</strong></label>
                  </div>
                  <div class="col-md-6 text-right">
                    <p>Rp <span><?= number_format($transaction['price']) ?></span></p>
                  </div>
                  <div class="col-md-6">
                    <label><strong>Biaya Layanan</strong></label>
                  </div>
                  <div class="col-md-6 text-right">
                    <p>Rp 0</p>
                  </div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                  <div class="col-md-6">
                    <label><strong>Harga Total</strong></label>
                  </div>
                  <div class="col-md-6 text-right">
                    <p>Rp <span><?= number_format($transaction['price']) ?></span></p>
                  </div>

                  <div>
                    <b style="background-color:#FC8450; padding-left:30px; padding-right:30px; border-radius:15px;">Pemesanan tiket selesai. Selamat menikmati perjalanan!</b>
                  </div>
                  <div class="col-md-12 mt-3">
                    ** Sebagai catatan :
                    <label class="text-white" style="display: block;">
                      1. e-Ticket merupakan elektronik tiket yang digunakan untuk mencetak tiket asli kamu pada saat di Stasiun.</br>
                      2. Simpan e-Ticket ini untuk melakukan pencetakan tiket asli di Stasiun.
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </form>
    </div>
  </section>
  <?php require('_footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
  <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>