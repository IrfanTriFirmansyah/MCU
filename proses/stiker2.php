<?php

require "../conn/koneksi.php";

$id_peserta = $_GET['id_peserta'];
// $nama = $_GET['nama'];

$sql = mysqli_query($koneksi, "SELECT * FROM data_peserta JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta WHERE data_peserta.id_peserta = '$id_peserta'");
$row = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <style>
    @page {
      size: landscape;
    }

    .test {
      height: 95vh;
      width: 70px;
      font-size: 10px;
      writing-mode: vertical-rl;
      border-collapse: separate;
    }
  </style>
</head>

<body>
  <table class="test">
    <tr>
      <td style="width: 5px;">
        <span>.</span>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; height: 112px;">
        <b style="font-size: 15px;"><?= $row['no_medrec'] ?></b> <br>
        <?= $row['nik'] ?> <br>
        <b><?= $row['nama'] ?> (
          <?php
          if ($row['jenis_kelamin'] == 'PEREMPUAN') {
            echo "P";
          } else {
            echo "LK";
          }
          ?>
          )</b><br> <?=$row['tgl_lahir']?>
      </td>
      <td style="vertical-align: top; height: 130px;">
        <b style="font-size: 15px;"><?= $row['no_medrec'] ?></b> <br>
        <?= $row['nik'] ?> <br>
        <b><?= $row['nama'] ?> (
          <?php
          if ($row['jenis_kelamin'] == 'PEREMPUAN') {
            echo "P";
          } else {
            echo "LK";
          }
          ?>
          )</b><br> <?=$row['tgl_lahir']?>
      </td>
      <td style="vertical-align: top;">
        <b style="font-size: 15px;"><?= $row['no_medrec'] ?></b> <br>
        <?= $row['nik'] ?> <br>
        <b><?= $row['nama'] ?> (
          <?php
          if ($row['jenis_kelamin'] == 'PEREMPUAN') {
            echo "P";
          } else {
            echo "LK";
          }
          ?>
          )</b><br> <?=$row['tgl_lahir']?>
      </td>
    </tr>
  </table>
</body>

<script>
  window.onload = function() {
    window.print();
  }

  // Event listener untuk afterprint
  window.onafterprint = function() {
    window.location.href = '../view/daftar_peserta.php';
  }
</script>

</html>