<?php
session_start();
require 'functions.php';

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
          <li class="breadcrumb-item">2. Membayar</li>
          <li class="breadcrumb-item">3. Selesai</li>
        </ol>
      </nav>
    </div>
  </section>
  <section style="background-color: #181F31;">
    <div class="container pt-5" style="padding-bottom: 50px;">
      <form action="payment.php" method="post">
        <div class="row">
          <div class="col-md-8">
            <div class="card" style="margin-bottom: 0px; background-color: #212a42 !important; color: white; border: 1px solid #4c4c6d !important;">
              <div class="card-body">
                <h5 class="card-title">Detail Pemesanan</h5>
                <?php if (isset($_SESSION['email'])) : ?>
                  <?php $email = $_SESSION['email']; ?>
                  <?php $akun = query("SELECT * FROM users WHERE email='$email'")[0] ?>
                  <div class="alert alert-primary" role="alert" style="background-color: #33415c; color: white; border: 1px solid #33415c;">
                    Halo, <?= $akun['name'] ?>! Silahkan pesan tiket yang kamu pilih.
                  </div>
                <?php else : ?>
                  <div class="alert alert-primary" role="alert" style="background-color: #33415c; color: white; border: 1px solid #33415c;">
                    <a href="login.php" style="color: #FC8450">Log In</a> atau <a href="register" style="color: #FC8450">Daftar</a> untuk menikmati layanan eksklusif & benefit lain.
                  </div>
                <?php endif; ?>
                <input type="hidden" class="form-control" name="nama_kereta" value="<?= $_GET['train']; ?>">
                <input type="hidden" class="form-control" name="kelas" value="<?= $_GET['class']; ?>">
                <input type="hidden" class="form-control" name="waktu_keberangkatan" value="<?= $_GET['time-dept-arr']; ?>">
                <input type="hidden" class="form-control" name="waktu" value="<?= $_GET['time_dept']; ?>">
                <input type="hidden" class="form-control" name="stasiun_keberangkatan" value="<?= $_GET['dept_station']; ?>">
                <input type="hidden" class="form-control" name="stasiun_tujuan" value="<?= $_GET['arr_station']; ?>">
                <div class="form-group">
                  <label for="nama_pemesan">Nama Pemesanan</label>
                  <?php if (isset($_SESSION['email'])) : ?>
                    <input required type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" value="<?= $akun['name'] ?>">
                  <?php else : ?>
                    <input required type="text" class="form-control" id="nama_pemesan" name="nama_pemesan">
                  <?php endif; ?>
                  <small id="nama_pemesan_help" class="form-text text-muted">Seperti di KTP/Paspor/SIM (tanpa tanda baca dan gelar).</small>
                </div>
                <div class="form-group">
                  <label for="email_pemesan">Alamat Email</label>
                  <?php if (isset($_SESSION['email'])) : ?>
                    <input required type="email" class="form-control" id="email_pemesan" name="email_pemesan" value="<?= $akun['email'] ?>">
                  <?php else : ?>
                    <input required type="email" class="form-control" id="email_pemesan" name="email_pemesan">
                  <?php endif; ?>
                  <small id="email_pemesan_help" class="form-text text-muted">Tiket akan dikirim ke alamat email yang kamu isi.</small>
                </div>
              </div>
            </div>
            <div class="card mt-4" style="margin-bottom: 0px; background-color: #212a42 !important; color: white; border: 1px solid #4c4c6d !important;">
              <div class="card-body">
                <h5 class="card-title">Detail Penumpang</h5>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="jumlah_tiket">Jumlah Tiket</label>
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                            <span class="fa fa-minus"></span>
                          </button>
                        </span>
                        <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="10" readonly>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                            <span class="fa fa-plus"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <hr>
                    <div id="penumpang-1" class="form-group">
                      <div class="alert alert-info" role="alert">
                        Penumpang 1
                      </div>
                      <label for="nama_penumpang1">Nama Penumpang</label>
                      <input required type="text" class="form-control" id="nama_penumpang1" name="nama_penumpang[]">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card" style="margin-bottom: 0px; background-color: #212a42 !important; color: white; border: 1px solid #4c4c6d !important; position: sticky;">
              <div class="card-body">
                <h5 class="card-title">Kereta</h5>
                <h6><?= $_GET['train']; ?> - <?= $_GET['class']; ?></h6>
                <span><?= $_GET['dept_station'] . ' - ' . $_GET['arr_station'] ?> | <?= indo_day(date('N', strtotime($_GET['time-dept-arr']))) . ", " . $_GET['time-dept-arr']; ?> | <?= $_GET['time_dept']; ?></span>
                <hr />
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label><strong>Penumpang</strong></label>
                    </div>
                    <div class="col-md-6 text-right">
                      <p><span id="detail-jumlah-penumpang">1</span> orang</p>
                    </div>
                    <div class="col-md-6">
                      <label><strong>Harga</strong>/Tiket</label>
                    </div>
                    <div class="col-md-6 text-right">
                      <input name="detail_harga" type="hidden" id="detail-harga-hidden" value="<?= $_GET['price']; ?>">
                      <p>Rp <span id="detail-harga"><?= number_format($_GET['price']) ?></span></p>
                    </div>
                    <div class="col-md-6">
                      <label><strong>Kode Unik</strong></label>
                    </div>
                    <div class="col-md-6 text-right">
                      <input name="detail_harga_kode_unik" type="hidden" id="detail-harga-unik-hidden" value="<?= $_GET['unique-price']; ?>">
                      <p>Rp <span id="detail-kode-unik"><?= $_GET['unique-price']; ?></span></p>
                    </div>
                    <div class="col-md-12">
                      <hr>
                    </div>
                    <div class="col-md-6">
                      <label><strong>Harga Total</strong></label>
                    </div>
                    <div class="col-md-6 text-right">
                      <input name="detail_harga_total" type="hidden" id="detail-harga-total-hidden" value="<?= $_GET['price'] + $_GET['unique-price'] ?>">
                      <p>Rp <span id="detail-harga-total"><?= number_format($_GET['price'] + $_GET['unique-price']) ?></span></p>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-orange rounded-pill" style="color: white; font-size: 14px;">Lanjutkan pembayaran</button>
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

  <script>
    numberWithCommas = (x) => x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    let penumpang_list = ['nama_penumpang1']
    $('.btn-number').click(function(e) {
      e.preventDefault();

      fieldName = $(this).attr('data-field')
      type = $(this).attr('data-type')
      var input = $("input[name='" + fieldName + "']")
      var currentVal = parseInt(input.val())
      if (!isNaN(currentVal)) {
        if (type == 'minus') {
          let price = $('#detail-harga-hidden').val() * (currentVal - 1) + Number($('#detail-harga-unik-hidden').val())
          if (currentVal > input.attr('min')) input.val(currentVal - 1).change()
          if (parseInt(input.val()) == input.attr('min')) $(this).attr('disabled', true)
          penumpang_list.pop()
          $(`#penumpang-${currentVal}`).remove()
          $('#detail-jumlah-penumpang').html(currentVal - 1)
          $('#detail-harga-total-hidden').val(price)
          $('#detail-harga-total').html(numberWithCommas(price))
        } else if (type == 'plus') {
          let price = $('#detail-harga-hidden').val() * (currentVal + 1) + Number($('#detail-harga-unik-hidden').val())
          if (currentVal < input.attr('max')) input.val(currentVal + 1).change()
          if (parseInt(input.val()) == input.attr('max')) $(this).attr('disabled', true)
          penumpang_list.push(`nama_penumpang${currentVal + 1}`)
          $('#detail-jumlah-penumpang').html(currentVal + 1)
          $('#detail-harga-total-hidden').val(price)
          $('#detail-harga-total').html(numberWithCommas(price))
          $('#penumpang-1').append(`
          <div id="penumpang-${currentVal+1}" class="form-group mt-3">
            <div class="alert alert-info" role="alert">
              Penumpang ${currentVal+1}
            </div>
            <label for="nama_penumpang${currentVal+1}">Nama Penumpang</label>
            <input required type="text" class="form-control" id="nama_penumpang${currentVal+1}" name="nama_penumpang[]">
          </div>`)
        }
      } else input.val(0)
    })

    $('.input-number').focusin(function() {
      $(this).data('oldValue', $(this).val())
    })

    $('.input-number').change(function() {
      minValue = parseInt($(this).attr('min'))
      maxValue = parseInt($(this).attr('max'))
      valueCurrent = parseInt($(this).val())

      name = $(this).attr('name')
      if (valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
      } else {
        alert('Sorry, the minimum value was reached')
        $(this).val($(this).data('oldValue'))
      }
      if (valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
      } else {
        alert('Sorry, the maximum value was reached')
        $(this).val($(this).data('oldValue'))
      }
    });
    $(".input-number").keydown(function(e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault()
      }
    })
  </script>
</body>

</html>