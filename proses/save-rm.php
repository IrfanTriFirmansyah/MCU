<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}

// error_reporting(0);
// ini_set('display_errors', 0);

$no_medrec = $_GET['no_medrec'];

require "../conn/koneksi.php";


$van = mysqli_query($koneksi, "SELECT * FROM data_peserta
JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
JOIN tb_per ON data_peserta.id_per = tb_per.id_per
JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
WHERE rekam_mcu.no_medrec = '$no_medrec'");

$sql = mysqli_fetch_array($van);

$vans = mysqli_query($koneksi, "
    SELECT * FROM rekam_mcu
    LEFT JOIN tb_umum ON rekam_mcu.no_medrec = tb_umum.no_medrec
    LEFT JOIN tb_lab ON rekam_mcu.no_medrec = tb_lab.no_medrec
    LEFT JOIN tb_audiometri ON rekam_mcu.no_medrec = tb_audiometri.no_medrec
    LEFT JOIN tb_spirometri ON rekam_mcu.no_medrec = tb_spirometri.no_medrec
    LEFT JOIN tb_radiologi ON rekam_mcu.no_medrec = tb_radiologi.no_medrec
    LEFT JOIN tb_ekg ON rekam_mcu.no_medrec = tb_ekg.no_medrec
    WHERE rekam_mcu.no_medrec = '$no_medrec'
");

$sqls = mysqli_fetch_array($vans);

$dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE aktif='2'");
$tkd = mysqli_fetch_array($dokter);


$waktu_daftar = $sqls['waktu_daftar'];
$tgl_dft = date('d-m-Y H:i:s', strtotime($waktu_daftar));

?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Cetak</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="../img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <link href="../css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <style>
        @media print {

            /* Mengatur orientasi kertas menjadi landscape */
            @page {
                size: portrait;
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .bg {
            background-image: url(../img/photos/bg.jpg);
            background-repeat: no-repeat;
            background-position: center;
        }

        .jdl {
            font-size: 17px;
            /* font-weight: bold; */
            /* padding: 3px; */
        }

        .jdl-1 {
            font-size: 20px;
            font-weight: bold;
            padding: 3px;
        }

        .jdl-pem {
            font-size: 20px;
            font-weight: bold;
        }

        #autoResizeTextarea {
            height: 100%;
            width: 100%;
            /* Sesuaikan lebar sesuai kebutuhan */
            overflow: hidden;
            /* Hilangkan scrollbar */
            resize: none;
            /* Matikan resize manual */
        }
    </style>
</head>

<body>
    <div class="row">





        <div class="col-12 w-100 " style=" height: 100vh;">
            <table style="border-collapse: collapse; width: 100%;">
                <tr>
                    <td style="width: 100px; background-color: orangered;">&nbsp;</td>
                    <td style="text-align: center; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="height: 200px; vertical-align: bottom;">
                                    <img src="../img/icons/icon-48x48.png" width="120px" height="120px" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 100px;">
                                    <h1 style="font-size: 35px; font-weight: bold;">MEDICAL CHECK UP</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 570px; vertical-align: top;">
                                    <img src="<?= $sql['foto']; ?>" style="border: 1px solid orangered;" width="400px" height="400px" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-weight: bold; font-size: 20px;">KLINIK CAHAYA AMALIA</span><BR>
                                    <span style=" font-size: 20px;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</span><BR>
                                    <span style=" font-size: 20px;">KECAMATAN BEKASI UTARA, KOTA BEKASI</span><BR><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 90%; border: 1px solid black; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px;">Pemeriksa Akhir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['dokter'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px;">Perusahaan</td>
                                            <td style="width: 270px;">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>







        <div class="col-12 p-4  " style=" height: 100vh;">
            <table class="w-100">
                <tr>
                    <td>
                        <table class="w-100">
                            <tr>
                                <td rowspan="3">
                                    <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                </td>
                                <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                    KLINIK CAHAYA AMALIA
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                            </tr>
                            <tr>
                                <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 10px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bg-dark "></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 3px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="height: 930px;" class="border border-top-0 border-start-0 border-end-0">
                    <td>
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <span style="font-size: 40px; font-style: italic; font-weight: bold; margin-bottom: 10px;">Medical Certificate</span>
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <table style="width: 88%; margin-top: 15px; font-weight: bold;">
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">NIK</td>
                                        <td style="width: 250px;">: <?= $sql['nik'] ?></td>
                                        <td style="width: 170px;">Tanggal Periksa</td>
                                        <td style="width: 270px;">: <?= $tgl_dft ?></td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">Nama Lengkap</td>
                                        <td style="width: 270px;">: <?= $sql['nama'] ?></td>
                                        <td style="width: 170px;">Dokter Penanggung Jawab</td>
                                        <!-- <td style="width: 270px; vertical-align: top;">: <?= $sql['dokter'] ?></td> -->
                                        <td style="width: 270px; vertical-align: top;">: <?= $tkd['nama'] ?></td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">Jenis Kelamin</td>
                                        <td style="width: 270px;">: <?= $sql['jenis_kelamin'] ?></td>
                                        <td style="width: 170px;">No. Medrec</td>
                                        <td style="width: 270px;">: <?= $sql['no_medrec'] ?></td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">Tanggal Lahir</td>
                                        <td style="width: 270px;">: <?= $sql['tgl_lahir'] ?></td>
                                        <td style="width: 170px;">Perusahaan</td>
                                        <td style="width: 270px;">: <?= $sql['nama_per'] ?></td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">No. Telepon</td>
                                        <td style="width: 270px;">: <?= $sql['telp'] ?></td>
                                        <td style="width: 170px;">Department</td>
                                        <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                                <table style="width: 95%;">
                                    <tr>
                                        <td class="border border-dark" colspan="2" style="text-align: center; font-size: 20px; font-weight: bold;  background-color: #FFCC80; height: 30px;">KESIMPULAN</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;">Fit</td>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;"><?php if ($sql['ket'] == 'Fit To Work') {
                                                                                                                            echo '✔';
                                                                                                                        } else {
                                                                                                                        } ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;">Fit With Note</td>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;"><?php if ($sql['ket'] == 'Fit With Note') {
                                                                                                                            echo '✔';
                                                                                                                        } else {
                                                                                                                        } ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;">Temporary Unfit</td>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;"><?php if ($sql['ket'] == 'Temporary Unfit') {
                                                                                                                            echo '✔';
                                                                                                                        } else {
                                                                                                                        } ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;">Not Fit To Work</td>
                                        <td class="border border-dark w-50 ps-4" style="font-size: 17px; height: 20px;"><?php if ($sql['ket'] == 'Not Fit To Work') {
                                                                                                                            echo '✔';
                                                                                                                        } else {
                                                                                                                        } ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                                <table style="width: 95%;">
                                    <tr>
                                        <td class="border border-dark" style=" text-align: center; font-size: 20px; font-weight: bold; background-color: #FFCC80;">Catatan</td>
                                        <td class="border border-dark" style=" text-align: center; font-size: 20px; font-weight: bold; background-color: #FFCC80;">Saran</td>
                                        <td class="border border-dark" style=" text-align: center; font-size: 20px; font-weight: bold; background-color: #FFCC80;">Tanda Tangan</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="padding: 10px; vertical-align: top; height: 350px; width: 45%;">
                                            <textarea name="" id="autoResizeTextarea" style="font-size: 13px; background: none; border: none; resize: none;"><?= $sql["kesimpulan"]; ?></textarea>
                                        </td>
                                        <td class="border border-dark" style="padding: 10px; vertical-align: top; height: 350px; width: 45%;">

                                            <textarea name="" id="autoResizeTextarea" style="font-size: 13px; background: none; border: none; resize: none;"><?= $sql["saran"]; ?></textarea>
                                        </td>
                                        <?php
                                        $ver = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE aktif='2'");
                                        $rev = mysqli_fetch_array($ver);
                                        ?>
                                        <td class="border border-dark" style="height: 100px; text-align: center;">
                                            <img src="../img/icons/3.png" height="170px" width="170px" alt=""><br>
                                            <?= $rev['nama'] ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                </tr>
            </table>
        </div>



        <?php
        $mor = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$sql[id_paket]'");

        while ($rom = mysqli_fetch_array($mor)) {
            $tipe_paket = $rom['tipe_paket'];
            switch ($tipe_paket) {
                case 'tb_umum': ?>



                    <div class="col-12 p-4  " style=" height: 100vh;">

                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px;">
                                <td style="vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                    <table class="w-100">
                                        <tr>
                                            <td colspan="4" class="jdl-1" style="text-align: center; background-color: #FFCC80;">PEMERIKSAAN FISIK</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="jdl-1">Anamnesa</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Keluhan</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['keluhan'] == 'ya') {
                                                                                        echo $sqls['inp_keluhan'];
                                                                                    } elseif ($sqls['keluhan'] == 'tidak') {
                                                                                        echo $sqls['keluhan'];
                                                                                    } ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Merokok</td>
                                            <td style="width: 270px;" class="jdl">: <?= $sqls['merokok'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Alkohol</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['alkohol'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Olahraga</td>
                                            <td style="width: 270px;" class="jdl">: <?= $sqls['olahraga'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Asma</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['asma'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">TBC</td>
                                            <td style="width: 270px;" class="jdl">: <?= $sqls['tbc'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Operasi</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['operasi'] ?><b> (<?= $sqls['inp_operasi'] ?>)</b></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Alergi</td>
                                            <td style="width: 270px;" class="jdl">: <?= $sqls['alergi'] ?><b> (<?= $sqls['inp_alergi'] ?>)</b></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Riwayat Penyakit</td>
                                            <td style="width: 250px;word-wrap: break-word;max-width: 100px;" class="jdl">: <?= $sqls['rwt_penyakit'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Riwayat Penyakit Keluarga</td>
                                            <td style="width: 270px; vertical-align: top;word-wrap: break-word;max-width: 100px;" class="jdl">: <?= $sqls['rwt_penyakit_kel'] ?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="jdl-1">Tanda-tanda Vital</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Tekanan</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['tekanan'] ?> mm/Hg</td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Tinggi Badan</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['tb'] ?> cm</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Detak Nadi</td>
                                            <td style="width: 270px;" class="jdl">: <?= $sqls['detak'] ?> /menit</td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Berat Badan</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['bb'] ?> kg</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Nafas</td>
                                            <td style="width: 270px;" class="jdl">: <?= $sqls['nafas'] ?> /menit</td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">IMT</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['imt'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Suhu</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['suhu'] ?> °C</td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Status</td>
                                            <td style="width: 270px;" class="jdl">: <?= $sqls['stat'] ?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="jdl-1">Pemeriksaan Fisik</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Kepala</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['kepala'] == 'kelainan') {
                                                                                        echo $sqls['inp_kepala'];
                                                                                    } elseif ($sqls['kepala'] == 'normal') {
                                                                                        echo $sqls['kepala'];
                                                                                    } ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Leher</td>
                                            <td style="width: 270px;" class="jdl">: <?php if ($sqls['leher'] == 'kelainan') {
                                                                                        echo $sqls['inp_leher'];
                                                                                    } elseif ($sqls['leher'] == 'normal') {
                                                                                        echo $sqls['leher'];
                                                                                    } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">THT</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['tht'] == 'kelainan') {
                                                                                        echo $sqls['inp_tht'];
                                                                                    } elseif ($sqls['tht'] == 'normal') {
                                                                                        echo $sqls['tht'];
                                                                                    } ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Dada</td>
                                            <td style="width: 270px;" class="jdl">: <?php if ($sqls['dada'] == 'kelainan') {
                                                                                        echo $sqls['inp_dada'];
                                                                                    } elseif ($sqls['dada'] == 'normal') {
                                                                                        echo $sqls['dada'];
                                                                                    } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Jantung</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['jantung'] == 'kelainan') {
                                                                                        echo $sqls['inp_jantung'];
                                                                                    } elseif ($sqls['jantung'] == 'normal') {
                                                                                        echo $sqls['jantung'];
                                                                                    } ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Paru</td>
                                            <td style="width: 270px;" class="jdl">: <?php if ($sqls['paru'] == 'kelainan') {
                                                                                        echo $sqls['inp_paru'];
                                                                                    } elseif ($sqls['paru'] == 'normal') {
                                                                                        echo $sqls['paru'];
                                                                                    } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Perut</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['perut'] == 'kelainan') {
                                                                                        echo $sqls['inp_perut'];
                                                                                    } elseif ($sqls['perut'] == 'normal') {
                                                                                        echo $sqls['perut'];
                                                                                    } ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Saluran Kemih</td>
                                            <td style="width: 270px; vertical-align: top;" class="jdl">: <?php if ($sqls['kemih'] == 'kelainan') {
                                                                                                                echo $sqls['inp_kemih'];
                                                                                                            } elseif ($sqls['kemih'] == 'normal') {
                                                                                                                echo $sqls['kemih'];
                                                                                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Tulang Belakang</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['sendi'] == 'kelainan') {
                                                                                        echo $sqls['inp_sendi'];
                                                                                    } elseif ($sqls['sendi'] == 'normal') {
                                                                                        echo $sqls['sendi'];
                                                                                    } ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Syaraf</td>
                                            <td style="width: 270px;" class="jdl">: <?php if ($sqls['syaraf'] == 'kelainan') {
                                                                                        echo $sqls['inp_syaraf'];
                                                                                    } elseif ($sqls['syaraf'] == 'normal') {
                                                                                        echo $sqls['syaraf'];
                                                                                    } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Anggota Gerak</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['gerak'] == 'kelainan') {
                                                                                        echo $sqls['inp_gerak'];
                                                                                    } elseif ($sqls['gerak'] == 'normal') {
                                                                                        echo $sqls['gerak'];
                                                                                    } ?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="jdl-1">Pemeriksaan Mata</td>
                                            <td colspan="2" class="jdl-1 pt-3">Pemeriksaan Gigi</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">VOD</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['vod'] ?> </td>
                                            <td style="width: 170px;" class="jdl ps-3">Gigi</td>
                                            <td style="width: 270px; vertical-align: top;" class="jdl">: <?php if ($sqls['gigi'] == 'kelainan') {
                                                                                                                echo $sqls['inp_gigi'];
                                                                                                            } elseif ($sqls['gigi'] == 'normal') {
                                                                                                                echo $sqls['gigi'];
                                                                                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">VOS</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['vos'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Bibir</td>
                                            <td style="width: 250px;" class="jdl">: <?php if ($sqls['bibir'] == 'kelainan') {
                                                                                        echo $sqls['inp_bibir'];
                                                                                    } elseif ($sqls['bibir'] == 'normal') {
                                                                                        echo $sqls['bibir'];
                                                                                    } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Buta Warna</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['buta'] ?> </td>
                                            <td style="width: 170px;" class="jdl ps-3">Gusi</td>
                                            <td style="width: 270px; vertical-align: top;" class="jdl">: <?php if ($sqls['gusi'] == 'kelainan') {
                                                                                                                echo $sqls['inp_gusi'];
                                                                                                            } elseif ($sqls['gusi'] == 'normal') {
                                                                                                                echo $sqls['gusi'];
                                                                                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 170px; padding-left: 5px;" class="jdl ps-3">Catatan</td>
                                            <td style="width: 250px;" class="jdl">: <?= $sqls['note_mata'] ?> </td>
                                            <td style="width: 170px;" class="jdl ps-3">Mukosa</td>
                                            <td style="width: 270px; vertical-align: top;" class="jdl">: <?php if ($sqls['mukosa'] == 'kelainan') {
                                                                                                                echo $sqls['inp_mukosa'];
                                                                                                            } elseif ($sqls['mukosa'] == 'normal') {
                                                                                                                echo $sqls['mukosa'];
                                                                                                            } ?></td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>







                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;"">No. Medrec</td>
                                <td style=" width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0"">: <?= $sql['no_medrec'] ?></td>
                            </tr>
                            <tr style=" text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                <td>
                                    <table style="width: 100%;">

                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                KESIMPULAN
                                            </td>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                SARAN
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 250px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["kesan_u"]; ?></textarea>
                                            </td>
                                            <td colspan="2" style="height: 250px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["saran_u"]; ?></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <label for="">Pemeriksa</label>
                                                <label for="">
                                                    <img src="../img/icons/<?php if ($sqls["dokter_u"] == 'dr. Muhammad Aufaiq Akmal Noor') {
                                                                                echo "umum.png";
                                                                            } elseif ($sqls["dokter_u"] == 'dr. Valdiano Zamri') {
                                                                                echo "valdiano.png";
                                                                            } elseif ($sqls["dokter_u"] == 'dr. Dimas Adytia Purnama') {
                                                                                echo "dimas.png";
                                                                            } elseif ($sqls["dokter_u"] == 'dr. Farkhan Reza Sulaeman') {
                                                                                echo "farkhan.png";
                                                                            } elseif ($sqls["dokter_u"] == 'dr. Afriani Khairunnisa') {
                                                                                echo "ekg1.png";
                                                                            } ?>" width="100" height="100" alt="">
                                                </label>
                                                <label for=""><?= $sqls["dokter_u"]; ?></label>
                                            </td>
                                        </tr>


                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>



                <?php
                    break;

                case 'darah_lengkap': ?>




                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td colspan="4" class="jdl-1" style="text-align: center; background-color: #FFCC80;">LABORATORIUM</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr class="fs-3">
                                            <td style="background-color: #d3d3d3;">
                                                Pemeriksaan
                                            </td>
                                            <td style="background-color: #d3d3d3;">
                                                Hasil
                                            </td>
                                            <td style="background-color: #d3d3d3;">
                                                Nilai Rujukan
                                            </td>
                                            <td style="background-color: #d3d3d3;">
                                                Satuan
                                            </td>
                                        </tr>



                                        <tr style="font-weight: bold;">
                                            <td>Complete Blood Count</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Hematokrit
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["hematokrit"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Laki-laki = 42 - 54 <br>
                                                Perempuan = 38 - 46
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Trombosit
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["trombosit"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                150 - 450
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                x 10³ µL
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Hemoglobin
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["hemoglobin"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Laki-laki = 13.0 - 17.0 <br>
                                                Perempuan = 12.0 - 16.0
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                g/dL
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                leukosit
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["leukosit"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                4.0 - 11.0
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                x 103³ µL
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Eritrosit
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["eritrosit"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Laki-laki= 4,7 - 6,1 <br>
                                                Perempuan= 4,0 - 5,5
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                x 10⁶ µL
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                MCV
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["mcv"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                80 - 100
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                fl
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                MCH
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["mch"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                26 - 34
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                pg
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                MCHC
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["mchc"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                32 - 36
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                g/dl
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Basofil
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["basofil"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                0
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Eosinofil
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["eosinofil"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                0 - 3
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Limfosit
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["limfosit"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                20 - 40
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Batang
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["batang"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                2 - 6
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Segmen
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["segmen"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                50 - 70
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                Monosit
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["monosit"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                2 - 8
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                LED
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["led"]; ?>
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                0 - 20
                                            </td>
                                            <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">
                                                mm/jam
                                            </td>
                                        </tr>

                                        <?php
                                        if ($sqls['kimia_darah'] == 'ya') {
                                        ?>

                                            <tr>
                                                <td style="font-weight: bold;">
                                                    Kimia Darah
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Gula Darah Sewaktu
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["gula_darah_sewaktu"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    < 180 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Gula Darah Puasa
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["gula_darah_puasa"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    70-120
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                            <?php
                                            if ($sqls['gd2_ya'] == 'ya') {
                                            ?>
                                                <tr>
                                                    <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                        Gula Darah 2 Jam PP
                                                    </td>
                                                    <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                        <?= $sqls["gula_darah_2"]; ?>
                                                    </td>
                                                    <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                        < 140 </td>
                                                    <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                        mg/dl
                                                    </td>
                                                </tr>
                                            <?php } else {
                                            } ?>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Cholesterol
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["kolesterol"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    < 200 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Trigliserid
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["trigliserid"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    150 - 199
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    HDL
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["hdl"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    > 60
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    LDL
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["ldl"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    < 130 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Asam Urat
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["asam_urat"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Laki-laki = < 7.0 <br>
                                                        Perempuan = < 6.9 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>



                <?php
                    break;
                case 'urine_lengkap': ?>




                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                <td>
                                    <table class="w-100">
                                        <tr class="fs-3">
                                            <td style="background-color: #d3d3d3;">
                                                Pemeriksaan
                                            </td>
                                            <td style="background-color: #d3d3d3;">
                                                Hasil
                                            </td>
                                            <td style="background-color: #d3d3d3;">
                                                Nilai Rujukan
                                            </td>
                                            <td style="background-color: #d3d3d3;">
                                                Satuan
                                            </td>
                                        </tr>

                                        <?php
                                        if ($sqls['hbsag_crm'] == 'ya') {
                                        ?>

                                            <tr>
                                                <td style="font-weight: bold;">
                                                    Imunologi/Serologi
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Imunologi/Serologi / hbsAg
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["hbsag"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    NON REAKTIF
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                                </td>
                                            </tr>

                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($sqls['fungsi_ginjal'] == 'ya') {
                                        ?>

                                            <tr>
                                                <td style="font-weight: bold;">
                                                    Fungsi Ginjal
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Ureum
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["ureum"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    < 40 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Creatinin
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["creatinin"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    0.6 - 1.2
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    mg/dl
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        if ($sqls['fungsi_hati'] == 'ya') {
                                        ?>
                                            <tr>
                                                <td style="font-weight: bold;">
                                                    Fungsi Hati
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    SGOT
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["sgot"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    < 40 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    U/L
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    SGPT
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["sgpt"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    < 56 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    U/L
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    GAMMA GT
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["gamma"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    0 - 51 </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                    U/L
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                        <tr>
                                            <td style="font-weight: bold;">
                                                Urine (Makroskopis)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                WARNA URINE
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["warna"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                KUNING
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                KEJERNIHAN
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["jernih"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                JERNIH
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                PROTEIN
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["protein"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Reduksi
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["reduksi"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                PH
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["ph"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                5 - 8
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                BERAT JENIS
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["berat"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                1.003 - 1.031
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                BILIRUBIN
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["bilirubin"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                UROBILINOGEN
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["urobilinogen"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NITRIT
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["nitrit"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                KETON
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["keton"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                GLUCOSA
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["glucosa"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                BLOOD
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["blood"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                NEGATIF
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="font-weight: bold;">
                                                Urine (Mikroskopis)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Leukosit
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["leukosit_s"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Laki-laki = < 5 /LPB </br>
                                                    Perempuan = < 15 /LPB </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Eritrosit
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["eritrosit_s"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                1 - 3 /LPB
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Ephitel
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["ephitel"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                < 15 </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Silinder
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["silinder"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Negatif
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Kristal
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["kristal"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Negatif
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Bakteri
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                <?= $sqls["bakteri"]; ?>
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                Negatif
                                            </td>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                            </td>
                                        </tr>

                                        <?php
                                        if ($sqls['test_hcg'] == 'ya') {
                                        ?>

                                            <tr>
                                                <td style="font-weight: bold;">
                                                    Tes Kehamilan
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Tes Kehamilan (HCG)
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 350px;">
                                                    <?= $sqls["hcg"]; ?>
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 300px;">
                                                    Negatif
                                                </td>
                                                <td class="border border-top-0 border-start-0 border-end-0" style="width: 200px;">
                                                </td>
                                            </tr>

                                        <?php
                                        }
                                        ?>



                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>



                    <?php
                    //     break;
                    // case 'tb_lab': 
                    $set = mysqli_query($koneksi, "SELECT status FROM tb_lab WHERE no_medrec='$no_medrec'");
                    $sqt = mysqli_fetch_array($set);
                    if ($sqt['status'] == '1') {
                    ?>



                        <div class="col-12 p-4 " style=" height: 100vh;">
                            <table class="w-100">
                                <tr>
                                    <td>
                                        <table class="w-100">
                                            <tr>
                                                <td rowspan="3">
                                                    <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                                </td>
                                                <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                    KLINIK CAHAYA AMALIA
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="height: 10px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="bg-dark "></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="height: 3px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="height: 130px;">
                                    <td style="display: flex; justify-content: center;">
                                        <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">NIK</td>
                                                <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">Department</td>
                                                <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                    <td>
                                        <table class="w-100">
                                            <tr class="fs-3">
                                                <td style="background-color: #d3d3d3;">
                                                    Pemeriksaan
                                                </td>
                                                <td style="background-color: #d3d3d3;">
                                                    Hasil
                                                </td>
                                                <td style="background-color: #d3d3d3;">
                                                    Nilai Rujukan
                                                </td>
                                                <td style="background-color: #d3d3d3;">
                                                    Satuan
                                                </td>
                                            </tr>
                                            <?php
                                            if ($sqls['test_narkoba'] == 'ya') {
                                            ?>

                                                <tr style="font-weight: bold;">
                                                    <td>Test Narkoba</td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Morphine
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                        <?= $sqls["morphine"]; ?>
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Negative
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Amphetamine
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                        <?= $sqls["amphetamine"]; ?>
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Negative
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Metametamin
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                        <?= $sqls["metametamin"]; ?>
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Negative
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        THC
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                        <?= $sqls["thc"]; ?>
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Negative
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Benzodiazephime
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                        <?= $sqls["benzodiazephime"]; ?>
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Negative
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">

                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            if ($sqls['test_hiv'] == 'ya') { ?>
                                                <tr style="font-weight: bold;">
                                                    <td>Test HIV</td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        HIV
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 350px;">
                                                        <?= $sqls["hiv"]; ?>
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 300px;">
                                                        Negative
                                                    </td>
                                                    <td class="border border-start-0 border-top-0 border-end-0" style="width: 200px;">

                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                    KESIMPULAN
                                                </td>
                                                <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                    SARAN
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="height: 250px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                                                    <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["kesan_lab"]; ?></textarea>
                                                </td>
                                                <td colspan="2" style="height: 250px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                                                    <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["saran_lab"]; ?></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td rowspan="2" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                    <label for="">Pemeriksa</label>
                                                    <label for=""><img src="../img/icons/lab.png" width="100" height="100" alt=""></label>
                                                    <label for=""><?= $sqls["dokter_lab"]; ?></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                                </tr>
                            </table>
                        </div>



                    <?php
                    }
                    break;
                case 'tb_audiometri': ?>





                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td colspan="3" class="jdl-1" style="text-align: center; background-color: #FFCC80;">AUDIOMETRI</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <?php
                                        if ($sqls['foto_aud'] > 0) {
                                        ?>
                                            <tr>
                                                <td colspan="4" style="vertical-align: middle; text-align: center;">
                                                    <img src="<?= $sqls['foto_aud'] ?>" width="700px" height="250px" alt="">
                                                </td>
                                            </tr>
                                        <?php
                                        } else {
                                        }
                                        ?>
                                        <!-- <tr>
                                            <td style="height: 40px; vertical-align: bottom;">
                                                AIR CONDUCTION (AC) / Hantaran Udara
                                            </td>
                                        </tr>
                                        <tr style="background-color: #d3d3d3;">
                                            <td style="width: 350px;" class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <b>Frekuensi</b>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <b>Kanan</b>
                                            </td>
                                            <td style="width: 200px;" class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <b>Kiri</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                250
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["250_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["250_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                500
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["500_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["500_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                1000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["1000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["1000_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                2000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["2000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["2000_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                4000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["4000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["4000_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                8000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["8000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["8000_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 40px; vertical-align: bottom;">
                                                BONE CONDUCTION (BC) / Hantaran Tulang
                                            </td>
                                        </tr>
                                        <tr style="background-color: #d3d3d3;">
                                            <td style="width: 350px;" class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <b>Frekuensi</b>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <b>Kanan</b>
                                            </td>
                                            <td style="width: 200px;" class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <b>Kiri</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                250
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_250_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_250_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                500
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_500_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_500_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                1000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_1000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_1000_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                2000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_2000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_2000_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                4000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_4000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_4000_kiri"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                8000
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_8000_kanan"]; ?>
                                            </td>
                                            <td class="border  border-start-0 border-top-0 border-end-0 ps-1">
                                                <?= $sqls["bon_8000_kiri"]; ?>
                                            </td>
                                        </tr> -->
                                        <?php
                                        // if ($sqls['foto_aud'] < 1) {
                                        ?>
                                        <tr>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                KESIMPULAN
                                            </td>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                SARAN
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 200px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["kesan_a"]; ?></textarea>
                                            </td>
                                            <td colspan="2" style="height: 200px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["saran_a"]; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td rowspan="2" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <label for="">Pemeriksa</label>
                                                <label for=""><img src="../img/icons/aud.png" width="300" height="100" alt=""></label>
                                                <label for=""><?= $sqls["dokter_a"]; ?></label>
                                            </td>
                                        </tr>
                                        <?php
                                        // } else {
                                        // } 
                                        ?>


                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>



                    <!-- <?php
                            // if ($sqls['foto_aud'] > 0) {
                            ?>




                        <div class="col-12 p-4" style=" height: 100vh;">
                            <table class="w-100">
                                <tr>
                                    <td>
                                        <table class="w-100">
                                            <tr>
                                                <td rowspan="3">
                                                    <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                                </td>
                                                <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                    KLINIK CAHAYA AMALIA
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="height: 10px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="bg-dark "></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="height: 3px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="height: 130px;">
                                    <td style="display: flex; justify-content: center;">
                                        <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">NIK</td>
                                                <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                                <td style="width: 170px; padding-left: 5px;">Department</td>
                                                <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                    <td>
                                        <table class="w-100">
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                    KESIMPULAN
                                                </td>
                                                <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                    SARAN
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                                                    <textarea name="" id="" cols="50" style="background: none; border: none; resize: none;" rows="8"><?= $sqls["kesan_a"]; ?></textarea>
                                                </td>
                                                <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                                                    <textarea name="" id="" cols="50" style="background: none; border: none; resize: none;" rows="8"><?= $sqls["saran_a"]; ?></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td rowspan="2" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                    <label for="">Pemeriksa</label>
                                                    <label for=""><img src="../img/icons/aud.png" width="300" height="100" alt=""></label>
                                                    <label for=""><?= $sqls["dokter_a"]; ?></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                                </tr>
                            </table>
                        </div> -->




                <?php

                    // } else {
                    // }

                    break;
                case 'tb_spirometri': ?>






                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                <td style="display: flex; justify-content: center; align-items: center;">
                                    <table class="w-100">
                                        <tr>
                                            <td colspan="4" class="jdl-1" style="text-align: center; background-color: #FFCC80;">SPIROMETRI</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <?php
                                        if ($sqls['foto_sp'] > 0) {
                                        ?>
                                            <tr>
                                                <td colspan="4" style="vertical-align: middle; text-align: center;">
                                                    <img src="sp/<?= $sqls['foto_sp'] ?>" width="500px" height="350px" alt="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                        <?php
                                        } else {
                                        }
                                        ?>
                                        <tr style="height: 20px; background-color: #d3d3d3;">
                                            <td class="border  p-3">
                                                <b>Pemeriksaan</b>
                                            </td>
                                            <td class="border  p-3" style="width: 150px; text-align: center;">
                                                <b>Nilai</b>
                                            </td>
                                            <td class="border  p-3" style="width: 150px; text-align: center;">
                                                <b>Prediksi</b>
                                            </td>
                                            <td class="border  p-3" style="width: 150px; text-align: center;">
                                                <b>%</b>
                                            </td>
                                        </tr>
                                        <tr style="height: 20px;">
                                            <td class="border  p-3">
                                                BEST FVC (L)
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['nilai_fvc'] ?>
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['pred_fvc'] ?>
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['persen_fvc'] ?>
                                            </td>
                                        </tr>
                                        <tr style="height: 20px;">
                                            <td class="border  p-3">
                                                BEST FEV 1 (L)
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['nilai_fev'] ?>
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['pred_fev'] ?>
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['persen_fev'] ?>
                                            </td>
                                        </tr>
                                        <tr style="height: 20px;">
                                            <td class="border  p-3">
                                                FEV 1 / FCV (%)
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['nilai_fcv'] ?>
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['pred_fcv'] ?>
                                            </td>
                                            <td class="border  p-3">
                                                <?= $sqls['persen_fcv'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                KESIMPULAN
                                            </td>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                SARAN
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                                                <textarea name="" id="" cols="30" style="background: none; border: none; resize: none;" rows="6"><?= $sqls["kesan_s"]; ?></textarea>
                                            </td>
                                            <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                                                <textarea name="" id="" cols="30" style="background: none; border: none; resize: none;" rows="6"><?= $sqls["saran_s"]; ?></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td rowspan="2" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <label for="">Pemeriksa</label>
                                                <?php

                                                $spr = mysqli_query($koneksi, "SELECT ttd FROM tb_dokter WHERE sps='Spirometri'");
                                                $sp = mysqli_fetch_array($spr);
                                                ?>

                                                <label for=""><img src="ttd/<?= $sp['ttd'] ?>" width="100" height="100" alt=""></label>
                                                <label for=""><?= $sqls["dokter_s"]; ?></label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>



                <?php
                    break;
                case 'tb_radiologi': ?>




                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px; border:1px solid black;" class="border border-top-0 border-start-0 border-end-0">
                                <td style="vertical-align: top;">
                                    <table class="w-100">
                                        <tr>
                                            <td colspan="4" class="jdl-1" style="text-align: center; background-color: #FFCC80;">RADIOLOGI</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="vertical-align: middle; text-align: center;">
                                                <img src="<?= $sqls['foto_r'] ?>" width="80%" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>



                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>



                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px; border:1px solid black;" class="border border-top-0 border-start-0 border-end-0">
                                <td style="vertical-align: top;">
                                    <table class="w-100">
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="jdl-1" style=" background-color: #FFCC80;">Hasil</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top; width: 170px; padding-left: 5px;" class="jdl ps-3">Ekspertise</td>
                                            <td colspan="3"><textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="9">: <?= $sqls["ekspertise_r"]; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                KESIMPULAN
                                            </td>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                SARAN
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="1"><?= $sqls["kesan_r"]; ?></textarea>
                                            </td>
                                            <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="1"><?= $sqls["saran_r"]; ?></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <label for="">Pemeriksa</label> <?php

                                                                                $rad = mysqli_query($koneksi, "SELECT ttd FROM tb_dokter WHERE nama='$sqls[dokter_r]'");
                                                                                $rd = mysqli_fetch_array($rad);
                                                                                ?>

                                                <label for=""><img src="ttd/<?= $rd['ttd'] ?>" width="100" height="100" alt=""></label>
                                                <label for=""><?= $sqls["dokter_r"]; ?></label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>

                <?php
                    break;
                case 'tb_ekg': ?>




                    <div class="col-12 p-4 " style=" height: 100vh;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td rowspan="3">
                                                <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                            </td>
                                            <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                                KLINIK CAHAYA AMALIA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-dark "></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 3px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 130px;">
                                <td style="display: flex; justify-content: center;">
                                    <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">NIK</td>
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                            <td style="width: 170px; padding-left: 5px;">Department</td>
                                            <td style="width: 270px;">: <?= $sql['department'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                                <td style="display: flex; justify-content: center; align-items: center;">
                                    <table class="w-100">
                                        <tr>
                                            <td colspan="3" class="jdl-1" style="text-align: center; background-color: #FFCC80;">EKG</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="vertical-align: middle; text-align: center;">
                                                <img src="<?= $sqls['foto_ekg'] ?>" width="100%" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="jdl-1">Hasil</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td style="vertical-align: top; padding-left: 5px;" class="jdl ps-3">Ekspertise</td>
                                                        <td><textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="9">: <?= $sqls["kesan_e"]; ?></textarea></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                KESIMPULAN
                                            </td>
                                            <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                                                SARAN
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height: 20px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["kes_e"]; ?></textarea>
                                            </td>
                                            <td colspan="2" style="height: 20px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                                                <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;"><?= $sqls["saran_e"]; ?></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td rowspan="2" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <label for="">Pemeriksa</label> <?php

                                                                                $rad = mysqli_query($koneksi, "SELECT ttd FROM tb_dokter WHERE nama='$sqls[dokter_e]'");
                                                                                $rd = mysqli_fetch_array($rad);
                                                                                ?>

                                                <label for=""><img src="ttd/<?= $rd['ttd'] ?>" width="100" height="100" alt=""></label>
                                                <label for=""><?= $sqls["dokter_e"]; ?></label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                            </tr>
                        </table>
                    </div>



        <?php
                    break;

                default:
                    break;
            }
        }
        ?>

        <!-- <div class="col-12 p-4" style=" height: 100vh;">
            <table class="w-100">
                <tr>
                    <td>
                        <table class="w-100">
                            <tr>
                                <td rowspan="3">
                                    <img src="../img/icons/icon-48x48.png" width="100px" height="100px" alt="">
                                </td>
                                <td style="text-align: end; font-weight: bold; vertical-align: bottom;">
                                    KLINIK CAHAYA AMALIA
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: end;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</td>
                            </tr>
                            <tr>
                                <td style="text-align: end; vertical-align: top;">KECAMATAN BEKASI UTARA, KOTA BEKASI</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 10px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bg-dark "></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 3px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-dark bg-dark" style="height: 5px;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="height: 130px;">
                    <td style="display: flex; justify-content: center;">
                        <table style="width: 100%; border: 1px solid black; margin-top: 15px; font-weight: bold;">
                            <tr style="text-align: left;">
                                <td style="width: 170px; padding-left: 5px;">NIK</td>
                                <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nik'] ?></td>
                                <td style="width: 170px; padding-left: 5px;">Tanggal Periksa</td>
                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $tgl_dft ?></td>
                            </tr>
                            <tr style="text-align: left;">
                                <td style="width: 170px; padding-left: 5px;">Nama Lengkap</td>
                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama'] ?></td>
                                <td style="width: 170px; padding-left: 5px;">No. Medrec</td>
                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['no_medrec'] ?></td>
                            </tr>
                            <tr style="text-align: left;">
                                <td style="width: 170px; padding-left: 5px;">Jenis Kelamin</td>
                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['jenis_kelamin'] ?></td>
                                <td style="width: 170px; padding-left: 5px;">Perusahaan</td>
                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['nama_per'] ?></td>
                            </tr>
                            <tr style="text-align: left;">
                                <td style="width: 170px; padding-left: 5px;">Tanggal Lahir</td>
                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $sql['tgl_lahir'] ?></td>
                                <td style="width: 170px; padding-left: 5px;">Department</td>
                                <td style="width: 270px;">: <?= $sql['department'] ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="height: 800px; vertical-align: top;" class="border border-top-0 border-start-0 border-end-0">
                    <td>
                        <table class="w-100">
                            <tr>
                                <td colspan="4" class="jdl-1" style="text-align: center; background-color: #FFCC80;">Dokter Penanggung Jawab</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; font-size: 25px; height: 55px; vertical-align: bottom;">Dokter Hiperkes (Hygiene Perusahaan, Ergonomi, dan Kesehatan)</td>
                            </tr>
                            <tr>
                                <td class="border border-top-0 border-start-0 border-end-0" style="height: 50px; vertical-align: top; font-size: 18px; font-style: italic;"><?= $sqls["dokter"]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="jdl-1" style="text-align: center; background-color: #FFCC80;">Dokter Pemeriksa</td>
                            </tr>


                            <?php
                            // $dtk = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Pemeriksaan Fisik'");
                            // $dkt = mysqli_fetch_array($dtk);
                            // $dtk1 = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Laboratorium'");
                            // $dkt1 = mysqli_fetch_array($dtk1);
                            // $dtk2 = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='EKG'");
                            // $dkt2 = mysqli_fetch_array($dtk2);
                            // $dtk3 = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Audiometri'");
                            // $dkt3 = mysqli_fetch_array($dtk3);
                            // $dtk4 = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Spirometri'");
                            // $dkt4 = mysqli_fetch_array($dtk4);
                            // $dtk5 = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Radiologi'");
                            // $dkt5 = mysqli_fetch_array($dtk5);

                            $dokter = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$sql[id_paket]'");

                            while ($tkd = mysqli_fetch_array($dokter)) {
                                $tipe_paket_1 = $tkd['tipe_paket'];
                                switch ($tipe_paket_1) {
                                    case 'tb_umum':
                            ?>
                                        <tr>
                                            <td style="font-weight: bold; font-size: 25px; height: 40px; vertical-align: bottom;">Dokter Pemeriksa Fisik</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="font-size: 18px; font-style: italic;"><?= $sqls["dokter_u"]; ?></td>
                                        </tr>
                                    <?php
                                        break;
                                    case 'tb_lab':
                                    ?>
                                        <tr>
                                            <td style="font-weight: bold; font-size: 25px; height: 40px; vertical-align: bottom;">Petugas Laboratorium</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="font-size: 18px; font-style: italic;"><?= $sqls["dokter_lab"]; ?></td>
                                        </tr>
                                    <?php
                                        break;
                                    case 'tb_ekg':
                                    ?>
                                        <tr>
                                            <td style="font-weight: bold; font-size: 25px; height: 40px; vertical-align: bottom;">Petugas EKG</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="font-size: 18px; font-style: italic;"><?= $sqls["dokter_e"]; ?></td>
                                        </tr>
                                    <?php
                                        break;
                                    case 'tb_audiometri':
                                    ?>
                                        <tr>
                                            <td style="font-weight: bold; font-size: 25px; height: 40px; vertical-align: bottom;">Dokter Pemeriksa Audiometri</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="font-size: 18px; font-style: italic;"><?= $sqls["dokter_a"]; ?></td>
                                        </tr>
                                    <?php
                                        break;
                                    case 'tb_spirometri':
                                    ?>
                                        <tr>
                                            <td style="font-weight: bold; font-size: 25px; height: 40px; vertical-align: bottom;">Dokter Pemeriksa Spirometri</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="font-size: 18px; font-style: italic;"><?= $sqls["dokter_s"]; ?></td>
                                        </tr>
                                    <?php
                                        break;
                                    case 'tb_radiologi':
                                    ?>
                                        <tr>
                                            <td style="font-weight: bold; font-size: 25px; height: 40px; vertical-align: bottom;">Dokter Pemeriksa Radiologi</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-top-0 border-start-0 border-end-0" style="font-size: 18px; font-style: italic;"><?= $sqls["dokter_r"]; ?></td>
                                        </tr>

                            <?php
                                    default;
                                        break;
                                }
                            }
                            ?>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-style: italic;">MCU Klinik Cahaya Amalia</td>
                </tr>
            </table>
        </div> -->



        <div class="col-12 p-4" style=" height: 200vh;">
        </div>
    </div>
</body>

<!-- <script>
    window.onload = function() {
        // Mendapatkan nilai parameter 'nik' dan 'nama' dari URL
        var urlParams = new URLSearchParams(window.location.search);
        var no_medrec = urlParams.get('no_medrec');
        var nama = urlParams.get('nama');

        // Fungsi untuk membuat nama file
        function createFileName(no_medrec, nama) {
            return nama ? `${nama}-${no_medrec}.pdf` : `${no_medrec}.pdf`;
        }

        // Jika 'no_medrec' dan 'nama' disediakan, buat nama file
        if (no_medrec && nama) {
            var fileName = createFileName(no_medrec, nama);
            document.title = fileName;

            // Cetak halaman ke PDF dengan nama file yang dihasilkan
            window.print();

            // Setelah mencetak, kembalikan nama file ke default setelah jeda
            setTimeout(function() {
                document.title = 'Cetak PDF dengan Nama Otomatis';
            }, 100); // Sesuaikan jeda ini jika diperlukan
        } else {
            // Perilaku default jika tidak ada 'nik' atau 'nama' disediakan
            document.title = 'Cetak PDF dengan Nama Otomatis';
            window.print();
            setTimeout(function() {
                document.title = 'Cetak PDF dengan Nama Otomatis';
                setTimeout(function() {
                    window.history.back();
                }, 100);
            }, 100); // Sesuaikan jeda ini jika diperlukan
        }
    };
    window.onafterprint = function() {
        history.go(-1);
        document.location.href = '../view/download_data.php'
    }

    document.addEventListener('input', function(event) {
        if (event.target.id === 'autoResizeTextarea') {
            event.target.style.height = 'auto';
            event.target.style.height = event.target.scrollHeight + 'px';
        }
    });
</script> -->

<script>
    window.onload = function() {
        var urlParams = new URLSearchParams(window.location.search);
        var no_medrec = urlParams.get('no_medrec');
        var nama = urlParams.get('nama');

        // Fungsi untuk membuat nama file
        function createFileName(no_medrec, nama) {
            return nama ? `${nama}-${no_medrec}.pdf` : `${no_medrec}.pdf`;
        }

        // Jika 'no_medrec' dan 'nama' disediakan, buat nama file
        if (no_medrec && nama) {
            var fileName = createFileName(no_medrec, nama);

            // Konfigurasi untuk html2pdf
            const element = document.body; // Bisa disesuaikan untuk elemen lain yang diinginkan

            const opt = {
                margin: 0,
                padding: 0,
                filename: fileName,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A4',
                    orientation: 'portrait'
                },
                pagebreak: {
                    mode: ['avoid-all', 'css', 'legacy']
                } // Menghindari pemotongan elemen
            };

            // Menambahkan pemisah halaman untuk elemen dengan class atau id tertentu
            // document.querySelectorAll('.page-section').forEach(function(section) {
            //     section.style.pageBreakBefore = 'always';
            // });

            // Memanggil fungsi html2pdf
            html2pdf().from(element).set(opt).save();

            setTimeout(function() {
                history.go(-1);
            }, 1000); // Sesuaikan jeda ini jika diperlukan
        } else {
            // Jika no_medrec atau nama tidak disediakan, tampilkan pesan atau perilaku default
            alert("Data tidak tersedia untuk proses PDF.");
        }

    };
</script>


</html>