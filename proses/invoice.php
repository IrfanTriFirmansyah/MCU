<?php
require "../conn/koneksi.php";

$id_peserta = $_GET['id_peserta'];

$sql = mysqli_query($koneksi, "SELECT * FROM data_peserta
JOIN tb_per ON data_peserta.id_per = tb_per.id_per
JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
WHERE id_peserta='$id_peserta'");
$row = mysqli_fetch_array($sql);

function penyebut($nilai) {
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
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut($nilai % 1000000000);
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " Triliun" . penyebut($nilai % 1000000000000);
    }
    return $temp;
}

function terbilang($nilai) {
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
} else {
    echo "Jenis kelamin tidak dikenali: " . $row['jenis_kelamin'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @media print {
            /* Mengatur orientasi kertas menjadi landscape */
            @page {
                size: portrait;
            }
        }

        .cont {
            height: 98vh;
            width: 100%;
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>
<body>
    <div class="cont">
        <table style="width: 100%; margin-top: 0px;">
            <tr>
                <td style="width: 25%; height: 50px; text-align: end; padding-right: 5px;">
                    <img src="../img/icons/icon-48x48.png" width="60px" height="60px" alt="">
                </td>
                <td style="width: 75%; text-align: start; padding-left: 25px;">
                    <b style="font-size: 15px;">KLINIK CAHAYA AMALIA</b><br>
                    <span style="font-size: 10px;">JL. KH. MUCHTAR TABRANI NO 3-5 PERWIRA, BEKASI UTARA</span><br>
                    <span style="font-size: 10px;">Telp (021) 88870888, Fax. (021) 88881747</span>
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
                                Bekasi, <span id="date"></span><br>
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
</body>
<script>
    window.onload = function() {
        window.print();
    }

    window.onafterprint = function() {
        // window.location.href = '../view/daftar_peserta.php';
        history.go(-1);
    }

    n = new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    document.getElementById("date").innerHTML = d + "/" + m + "/" + y;
</script>
</html>
