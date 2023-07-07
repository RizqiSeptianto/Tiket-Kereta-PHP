<?php

session_start();
require 'functions.php';

if ($_POST) {
  $dept = $_POST['stasiun_keberangkatan'];
  $dept_station = query("SELECT * FROM stations WHERE name_short='$dept'")[0];
  $arr = $_POST['stasiun_tujuan'];
  $arr_station = query("SELECT * FROM stations WHERE name_short='$arr'")[0];

  $random = random_int(100000, 999999);
  $current_time = time();

  $train_name = $_POST['nama_kereta'];
  $train_class = $_POST['kelas'];

  $dept_time = $_POST['waktu_keberangkatan'];
  $dept_time = explode("/", $dept_time);
  $dept_time = $dept_time[2] . "-" . $dept_time[0] . "-" . $dept_time['1'];

  $time = $_POST['waktu'];
  $unique_price = $_POST['detail_harga_kode_unik'];
  $passengers_name = implode(",", $_POST['nama_penumpang']);
  $booking_by = $_POST['nama_pemesan'];
  $email_pemesan = $_POST['email_pemesan'];
  $amount_ticket = $_POST['quant'][1];

  $price = $_POST['detail_harga_total'];

  if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $akun = query("SELECT * FROM users WHERE email='$email'")[0];
    $akun_id = $akun['id'];

    $order = "INSERT INTO transactions VALUES('$random', '$akun_id', '$booking_by', '$email_pemesan', '$passengers_name', '$amount_ticket', '$train_name', '$train_class', '$dept_time', '$time', '$dept', '$arr', $unique_price, $price, $current_time, 0)";
  } else {
    $order = "INSERT INTO transactions VALUES('$random', '', '$booking_by', '$email_pemesan', '$passengers_name', '$amount_ticket', '$train_name', '$train_class', '$dept_time', '$time', '$dept', '$arr', $unique_price, $price, $current_time, 0)";
  }

  $order = mysqli_query($connection, $order);
  if ($order) {
    header("Location: payment.php?trans_id=$random");
  }
}

