<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Data Rekam Medis</title>
    <style>
        @media print {
            @page {
                size: A4 landscape;
            }

            .page-break {
                page-break-before: always;
            }
        }

        * {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: grey;
            color: white;
        }

        th,
        td {
            padding: 8px;
            vertical-align: top;
        }

        img {
            width: 150px;
        }

        .header {
            background-color: grey;
            color: white;
        }

        .page-content {
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            height: 100%;
            border: none;
            resize: none;
            overflow: hidden;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Mendapatkan input dari form
        $company = $_GET['company'];
        $start_num = (int) $_GET['start_num'];
        $end_num = (int) $_GET['end_num'];

        // Validasi input
        if ($end_num < $start_num || ($end_num - $start_num + 1) > 10) {
            die('Rentang nomor rekam medis tidak valid atau melebihi batas maksimum 10 data.');
        }

        // Menghubungkan ke database
        include '../conn/koneksi.php';

        $peserta = [];
        // Loop untuk mengambil data dari database
        for ($i = $start_num; $i <= $end_num; $i++) {
            $no_medrec = $company . str_pad($i, 4, '0', STR_PAD_LEFT);

            // Query untuk mengambil data rekam medis
            $sql = "SELECT *
                    FROM data_peserta
                    JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
                    JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                    JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                    WHERE rekam_mcu.no_medrec = ?";

            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param('s', $no_medrec);
            $stmt->execute();
            $result = $stmt->get_result();

            $rme = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
            LEFT JOIN tb_umum ON rekam_mcu.no_medrec = tb_umum.no_medrec
            LEFT JOIN tb_lab ON rekam_mcu.no_medrec = tb_lab.no_medrec
            LEFT JOIN tb_radiologi ON rekam_mcu.no_medrec = tb_radiologi.no_medrec
            LEFT JOIN tb_audiometri ON rekam_mcu.no_medrec = tb_audiometri.no_medrec
            LEFT JOIN tb_spirometri ON rekam_mcu.no_medrec = tb_spirometri.no_medrec
            LEFT JOIN tb_ekg ON rekam_mcu.no_medrec = tb_ekg.no_medrec
            WHERE rekam_mcu.no_medrec = '$no_medrec'");

            $medrec = mysqli_fetch_array($rme);
            $data = mysqli_fetch_array($result);

            $waktu_daftar = $data['waktu_daftar'];
            $tgl_dft = date('d-m-Y H:i:s', strtotime($waktu_daftar));

            if ($data) {
                $peserta[] = ['data' => $data, 'medrec' => $medrec];
            }
        }

        $count = 0;
        foreach ($peserta as $pesertaItem) {
            if ($count % 2 == 0) {
                if ($count > 0) {
                    echo '<div class="page-break"></div>';
                }
                echo '<table>
                        <tr class="header">
                            <th style="width: 5%; vertical-align: middle;">Foto</th>
                            <th style="width: 15%; vertical-align: middle;">Identitas</th>
                            <th style="width: 10%; vertical-align: middle;">Tanggal Pemeriksaan</th>
                            <th style="width: 40%; vertical-align: middle;">Kesimpulan</th>
                            <th style="width: 900px; vertical-align: middle;">Saran</th>
                        </tr>';
            }

            $data = $pesertaItem['data'];
            $medrec = $pesertaItem['medrec'];
    ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($data['foto']) ?>" alt="Foto Peserta">
                </td>
                <td>
                    <?= $data['no_medrec'] ?><br>
                    <b><?= $data['nama'] ?> (<?= $data['jenis_kelamin'] == 'PEREMPUAN' ? "P" : "L" ?>)</b><br>
                    <?= $data['nik'] ?><br>
                    <?= $data['tgl_lahir'] ?><br>
                    <span style="font-size: 13px;"><?= $data['alamat'] ?></span>
                </td>
                <td>
                    <?= $tgl_dft ?>
                </td>
                <td>
                    <table style="width: 100%; font-size: 12px;">
                        <?php
                        $mor = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$data[id_paket]'");

                        while ($rom = mysqli_fetch_array($mor)) {
                            $tipe_paket = $rom['tipe_paket'];
                            switch ($tipe_paket) {
                                case 'tb_umum': ?>
                                    <tr>
                                        <td style="width: 30%; padding: 0;">Riwayat Penyakit</td>
                                        <td style="width: 5%; padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['rwt_penyakit'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Pemeriksaan Fisik</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['kesan_u'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Buta Warna</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['buta'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Visus Kanan</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['vod'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Visus Kiri</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['vos'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Berat Badan</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['bb'] ?> Kg</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Tinggi Badan</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['tb'] ?> Cm</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Tekanan Darah</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['tekanan'] ?> mm/Hg</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">Nilai BMI</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['imt'] ?> <b>(<?= $medrec['stat'] ?>)</b></td>
                                    </tr>
                                <?php
                                    break;
                                case 'tb_lab':
                                ?>
                                    <tr>
                                        <td style="padding: 0;">Laboratorium</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['kesan_lab'] ?></td>
                                    </tr>
                                    <?php
                                    if ($data['jenis_kelamin'] == 'PEREMPUAN') {
                                    ?>
                                        <tr>
                                            <td style="padding: 0;">Test Kehamilan</td>
                                            <td style="padding: 0;">:</td>
                                            <td style="padding: 0;"><?= $medrec['hcg'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    break;
                                case 'tb_audiometri':
                                    ?>
                                    <tr>
                                        <td style='padding: 0;'>Audiometri</td>
                                        <td style='padding: 0;'>:</td>
                                        <td style='padding: 0;'><?= $medrec['kesan_a'] ?></td>
                                    </tr>
                                <?php
                                    break;
                                case 'tb_spirometri':
                                ?>
                                    <tr>
                                        <td style='padding: 0;'>Spirometri</td>
                                        <td style='padding: 0;'>:</td>
                                        <td style='padding: 0;'><?= $medrec['kesan_s'] ?></td>
                                    </tr>
                                <?php
                                    break;
                                case 'tb_ekg':
                                ?>
                                    <tr>
                                        <td style='padding: 0;'>EKG</td>
                                        <td style='padding: 0;'>:</td>
                                        <td style='padding: 0;'><?= $medrec['kesan_e'] ?></td>
                                    </tr>
                                <?php
                                    break;
                                case 'tb_radiologi':
                                ?>
                                    <tr>
                                        <td style="padding: 0;">Radiologi</td>
                                        <td style="padding: 0;">:</td>
                                        <td style="padding: 0;"><?= $medrec['kesan_r'] ?></td>
                                    </tr>
                                <?php
                                    break;
                                default:
                                    break;
                                ?>

                        <?php
                            }
                        } ?>
                        <tr>
                            <td style="padding: 0;">Kesimpulan</td>
                            <td style="padding: 0;">:</td>
                            <td style="padding: 0;"><b><?= $medrec['ket'] ?></b></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <textarea style="border: none; resize: none;" cols="25" rows="20"><?= $medrec['saran'] ?></textarea>
                </td>
            </tr>
    <?php
            if ($count % 2 == 1) {
                echo '</table>';
            }
            $count++;
        }
        if ($count % 2 == 1) {
            echo '</table>';
        }

        $koneksi->close();
    }
    ?>
</body>

<script>
    window.onload = function() {
        // Mendapatkan nilai parameter 'nik' dan 'nama' dari URL
        var urlParams = new URLSearchParams(window.location.search);
        var start_num = urlParams.get('start_num');
        var end_num = urlParams.get('end_num');

        // Fungsi untuk membuat end_num file
        function createFileName(start_num, end_num) {
            return start_num ? `${start_num}-${end_num}.pdf` : `${end_num}.pdf`;
        }

        // Jika 'start_num' dan 'end_num' disediakan, buat end_num file
        if (start_num && end_num) {
            var fileName = createFileName(start_num, end_num);
            document.title = fileName;

            // Cetak halaman ke PDF dengan end_num file yang dihasilkan
            window.print();

            // Setelah mencetak, kembalikan end_num file ke default setelah jeda
            setTimeout(function() {
                document.title = 'Cetak PDF dengan nama Otomatis';
            }, 1000); // Sesuaikan jeda ini jika diperlukan
        } else {
            // Perilaku default jika tidak ada 'nik' atau 'nama' disediakan
            document.title = 'Cetak PDF dengan nama Otomatis';
            window.print();
            setTimeout(function() {
                document.title = 'Cetak PDF dengan nama Otomatis';
                setTimeout(function() {
                    window.history.back();
                }, 1000);
            }, 1000); // Sesuaikan jeda ini jika diperlukan
        }
    };
    window.onafterprint = function() {
        // history.go(-1);
        document.location.href = '../view/rekap_pdf.php'
    }
</script>

</html>