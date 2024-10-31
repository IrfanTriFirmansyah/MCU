<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}

// error_reporting(0);
// ini_set('display_errors', 0);

// Ambil no_medrec dari query string, bisa lebih dari satu
$no_medrec_array = isset($_GET['no_medrec']) ? $_GET['no_medrec'] : [];

require "../conn/koneksi.php";

if (!is_array($no_medrec_array)) {
    $no_medrec_array = [$no_medrec_array]; // Pastikan ini adalah array
}

$data_records = [];

foreach ($no_medrec_array as $no_medrec) {
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

    $data_records[] = [
        'sql' => $sql,
        'sqls' => $sqls,
        'dokter' => $tkd,
        'tgl_dft' => $tgl_dft
    ];
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
    <link href="../css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        @media print {
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
    </style>
</head>

<body>
    <div class="row">
        <div class="col-12 w-100" style="height: auto;">
            <?php foreach ($data_records as $record): ?>
                <table style="border-collapse: collapse; width: 100%; height: auto;">
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
                                        <img src="<?= $record['sql']['foto']; ?>" style="border: 1px solid orangered;" width="400px" height="400px" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-weight: bold; font-size: 20px;">KLINIK CAHAYA AMALIA</span><br>
                                        <span style="font-size: 20px;">JL. KH. MUCHTAR TABRANI NO 3-5 RT/RW.04/01 PERWIRA,</span><br>
                                        <span style="font-size: 20px;">KECAMATAN BEKASI UTARA, KOTA BEKASI</span><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="display: flex; justify-content: center;">
                                        <table style="width: 90%; border: 1px solid black; font-weight: bold;">
                                            <tr style="text-align: left;">
                                                <td style="width: 170px;">NIK</td>
                                                <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $record['sql']['nik'] ?></td>
                                                <td style="width: 170px;">Tanggal Periksa</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $record['tgl_dft'] ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px;">Nama Lengkap</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $record['sql']['nama'] ?></td>
                                                <td style="width: 170px;">Pemeriksa Akhir</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $record['sql']['dokter'] ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px;">Jenis Kelamin</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $record['sql']['jenis_kelamin'] ?></td>
                                                <td style="width: 170px;">No. Medrec</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $record['sql']['no_medrec'] ?></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td style="width: 170px;">Tanggal Lahir</td>
                                                <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= $record['sql']['tgl_lahir'] ?></td>
                                                <td style="width: 170px;">Perusahaan</td>
                                                <td style="width: 270px;">: <?= $record['sql']['nama_per'] ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div style="page-break-after: always;"></div> <!-- Untuk memisahkan halaman saat mencetak -->
            <?php endforeach; ?>
        </div>
    </div>
</body>

<script>
    window.onload = function() {
        var urlParams = new URLSearchParams(window.location.search);
        var no_medrec = urlParams.get('no_medrec');
        var nama = urlParams.get('nama');

        function createFileName(no_medrec, nama) {
            return nama ? `${nama}-${no_medrec}.pdf` : `${no_medrec}.pdf`;
        }

        if (no_medrec && nama) {
            var fileName = createFileName(no_medrec, nama);
            document.title = fileName;
            window.print();
            setTimeout(function() {
                document.title = 'Cetak PDF dengan Nama Otomatis';
            }, 100);
        } else {
            document.title = 'Cetak PDF dengan Nama Otomatis';
            window.print();
            setTimeout(function() {
                document.title = 'Cetak PDF dengan Nama Otomatis';
                setTimeout(function() {
                    window.history.back();
                }, 100);
            }, 100);
        }
    };

    window.onafterprint = function() {
        history.go(-1);
        document.location.href = '../view/download_data.php';
    };

    document.addEventListener('input', function(event) {
        if (event.target.id === 'autoResizeTextarea') {
            event.target.style.height = 'auto';
            event.target.style.height = event.target.scrollHeight + 'px';
        }
    });
</script>

</html>