if ($_GET['trans_id']) {
  $trans_id = $_GET['trans_id'];
  $transaction = query("SELECT * FROM transactions WHERE id=$trans_id")[0];

  if (!$transaction) {
    header('Location: index.php');
  } else {
    $train_name = $transaction['train_name'];
    $train_class = $transaction['train_class'];

    $dept_time = $transaction['dept_time'];

    $time = $transaction['time'];
    $booking_by = $transaction['booking_by'];
    $email_pemesan = $transaction['email'];
    $amount_ticket = $transaction['amount_ticket'];

    $dept = $transaction['station_dept'];
    $dept_station = query("SELECT * FROM stations WHERE name_short='$dept'")[0];
    $arr = $transaction['station_arr'];
    $arr_station = query("SELECT * FROM stations WHERE name_short='$arr'")[0];

    $price = $transaction['price'];
    $random = $_GET['trans_id'];

    $_POST['detail_harga_kode_unik'] = $transaction['unique_price'];
    $_POST['detail_harga_total'] = $transaction['price'];
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
          <li class="breadcrumb-item active"><a href="#">1. Memesan</a></li>
          <li class="breadcrumb-item active"><a href="#">2. Membayar</a></li>
          <li class="breadcrumb-item">3. Selesai</li>
        </ol>
      </nav>
    </div>
  </section>
  <section style="background-color: #181F31;">
    <div class="container pt-5" style="padding-bottom: 50px;">
      <form action="ticket.php" method="post">
        <div class="row">
          <div class="col-md-8">
            <div class="card" style="margin-bottom: 0px; background-color: #212a42 !important; color: white; border: 1px solid #4c4c6d !important;">
              <div class="card-body">
                <h5 class="card-title">Metode Pembayaran</h5>
                <div class="alert alert-primary" role="alert" style="background-color: #33415c; color: white; border: 1px solid #33415c;">
                  <a href="login.php" style="color: #FC8450">Log In</a> atau <a href="register" style="color: #FC8450">Daftar</a> untuk menyimpan daftar pemesanan kamu.
                </div>
                <div class="accordion" id="accordion_payment">
                  <div class="card" style="background-color: #33415c !important; color: white;">
                    <div class="card-header" id="headingOne" style="padding: .75rem .50rem; background-color: #425579 !important;">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="text-decoration: none;">
                          <img class="img-thumbnail" src="https://cdn.worldvectorlogo.com/logos/bca-bank-central-asia.svg" alt="BCA Virtual Account" style="height: 57px; margin-right: 29px;"> BCA Virtual Account
                        </button>
                      </h2>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_payment">
                      <div class="card-body">
                        Silahkan transfer pembayaran ke Virtual Rekening BCA Berikut:
                        <table class="table" style="margin-bottom: 0;">
                          <tbody>
                            <tr>
                              <td class="text-white">Nomor Rekenening</td>
                              <td class="text-warning">191063125</td>
                            </tr>
                            <tr>
                              <td class="text-white">Atas Nama</td>
                              <td class="text-white">PT Triple-A Train</td>
                            </tr>
                            <tr>
                              <td class="text-white">Jumlah</td>
                              <td class="text-white">IDR <?= explode($_POST['detail_harga_kode_unik'], number_format($_POST['detail_harga_total']))[0]; ?><span class="text-warning"><?= $_POST['detail_harga_kode_unik']; ?></span></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <p class="text-center" style="color: #FC8450;">Mohon transfer sesuai dengan yang tertera!</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card" style="background-color: #33415c !important; color: white;">
                    <div class="card-header" id="headingFour" style="padding: .75rem .50rem; background-color: #425579 !important;">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="text-decoration: none;">
                          <img class="img-thumbnail" src="https://infobanknews.com/wp-content/uploads/2018/05/logo-BNI-46-1.png" alt="OVO Transfer" style="height: 89px; margin-right: 29px;"> BNI Virtual Account
                        </button>
                      </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion_payment">
                      <div class="card-body">
                        Silahkan transfer pembayaran ke Virtual Rekening BNI Berikut:
                        <table class="table" style="margin-bottom: 0;">
                          <tbody>
                            <tr>
                              <td class="text-white">Nomor Rekening</td>
                              <td class="text-warning">191063125</td>
                            </tr>
                            <tr>
                              <td class="text-white">Atas Nama</td>
                              <td class="text-white">PT Triple-A Train</td>
                            </tr>
                            <tr>
                              <td class="text-white">Jumlah</td>
                              <td class="text-white">IDR <?= explode($_POST['detail_harga_kode_unik'], number_format($_POST['detail_harga_total']))[0]; ?><span class="text-warning"><?= $_POST['detail_harga_kode_unik']; ?></span></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <p class="text-center" style="color: #FC8450;">Mohon transfer sesuai dengan yang tertera!</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card" style="background-color: #33415c !important; color: white;">
                    <div class="card-header" id="headingTwo" style="padding: .75rem .50rem; background-color: #425579 !important;">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration: none;">
                          <img class="img-thumbnail" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" alt="DANA Transfer" style="height: 52.5px; margin-right: 30px;"> DANA Transfer
                        </button>
                      </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion_payment">
                      <div class="card-body">
                        Silahkan transfer pembayaran ke DANA Berikut:
                        <table class="table" style="margin-bottom: 0;">
                          <tbody>
                            <tr>
                              <td class="text-white">Nomor DANA</td>
                              <td class="text-warning">191063125</td>
                            </tr>
                            <tr>
                              <td class="text-white">Atas Nama</td>
                              <td class="text-white">PT Triple-A Train</td>
                            </tr>
                            <tr>
                              <td class="text-white">Jumlah</td>
                              <td class="text-white">IDR <?= explode($_POST['detail_harga_kode_unik'], number_format($_POST['detail_harga_total']))[0]; ?><span class="text-warning"><?= $_POST['detail_harga_kode_unik']; ?></span></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <p class="text-center" style="color: #FC8450;">Mohon transfer sesuai dengan yang tertera!</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card" style="background-color: #33415c !important; color: white;">
                    <div class="card-header" id="headingThree" style="padding: .75rem .50rem; background-color: #425579 !important;">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="text-decoration: none;">
                          <img class="img-thumbnail" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" alt="OVO Transfer" style="height: 57px; margin-right: 29px;"> OVO Transfer
                        </button>
                      </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion_payment">
                      <div class="card-body">
                        Silahkan transfer pembayaran ke Rekening OVO Berikut:
                        <table class="table" style="margin-bottom: 0;">
                          <tbody>
                            <tr>
                              <td class="text-white">Nomor OVO</td>
                              <td class="text-warning">191063125</td>
                            </tr>
                            <tr>
                              <td class="text-white">Atas Nama</td>
                              <td class="text-white">PT Triple-A Train</td>
                            </tr>
                            <tr>
                              <td class="text-white">Jumlah</td>
                              <td class="text-white">IDR <?= explode($_POST['detail_harga_kode_unik'], number_format($_POST['detail_harga_total']))[0]; ?><span class="text-warning"><?= $_POST['detail_harga_kode_unik']; ?></span></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <p class="text-center" style="color: #FC8450;">Mohon transfer sesuai dengan yang tertera!</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <label class="mt-2">Anda bisa membayar melalui Metode Pembayaran yang tersedia.</label>
                </div>
                <hr>
                <span>Apabila sudah dibayar maka silahkan konfirmasi menggunakan tombol berikut, setelah itu sistem akan otomatis mengkonfirmasi pembayaran kamu.</span>
                <div class="row">
                  <div class="col-md-8"></div>
                  <div class="col-md-4">
                    <a class="btn btn-orange mt-2 text-white rounded-pill" href="ticket.php?trans_id=<?= $random; ?>" style="display: block;">Lanjutkan</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card" style="margin-bottom: 0px; background-color: #212a42 !important; color: white; border: 1px solid #4c4c6d !important; position: sticky;">
              <div class="card-body">
                <h5 class="card-title">Detail Pemesanan</h5>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <h6>Tujuan</h6>
                  </div>
                  <div class="col-md-8 text-right">
                    <?= $dept_station['name']; ?> - <?= $arr_station['name']; ?>
                  </div>
                  <div class="col-md-4">
                    Order ID
                  </div>
                  <div class="col-md-8 text-right">
                    <?= $random; ?>
                  </div>
                  <div class="col-md-12">
                    <hr />
                  </div>
                  <div class="col-md-6">
                    <label><strong>Harga Total</strong></label>
                  </div>
                  <div class="col-md-6 text-right">
                <!--<input name="detail_harga_total" type="hidden" id="detail-harga-total-hidden" value="<?= $_GET['price']; ?>">-->
                  
                 
                    <p>IDR <span id="detail-harga-total"><?= explode($_POST['detail_harga_kode_unik'], number_format($_POST['detail_harga_total']))[0]; ?><span class="text-warning"><?= $_POST['detail_harga_kode_unik']; ?></span></span></p>
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