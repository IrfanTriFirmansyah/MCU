<?php
include "../conn/koneksi.php"; // Pastikan koneksi ke database sudah sesuai

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $tanggal = $_POST['tanggal'];

    // // Query untuk mengambil data berdasarkan tanggal
    // $sql = "SELECT * FROM data_peserta
    // JOIN tb_per ON data_peserta.id_per = tb_per.id_per
    // JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
    // WHERE DATE(waktu) = '$tanggal'";
    // $result = $koneksi->query($sql);

    $nik = $_POST['nik'];

    // Query untuk mengambil data berdasarkan tanggal
    $sql = "SELECT * FROM data_peserta
    JOIN tb_per ON data_peserta.id_per = tb_per.id_per
    JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
    WHERE nik = '$nik'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
            <html>

            <head>
                <style>
                    *{
                        margin: 0;
                        padding: 0;
                    }
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
                </style>
                <link rel="preconnect" href="https://fonts.gstatic.com">
                <link rel="shortcut icon" href="../img/icons/icon-48x48.png" />

                <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

                <link href="../css/app.css" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

            </head>

            <body>


                <div class="contain row" style="page-break-after: always;">
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
                                            <div class="col-4">Kode Peserta</div>
                                            <div class="col-8">: &nbsp;<?= $row['id_peserta']; ?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="row">
                                            <div class="col-4">NIK/NIP</div>
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
                                            <div class="col-4">Tanggal Lahir</div>
                                            <div class="col-8">: &nbsp;<?= $row['tgl_lahir']; ?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="row">
                                            <div class="col-4">Department</div>
                                            <div class="col-8">: &nbsp;<?= $row['department']; ?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="row">
                                            <div class="col-4">Lokasi Kerja</div>
                                            <div class="col-8">: &nbsp;<?= $row['lokasi']; ?></div>
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

                                <img src="../img/icons/user.png" style="width: 120px; height: 120px;" alt="">

                            </div>
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
                                <h6 style="margin-top: 10px;">_______\_______\_______</h6>
                                <div style="height: 30px;"></div>
                                <h6>__________________________</h6>
                                <div style="margin-top: -10px;">(Tanda Tangan & nama Peserta MCU)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>

            </html>
<?php
        }
    } else {
        echo "
        <script>
        alert('Tidak Menemukan Peserta');
        document.location.href = '../view/peserta.php';
    </script>";
    }

    $koneksi->close();
}
?>

<script>
    window.onload = function() {
        window.print();
    }

    // Event listener untuk afterprint
    window.onafterprint = function() {
        window.location.href = '../view/peserta.php';
    }

    n = new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    document.getElementById("date").innerHTML = d + "/" + m + "/" + y; //Full date Bulan/tanggal/tahun
    document.getElementById("date1").innerHTML = d + "/" + m + "/" + y; //Full date Bulan/tanggal/tahun
</script>