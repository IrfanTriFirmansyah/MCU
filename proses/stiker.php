<?php

require "../conn/koneksi.php";


$id_peserta = $_GET['id_peserta'];
// $row['nama'] = $_GET['nama'];

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
    * {
      margin: 0;
      padding: 0;
    }
  </style>
</head>

<body>
  <table style="width: 100%;">

    <?php
    $id_paket = $row['id_paket'];
    $sql_package_examinations = "SELECT tipe_paket FROM tb_detail_paket WHERE id_paket = '$id_paket'";
    $result = $koneksi->query($sql_package_examinations);

    if ($result->num_rows > 0) {
      while ($rows = $result->fetch_assoc()) {
        $tipe_paket = $rows['tipe_paket'];


        switch ($tipe_paket) {
          
          case 'darah_lengkap':
            
    ?>
            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 12px;">DARAH </b><br><img src="../img/assets/darah.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'kimia_darah':
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 10px;">KIMIA KLINIK</b><br><img src="../img/assets/darah.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'hbsag_crm';
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 15px;">HbsAg</b><br><img src="../img/assets/darah.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'urine_lengkap':
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 12px;">URINE </b><br><img src="../img/assets/urine.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'tb_radiologi':
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 12px;">RONTGEN</b><br><img src="../img/assets/thorax.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'tb_ekg':
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 15px;">EKG</b><br><img src="../img/assets/ekg.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'tb_audiometri':
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 12px;">AUDIOMETRI</b><br><img src="../img/assets/ekg.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'tb_spirometri':
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 12px;">SPIROMETRI</b><br><img src="../img/assets/ekg.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <?php
            break;
          case 'tb_umum';
          ?>

            <tr style=" width: 100%;">
              <td style="vertical-align: top;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 14px;">MATA</b><br><img src="../img/assets/thorax.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 15px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="border: 1px solid black; width: 30%; vertical-align: middle; text-align: center;"><b style="font-size: 15px;">TENSI</b><br><img src="../img/assets/pemfis.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr style=" width: 100%;">
              <td style="vertical-align: top; padding-top: 3px;">
                <table style=" height: 70px; width: 100%; border-collapse: collapse;">
                  <tr>
                    <td style="width: 70%; height: 18px; border: 1px solid black;"><b style="font-size: 12px;"><?= $row['no_medrec'] ?></b></td>
                    <td rowspan="2" style="width: 30%; border: 1px solid black; vertical-align: middle; text-align: center;"><b style="font-size: 13px;">DOKTER</b><br><img src="../img/assets/pemfis.png" height="30px" alt=""></td>
                  </tr>
                  <tr>
                    <td style="font-size: 8px; border: 1px solid black;"><?= $row['nik'] ?>

                      (
                      <?php
                      if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                        echo "P";
                      } else {
                        echo "LK";
                      }
                      ?>
                      )</b><br><?= $row['nama'] ?> <br> <?= $row['tgl_lahir'] ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
    <?php
          default:
            break;
        }
      }
    }
    ?>
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