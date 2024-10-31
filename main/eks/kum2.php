<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}

// error_reporting(0);
// ini_set('display_errors', 0);

// $no_medrec = $_GET['no_medrec'];

require "../../conn/koneksi.php";


$van = mysqli_query($koneksi, "SELECT * FROM data_peserta
INNER JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
INNER JOIN tb_per ON data_peserta.id_per = tb_per.id_per
INNER JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
WHERE data_peserta.id_peserta IN ('1196','1343','1646','1200','1526','1225','1722','1588','1721','1269','1258','1724')
ORDER BY data_peserta.nama ASC
");


while ($sql = mysqli_fetch_array($van)) {

    $med = $sql['no_medrec'];

    $vans = mysqli_query($koneksi, "
    SELECT * FROM rekam_mcu
    LEFT JOIN tb_umum ON rekam_mcu.no_medrec = tb_umum.no_medrec
    LEFT JOIN tb_lab ON rekam_mcu.no_medrec = tb_lab.no_medrec
    LEFT JOIN tb_audiometri ON rekam_mcu.no_medrec = tb_audiometri.no_medrec
    LEFT JOIN tb_spirometri ON rekam_mcu.no_medrec = tb_spirometri.no_medrec
    LEFT JOIN tb_radiologi ON rekam_mcu.no_medrec = tb_radiologi.no_medrec
    LEFT JOIN tb_ekg ON rekam_mcu.no_medrec = tb_ekg.no_medrec
    WHERE rekam_mcu.no_medrec = '$med' 
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
        <link rel="shortcut icon" href="../../img/icons/icon-48x48.png" />

        <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

        <link href="../../css/app.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

        <style>
            * {
                margin: 0;
                padding: 0;
            }

            @media print {

                /* Mengatur orientasi kertas menjadi landscape */
                @page {
                    size: landscape;
                }
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .bg {
                background-image: url(../img/photos/bg.jpg);
                background-repeat: no-repeat;
                background-position: center;
            }

            .jdl {
                font-size: 14px;
                /* font-weight: bold; */
                /* padding: 3px; */
            }

            .jdl-1 {
                font-size: 17px;
                font-weight: bold;
                padding: 3px;
            }

            .jdl-pem {
                font-size: 17px;
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


    <div class="row ps-4" style=" width: 100%; height: 100vh;">
            <div class="col-6 pe-5">

            </div>
            <div class="col-6">
                <table style="border-collapse: collapse; width: 100%; height: 100%;">
                    <tr>
                        <td style="text-align: center; vertical-align: top;">
                            <table style="width: 100%; border-collapse: collapse; margin-top: 50px;">
                                <tr>
                                    <td style="height: 130px;">
                                        <span style="font-size: 30px; font-style: italic; font-weight: bold; ">DATA MCU KARYAWAN</span><br>
                                        <span style="font-size: 25px; font-style: italic; font-weight: bold; "><?= $sql['nama_per'] ?></span><br>
                                        <span style="font-size: 18px; font-style: italic; font-weight: bold; ">Tanggal : <?= $sql['tgl'] ?></span><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:65px;  width:100%;text-align: center; background-color: #FFCC80;text-align: center; font-size: 25px; font-weight: bold;" colspan="4"><?= $sql['nama'] ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 300px; ">
                            <center>
                                <img src="../../proses/<?= $sql['foto']; ?>" style="border: 2px solid black;" width="250px" height="250px" alt="">
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td style="display: flex; justify-content: center; font-size: 13px;">
                            <table style="width: 90%; font-weight: bold; text-align: left;">
                                <tr class="border-bottom" style="font-size: 15px;">
                                    <td style="width: 150px;">No. Medrec</td>
                                    <td>:</td>
                                    <td><?= $sql['no_medrec'] ?></td>
                                </tr>
                                <tr class="border-bottom" style="font-size: 15px;">
                                    <td>NIK/NIP</td>
                                    <td>:</td>
                                    <td><?= $sql['nik'] ?></td>
                                </tr>
                                <tr class="border-bottom" style="font-size: 15px;">
                                    <td>Tanggal Lahir</td>
                                    <td>:</td>
                                    <td><?= $sql['tgl_lahir'] ?></td>
                                </tr>
                                <tr class="border-bottom" style="font-size: 15px;">
                                    <td>Department</td>
                                    <td>:</td>
                                    <td><?= $sql['department'] ?></td>
                                </tr>
                                <tr class="border-bottom" style="font-size: 15px;">
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td><?= $sql['jenis_kelamin'] ?></td>
                                </tr>
                                <tr class="border-bottom" style="font-size: 15px;">
                                    <td>Lokasi Kerja</td>
                                    <td>:</td>
                                    <td><?= $sql['lokasi'] ?></td>
                                </tr>
                                <tr class="border-bottom" style="font-size: 15px;">
                                    <td>Tanggal Periksa</td>
                                    <td>:</td>
                                    <td><?= $tgl_dft ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row ps-4" style=" width: 100%; height: 100vh;">
            <div class="col-6 pe-5">

            </div>
            <div class="col-6">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <span style="font-size: 30px; height: 60px; font-style: italic; font-weight: bold; margin-top: 50px;">KESIMPULAN</span>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <table style="width: 90%; font-weight: bold; text-align: left;">
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td style="width: 150px;">Nama</td>
                                <td>:</td>
                                <td><?= $sql['nama'] ?></td>
                            </tr>
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td>NIK</td>
                                <td>:</td>
                                <td><?= $sql['nik'] ?></td>
                            </tr>
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td><?= $sql['tgl_lahir'] ?></td>
                            </tr>
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td>Perusahaan</td>
                                <td>:</td>
                                <td><?= $sql['nama_per'] ?></td>
                            </tr>
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><?= $sql['jenis_kelamin'] ?></td>
                            </tr>
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td>Department</td>
                                <td>:</td>
                                <td><?= $sql['department'] ?></td>
                            </tr>
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td>Lokasi Kerja</td>
                                <td>:</td>
                                <td><?= $sql['lokasi'] ?></td>
                            </tr>
                            <tr class="border-bottom" style="font-size: 15px;">
                                <td>Tanggal Periksa</td>
                                <td>:</td>
                                <td><?= $tgl_dft ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                        <table style="width: 95%;">
                            <tr>
                                <td class="border border-dark" colspan="2" style="text-align: center; font-size: 20px; font-weight: bold;  background-color: #FFCC80;; height: 30px;">HASIL AKHIR</td>
                            </tr>
                            <tr>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;">Fit To Work</td>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;"><?php if ($sql['ket'] == 'Fit To Work') {
                                                                                                                                        echo '✔';
                                                                                                                                    } else {
                                                                                                                                    } ?></td>
                            </tr>
                            <tr>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;">Fit With Note</td>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;"><?php if ($sql['ket'] == 'Fit With Note') {
                                                                                                                                        echo '✔';
                                                                                                                                    } else {
                                                                                                                                    } ?></td>
                            </tr>
                            <tr>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;">Temporary Unfit</td>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;"><?php if ($sql['ket'] == 'Temporary Unfit') {
                                                                                                                                        echo '✔';
                                                                                                                                    } else {
                                                                                                                                    } ?></td>
                            </tr>
                            <tr>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;">Not Fit To Work</td>
                                <td class="border border-dark w-50 ps-4" style="font-size: 12px; height: 20px; font-weight: bold;"><?php if ($sql['ket'] == 'Not Fit To Work') {
                                                                                                                                        echo '✔';
                                                                                                                                    } else {
                                                                                                                                    } ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                        <table style="width: 95%;">
                            <tr>
                                <td class="border border-dark" style="width: 100px; text-align: center; font-size: 20px; font-weight: bold; background-color: #FFCC80;;">Catatan</td>
                                <td class="border border-dark" style="width: 100px; text-align: center; font-size: 20px; font-weight: bold; background-color: #FFCC80;;">Saran</td>
                                <td class="border border-dark" style="width: 150px; text-align: center; font-size: 20px; font-weight: bold; background-color: #FFCC80;;">Tanda Tangan</td>
                            </tr>
                            <tr style="font-size: 10px;">
                                <td class="border border-dark" style="padding: 10px; vertical-align: top; height: 100%; width: 45%;">
                                    <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none; "rows="17"><?= $sql["kesimpulan"]; ?></textarea>
                                </td>
                                <td class="border border-dark" style="padding: 10px; vertical-align: top; height: 100%; width: 75%;">

                                    <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="17"><?= $sql["saran"]; ?></textarea>
                                </td>
                                <?php
                                $ver = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE aktif='2'");
                                $rev = mysqli_fetch_array($ver);
                                ?>
                                <td class="border border-dark" style=" text-align: center;">
                                    <img src="../../img/icons/3.png" height="120px" width="135px" alt=""><br>
                                    <?= $rev['nama'] ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ps-4" style=" width: 100%; height: 100vh;">
            <div class="col-6 pe-5">
                <table class="w-100">
                    <tr style="height: 110px;">
                        <td colspan="4" style="text-align: center; vertical-align: bottom; font-size: 30px; font-style: italic; font-weight: bold; padding-bottom: 30px;">AUDIOMETRI</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="vertical-align: middle; text-align: center;">
                            <img src="../../proses/<?= $sqls['foto_aud'] ?>" width="500px" height="200px" alt="">
                        </td>
                    </tr>
                </table>
                <table class="w-100 mt-4">
                    <tr>
                        <td colspan="2" style="width: 50%; font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                            KESIMPULAN
                        </td>
                        <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                            SARAN
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="height: 150px; vertical-align: top; font-size: 12px;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                            <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="1"><?= $sqls["kesan_a"]; ?></textarea>
                        </td>
                        <td colspan="2" style="height: 150px; vertical-align: top; font-size: 12px;" class="border border-dark border-top-0 border-start-0 border-end-0">
                            <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="1"><?= $sqls["saran_a"]; ?></textarea>
                        </td>
                    </tr>

                </table>
            </div>
            <div class="col-6 ps-5">
                <table class="w-100" style="font-size: 10px;">
                    <tr style="height: 110px;">
                        <td colspan="4" style="text-align: center; vertical-align: bottom; font-size: 30px; font-style: italic; font-weight: bold; padding-bottom: 30px;">PEMERIKSAAN FISIK</td>
                    </tr>

                    <tr>
                        <td style="background-color: #FFCC80;" colspan="4" class="jdl-1">Anamnesa</td>
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
                        <td style="background-color: #FFCC80;" colspan="4" class="jdl-1">Tanda-tanda Vital</td>
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
                        <td style="background-color: #FFCC80;" colspan="4" class="jdl-1">Pemeriksaan Fisik</td>
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
                        <td style="background-color: #FFCC80;" colspan="2" class="jdl-1">Pemeriksaan Mata</td>
                        <td style="background-color: #FFCC80;" colspan="2" class="jdl-1">Pemeriksaan Gigi</td>
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
            </div>
        </div>

        <div class="row ps-4" style=" width: 100%; height: 100vh;">
            <div class="col-6 pe-5">
                <div class="ps-2 pe-2">
                    <table class="w-100">
                        <tr style="height: 110px">
                            <td
                                colspan="4"
                                style="text-align: center;vertical-align: bottom;font-size: 30px;font-style: italic;font-weight: bold;padding-bottom: 30px;">
                                LABORATORIUM
                            </td>
                        </tr>
                        <tr style="vertical-align: top">
                            <td>
                                <table class="w-100" style="font-size: 12px">
                                    <tr class="fw-bold" style="font-size: 14px">
                                        <td style="background-color: #ffcc80; font-weight: bold">
                                            Pemeriksaan
                                        </td>
                                        <td style="background-color: #ffcc80; font-weight: bold">Hasil</td>
                                        <td style="background-color: #ffcc80; font-weight: bold">
                                            Nilai Rujukan
                                        </td>
                                        <td style="background-color: #ffcc80; font-weight: bold">Satuan</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Imunologi/Serologi</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-top-0 border-start-0 border-end-0"
                                            style="width: 300px">
                                            Imunologi/Serologi / hbsAg
                                        </td>
                                        <td
                                            class="border border-top-0 border-start-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["hbsag"]; ?>
                                        </td>
                                        <td
                                            class="border border-top-0 border-start-0 border-end-0"
                                            style="width: 300px">
                                            NON REAKTIF
                                        </td>
                                        <td
                                            class="border border-top-0 border-start-0 border-end-0"
                                            style="width: 200px"></td>
                                    </tr>

                                    <tr style="font-weight: bold">
                                        <td>Complete Blood Count</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Hematokrit
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["hematokrit"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Laki-laki = 42 - 54 <br />
                                            Perempuan = 38 - 46
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Trombosit
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["trombosit"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            150 - 450
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            x 10³ µL
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Hemoglobin
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["hemoglobin"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Laki-laki=13.0-17.0 <br />
                                            Perempuan=12.0-16.0
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            g/dL
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            leukosit
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["leukosit"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            4.0 - 11.0
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            x 103³ µL
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Eritrosit
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["eritrosit"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Laki-laki=4,7-6,1 <br />
                                            Perempuan=4,0-5,5
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            x 10⁶ µL
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            MCV
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["mcv"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            80 - 100
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            fl
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            MCH
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["mch"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            26 - 34
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            pg
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            MCHC
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["mchc"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            32 - 36
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            g/dl
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Basofil
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["basofil"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            0
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Eosinofil
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["eosinofil"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            0 - 3
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Limfosit
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["limfosit"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            20 - 40
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Batang
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["batang"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            2 - 6
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Segmen
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["segmen"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            50 - 70
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            Monosit
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["monosit"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            2 - 8
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            LED
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 350px">
                                            <?= $sqls["led"]; ?>
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 300px">
                                            0 - 20
                                        </td>
                                        <td
                                            class="border border-start-0 border-top-0 border-end-0"
                                            style="width: 200px">
                                            mm/jam
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="col-6 ps-5">
                <table class="w-100">
                    <tr style="height: 110px;">
                        <td style="text-align: center; vertical-align: bottom; font-size: 30px; font-style: italic; font-weight: bold; padding-bottom: 30px;">HASIL EKG</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row ps-4" style=" width: 100%; height: 100vh;">
            <div class="col-6 pe-5">
                <table style="width: 98%; margin-left: 10px;">
                    <tr style="height: 110px;">
                        <td colspan="4" style="text-align: center; vertical-align: bottom; font-size: 30px; font-style: italic; font-weight: bold; padding-bottom: 30px;">HASIL EKG</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="jdl-1" style="background-color: #FFCC80;">Hasil</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; width: 170px; padding-left: 5px;" class="jdl ps-3">Ekspertise</td>
                        <td colspan="4"><textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="9">: <?= $sqls["kesan_e"]; ?></textarea></td>
                    </tr>
                </table>
                <table class="w-100">
                    <tr>
                        <td colspan="2" style="width: 50%; font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                            KESIMPULAN
                        </td>
                        <td colspan="2" style="font-size: 20px; font-weight: bold; background-color: #FFCC80;">
                            SARAN
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0 pe-3">
                            <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="1"><?= $sqls["kes_e"]; ?></textarea>
                        </td>
                        <td colspan="2" style="height: 150px; vertical-align: top;" class="border border-dark border-top-0 border-start-0 border-end-0">
                            <textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="1"><?= $sqls["saran_e"]; ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-6 ps-5">
                <table class="w-100">
                    <tr style="height: 110px;">
                        <td colspan="4" style="text-align: center; vertical-align: bottom; font-size: 30px; font-style: italic; font-weight: bold; padding-bottom: 30px;">LABORATORIUM</td>
                    </tr>
                    <tr style="vertical-align: top;">
                        <td>
                            <table class="w-100" style="font-size: 12px;">
                                <tr class=" fw-bold" style="font-size: 14px;">
                                    <td style="background-color: #FFCC80; font-weight: bold;">
                                        Pemeriksaan
                                    </td>
                                    <td style="background-color: #FFCC80; font-weight: bold;">
                                        Hasil
                                    </td>
                                    <td style="background-color: #FFCC80; font-weight: bold;">
                                        Nilai Rujukan
                                    </td>
                                    <td style="background-color: #FFCC80; font-weight: bold;">
                                        Satuan
                                    </td>
                                </tr>

                                <tr>
                                <td style="font-weight: bold;">
                                    Kimia Darah
                                </td>
                            </tr>
                            <?php
                            if ($sqls["gula_darah_sewaktu"] > 0) {
                            ?>
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
                            <?php
                        }
                            if ($sqls["gula_darah_puasa"] > 0) {
                            ?>
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
                            <?php }


                            if ($sqls["gula_darah_2"] > 0) {
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
                            <?php }  ?>
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
                            <?php
                            if ($sqls["trigliserid"] > 0) {
                            ?>
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
                            <?php }

                            if ($sqls["hdl"] > 0) {
                            ?>
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
                            <?php }

                            if ($sqls["ldl"] > 0) {
                            ?>
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
                            <?php } ?>
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

                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row ps-4" style=" width: 100%; height: 100vh;">
            <div class="col-6 pe-5">
                <table class="w-100">
                    <tr style="height: 110px;">
                        <td style="text-align: center; vertical-align: bottom; font-size: 30px; font-style: italic; font-weight: bold; padding-bottom: 30px;">FOTO THORAX</td>
                    </tr>
                </table>
            </div>
            <div class="col-6 ps-5">
                <table style="width: 98%; margin-left: 10px;">
                    <tr style="height: 110px;">
                        <td colspan="4" style="text-align: center; vertical-align: bottom; font-size: 30px; font-style: italic; font-weight: bold; padding-bottom: 30px;">HASIL THORAX</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="jdl-1" style="background-color: #FFCC80;">Hasil</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; width: 170px; padding-left: 5px;" class="jdl ps-3">Ekspertise</td>
                        <td colspan="4"><textarea name="" id="autoResizeTextarea" style="background: none; border: none; resize: none;" rows="9">: <?= $sqls["ekspertise_r"]; ?></textarea></td>
                    </tr>
                </table>
                <table class="w-100">
                    <tr>
                        <td colspan="2" style="width: 50%; font-size: 20px; font-weight: bold; background-color: #FFCC80;">
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

                </table>
            </div>
        </div>


        <?php
    } ?>