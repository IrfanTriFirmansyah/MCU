<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}

require "../conn/koneksi.php";

$id_peserta = $_GET['id_peserta'];

$car = mysqli_query($koneksi, "SELECT * FROM data_peserta
JOIN tb_per ON data_peserta.id_per = tb_per.id_per
JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
WHERE id_peserta='$id_peserta'");
$row = mysqli_fetch_array($car);

$van = mysqli_query($koneksi, "SELECT * FROM rekam_mcu WHERE id_peserta='$id_peserta'");
$sql = mysqli_fetch_array($van);

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " Seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "Minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

$nominal = 0;
if ($row['jenis_kelamin'] == 'PEREMPUAN') {
    $nominal = $row['harga_female'];
} elseif ($row['jenis_kelamin'] == 'LAKI-LAKI') {
    $nominal = $row['harga_male'];
}
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
            width: 100%;
        }

        .contain {
            padding: 20px;
            width: 100%;
            /* border: 1px solid black; */
            display: flex;
            justify-content: end;
        }

        /* .data tr {
            height: 30px;
        } */
    </style>
</head>

<body>
    <div class="contain row">


        <?php
        if ($row['bayar'] == 'Ya') {
        ?>


            <div class="col-12 mb-2" style=" display: flex; justify-content: center; padding: 0; width: 100%; font-family: 'Times New Roman', Times, serif;">
                <table style="width: 100%; margin-top: 0px;">
                    <tr>
                        <td style="width: 25%; height: 50px; text-align: end; padding-right: 5px;">
                            <img src="../img/icons/icon-48x48.png" width="60px" height="60px" alt="">
                        </td>
                        <td style="width: 75%; text-align: start; padding-left: 25px;">
                            <b style="font-size: 15px;">KLINIK CAHAYA AMALIA</b><br>
                            <span style="font-size: 10px;">JL. KH. MUCHTAR TABRANI NO 3-5 PERWIRA,BEKASI UTARA</span><br>
                            <span style="font-size: 10px;">Telp (021) 88870888, Fax. (021)88881747</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center; text-decoration: underline; font-size: 20px; height: 40px; vertical-align: middle;">
                            <b>KWITANSI</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left: 30px; height: 10px;">Sudah terima dari</td>
                        <td>: &nbsp;&nbsp;&nbsp;&nbsp;<i><b><?= $row['nama'] ?></b></i></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 30px; height: 10px;">Nominal</td>
                        <td>: &nbsp;&nbsp;&nbsp;&nbsp;<i><b>Rp <?= $nominal ?></b></i></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 30px; height: 10px;">Untuk Pembayaran</td>
                        <td>: &nbsp;&nbsp;&nbsp;&nbsp;<i><b>Pemeriksaan MCU (<?= $row['nama_paket'] ?>)</b></i></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 30px; height: 10px;" class="border border-start-0 border-end-0 border-top-0">Metode Pembayaran</td>
                        <td class="border border-start-0 border-end-0 border-top-0">: &nbsp;&nbsp;&nbsp;&nbsp;<i><b>Cash / Debit BRI / QRIS BRI</b></i></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 30px; height: 10px; font-weight: bold; font-style: italic;">Terbilang</td>
                        <td>: &nbsp;&nbsp;&nbsp;&nbsp;<i><b><?= terbilang($nominal) ?> Rupiah</b></i></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="height: 10px; text-align: center;"></td>
                                    <td style="width: 80%; text-align: center;">
                                        Bekasi, <span id="date1"></span><br>
                                        Keuangan
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 50px; width: 40%; vertical-align: bottom; text-align: center;">
                                        &nbsp;
                                    </td>
                                    <td style="vertical-align: bottom; text-align: center;">Adelia Nursita Sari</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>

            <div class="col-12 row mb-2" style="display: flex; justify-content: center; padding: 0; width: 100%; border-style: dashed; border-top:none; border-left:none; border-right:none;">

            </div>
        <?php
        } else {
        }
        ?>


        <div class="col-12 border border-dark row" style="display: flex; justify-content: center; padding: 0; width: 100%;">
            <div class="col-12 row">
                <div class="col-7 border border-dark border-top-0 border-bottom-0 border-end-0" style="padding: 0;">
                    <table class="data w-100" style="font-size: 11px;">
                        <tr>
                            <td class="border border-dark border-top-0 border-start-0 border-end-0" style="width: 100%; text-align: center; font-size: 20px; font-weight: bold;">KARTU MCU</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; font-weight: bold; font-size: 15px;"><?= $row['nama_per']; ?></td>
                        </tr>
                        <tr>
                            <td style="height: 5px;">

                            </td>
                        </tr>
                        <tr>
                            <td class="row">
                                <div class="col-4">No. Medrec</div>
                                <div class="col-8">: &nbsp;<?= $sql['no_medrec']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="row">
                                <div class="col-4">NIK</div>
                                <div class="col-8">: &nbsp;<?= $row['nik']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="row">
                                <div class="col-4">Nama</div>
                                <div class="col-8">: &nbsp;<?= $row['nama']; ?>
                                    (
                                    <?php if ($row['jenis_kelamin'] == 'PEREMPUAN') {
                                        echo "<b>P</b>";
                                    } else {
                                        echo "<b>L</b>";
                                    }
                                    ?>
                                    )
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="row">
                                <div class="col-4">TTL</div>
                                <div class="col-8">: &nbsp;<?= $row['tgl_lahir']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="row">
                                <div class="col-4">No. Telepon</div>
                                <div class="col-8">: &nbsp;<?= $row['telp']; ?></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-5 border border-dark border-top-0 border-bottom-0" style="display: flex; justify-content: center; align-items: center; height: 100%;">
                    <?php
                    if ($sql['foto'] > 0) {
                    ?>
                        <img src="<?= htmlspecialchars($sql['foto']); ?>" style="width: 180px; height: 160px;" alt="">
                    <?php
                    } else { ?>
                        <img src="../img/photos/1.jpg" style="width: 180px; height: 160px;" alt="">
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-12 row">
                <div class="col-12 border border-dark border-start-0 border-end-0 border-bottom-0 d-flex justify-content-center align-items-center" style="text-align: center; height: 30px; font-weight: bold; font-size: 15px;">
                    <?= $row['nama_paket']; ?>
                </div>

                <div class="col-12 border border-dark" style="padding: 0;">
                    <table style="width: 100%;">
                        <tr style="font-size: 15px; font-weight: bold;">
                            <td class="border border-dark" style="width: 45%; text-align: center;">
                                <b>Jenis Pemeriksaan</b>
                            </td>
                            <td class="border border-dark" style="width: 50%; text-align: center;" colspan="2">
                                <b>Verifikasi</b>
                            </td>
                        </tr>

                        <?php
                        $mor = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$row[id_paket]'");
                        $showCommonInput = false;

                        while ($rom = mysqli_fetch_array($mor)) {
                            $tipe_paket = $rom['tipe_paket'];
                            if (in_array(
                                $tipe_paket,
                                [
                                    'tb_lab',
                                    'fungsi_hati',
                                    'test_hcg',
                                    'test_narkoba',
                                    'fungsi_ginjal',
                                    'kimia_darah'
                                ]
                            )) {
                                $showCommonInput = true;
                                break; // Exit the loop as we only need to show one input
                            }
                        }

                        if ($showCommonInput) {
                            echo '
                            <tr style="height: 50px; text-align: center;">

                                <td class="border border-dark">
                                    Pengambilan Sampel
                                </td>
                                <td class="border border-dark">
                                    Darah
                                </td>
                                <td class="border border-dark">
                                    Urine
                                </td>
                            </tr>
                            ';
                        }
                        mysqli_data_seek($mor, 0); // Reset the result pointer to the beginning
                        while ($rom = mysqli_fetch_array($mor)) {
                            $tipe_paket = $rom['tipe_paket'];
                            switch ($tipe_paket) {
                                case 'tb_spirometri':
                                    echo '
                                            <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            Spirometri
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                            ';
                                    break;
                                case 'tb_audiometri':
                                    echo '
                                            <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            Audiometri
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                            ';
                                    break;
                                case 'tb_treadmil':
                                    echo '
                                            <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            Treadmill
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                            ';
                                    break;
                                case 'tb_umum':
                                    echo '
                                        <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            Pemeriksaan Fisik
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                        <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            Tensi
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                        <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            Pemeriksaan Mata
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                        ';
                                    break;
                                case 'tb_ekg':
                                    echo '
                                        <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            EKG
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                        ';
                                    break;
                                case 'tb_radiologi':
                                    echo '
                                        <tr style="height: 50px; text-align: center;">

                                        <td class="border border-dark">
                                            Radiologi
                                        </td>
                                        <td colspan="2" class="border border-dark">
        
                                        </td>
                                    </tr>
                                        ';
                                    break;
                                default:
                                    break;
                            }
                        }
                        ?>






                    </table>
                </div>

                <div class="col-12" style="height: 100px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <h6 style="margin-top: 10px;"><span id="date"></span></h6>
                    <div style="height: 30px;"></div>
                    <h6>__________________________</h6>
                    <div style="margin-top: -10px;">(Tanda Tangan & nama Peserta MCU)</div>
                </div>
            </div>
        </div>



    </div>




    <script>
        window.onload = function() {
            window.print();
        }

        // Event listener untuk afterprint
        window.onafterprint = function() {
            window.location.href = 'stiker.php?id_peserta=<?php echo $id_peserta; ?>';
        }

        n = new Date();
        y = n.getFullYear();
        m = n.getMonth() + 1;
        d = n.getDate();
        document.getElementById("date").innerHTML = d + "/" + m + "/" + y; //Full date Bulan/tanggal/tahun
        document.getElementById("date1").innerHTML = d + "/" + m + "/" + y; //Full date Bulan/tanggal/tahun
    </script>
</body>

</html>