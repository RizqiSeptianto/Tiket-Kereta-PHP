<?php
session_start();

$config = [
  'halaman' => 'Beranda', "harga" => 7000,
  'time_dept' => ['06:45', '09:15', '11:45', '14:15', '16:45', '19:45', '21:45']
];

require 'functions.php';

$stations = query("SELECT * FROM stations ORDER BY route");
$unique_price = rand(10, 100);
if ($_GET) {
  if (($_GET['station-dept']) && ($_GET['station-arr']) && ($_GET['time-dept-arr'])) {
    $trains = query("SELECT * FROM trains");
    $station_dept = $_GET['station-dept'];
    $station_arr = $_GET['station-arr'];

    $station_dept = query("SELECT * FROM stations WHERE name='$station_dept' LIMIT 1")[0];
    $station_arr = query("SELECT * FROM stations WHERE name='$station_arr' LIMIT 1")[0];

    if (!$station_dept || !$station_arr) {
      $errors['message'] = "Stasiun Keberangkatan / Stasiun Tujuan tidak ditemukan";
    } else {
      $class_list = query("SELECT * FROM class");
      $trains_result = [];
      $distance_station = $station_arr['route'] - $station_dept['route'];
      foreach ($trains as $train) {
        $travel_time = abs(10 * $distance_station);
        foreach ($config['time_dept'] as $time) {
          foreach ($class_list as $index => $class) {
            $time_dept_str = strtotime(($config['time_dept'][$index]));
            $temp_price = $train['price'] + ($config['harga'] * $distance_station) + $class['price'];
            array_push($trains_result, [
              'train' => $train['name'] . " " .  $class['name'][0] . $config['time_dept'][$index][0] . $config['time_dept'][$index][1],
              'class' => $class['name'],
              'dept_station' => $station_dept['name_short'],
              'arr_station' => $station_arr['name_short'],
              'dept' => $config['time_dept'][$index],
              'arr' => date("H:i", strtotime("+$travel_time minutes", $time_dept_str)),
              'price' => $temp_price
            ]);
          }
        }
      }
    }
  } else {
    $errors['message'] = "Sepertinya ada data yang belum diisi";
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
  <title>e-kereta</title>
</head>

<body>
  <?php require('_navbar.php'); ?>
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1 class="display-5 text-left">Pesan Tiket Kereta Kamu dengan Mudah di e-kereta</h1>
          <p class="lead">Dapatkan pengalaman memesan tiket kereta yang cepat dan mudah dengan aplikasi kami.</p>
        </div>
        <div class="col-md-6">
          <img class="ml-0" src=" ./img/train2.png" alt="Triple-A Train" style="overflow:auto; width: 300px; margin-top: 5px">
        </div>
      </div>
      <hr class="my-4">
      <p>Isi data-data di bawah untuk mencari tiket yang kamu mau :</p>
      <form method="GET" action="#train-details">
        <div class="row">
          <div class="col-md-4 mt-1">
            <select id="select-station-dept" class="form-control" name="station-dept">
              <option value="">- Stasiun Keberangkatan</option>
              <?php foreach ($stations as $station) : ?>
                <?php if (isset($_GET['station-dept'])) : ?>
                  <option value="<?= $station['name']; ?>" <?= ($station['name'] == $_GET['station-dept']) ? 'selected' : '' ?>><?= $station['name']; ?></option>
                <?php else : ?>
                  <option value="<?= $station['name']; ?>"><?= $station['name']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4 mt-1">
            <select id="select-station-arr" class="form-control" name="station-arr">
              <option value="">- Stasiun Tujuan</option>
              <?php foreach ($stations as $station) : ?>
                <?php if (isset($_GET['station-arr'])) : ?>
                  <option value="<?= $station['name']; ?>" <?= ($station['name'] == $_GET['station-arr']) ? 'selected' : '' ?>><?= $station['name']; ?></option>
                <?php else : ?>
                  <option value="<?= $station['name']; ?>"><?= $station['name']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4 mt-1">
            <input type="text" class="form-control" id="datepicker" placeholder=" - Hari/Tgl Keberangkatan" name="time-dept-arr" value="<?= isset($_GET['time-dept-arr']) ? $_GET['time-dept-arr'] : '' ?>">
          </div>
          <div class="col-md-9 mt-4">
            <?php if (isset($errors['message'])) : ?>
              <div class="alert alert-warning" role="alert" style="margin-bottom: 0px !important;"><?= $errors['message']; ?>!</div>
            <?php endif; ?>
          </div>
          <div class="col-md-3 mt-4 mb-0 pl-1">
            <button class="btn btn-orange btn-block rounded-pill" style="color: white; height: 50px;">Cari Kereta <i class="pl-2 fas fa-fw fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <section id="train-details" style="background-color: #1B2430;">
    <div class="container pt-5 pb-3">
      <h4 class="text-center text-light">- Jadwal kereta yang ditemukan -</h4>
      <?php if ($trains_result) : ?>
        <div class="row mt-4">
          <?php foreach ($trains_result as $train) : ?>
            <div class="col-md-12 mt-2">
              <div class="card card-train-details">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card-body">
                      <h5 class="card-title"><?= $train['train']; ?></h5>
                      <h6 class="card-subtitle mb-2 text-muted"><?= $train['class']; ?></h6>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card-body">
                      <h6><?= indo_day(date('N', strtotime($_GET['time-dept-arr']))) . ", " . indo_date(date("Y-m-d", strtotime($_GET['time-dept-arr']))) ?></h6>
                      <h6><?= $train['dept']; ?> -> <?= $train['arr']; ?></h6>
                      <h6 class="mb-2 text-muted"><?= $train['dept_station']; ?> -> <?= $train['arr_station']; ?></h6>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card-body text-right">
                      <h3>IDR <?= number_format($train['price']); ?></h3>
                      <a href="transactions.php?train=<?= $train['train']; ?>&class=<?= $train['class'] ?>&dept_station=<?= $train['dept_station'] ?>&arr_station=<?= $train['arr_station'] ?>&time-dept-arr=<?= $_GET['time-dept-arr'] ?>&time_dept=<?= $train['dept']; ?>&price=<?= $train['price']; ?>&unique-price=<?= $unique_price; ?>" class="btn btn-outline-orange rounded-pill" style="color: white;"><i class="fa fa-paper-plane" aria-hidden="true"></i> Pilih Paket</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <img class="mx-auto d-block" style="position: relative; height: 200px;" src="./img/train-404.png" alt="Search Train">
        <p class="mt-4 text-center text-light">- Tidak ditemukan -</p>
      <?php endif; ?>
    </div>
  </section>
  <?php require('_footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
  <script src="./js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#select-station-dept').on('change', function() {
        $("#select-station-arr").find("option").each(function() {
          $(this).removeAttr("disabled");
        });
        let arrStation = $('#select-station-arr').find('option[value="' + $(this).val() + '"]');
        if (arrStation.length) arrStation.attr('disabled', 'disabled');
      })
      $('#select-station-arr').on('change', function() {
        $("#select-station-dept").find("option").each(function() {
          $(this).removeAttr("disabled");
        });
        let deptStation = $('#select-station-dept').find('option[value="' + $(this).val() + '"]');
        if (deptStation.length) deptStation.attr('disabled', 'disabled');
      })
      $('#datepicker').datepicker({
        startDate: new Date(),
        orientation: 'bottom',
        todayHighlight: true
      })
    })
  </script>
</body>

</html>