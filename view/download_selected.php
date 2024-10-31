<?php
session_start();
include '../conn/koneksi.php'; // Include your database connection
require('../vendor/autoload.php'); // Include the library for PDF generation
require('../vendor/autoload.php'); // Include the library for ZIP

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['selected_records']) && is_array($_POST['selected_records'])) {
        $selected_records = $_POST['selected_records'];
        $zip = new ZipArchive();
        $zip_filename = "selected_records_" . time() . ".zip";

        if ($zip->open($zip_filename, ZipArchive::CREATE) !== TRUE) {
            exit("Cannot open <$zip_filename>\n");
        }

        foreach ($selected_records as $no_medrec) {
            // Generate PDF for each selected record
            $pdf_content = generatePDF($no_medrec); // Create a function to generate PDF
            $pdf_filename = "medrec_{$no_medrec}.pdf";
            $zip->addFromString($pdf_filename, $pdf_content);
        }

        $zip->close();

        // Download the ZIP file
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename=' . basename($zip_filename));
        header('Content-Length: ' . filesize($zip_filename));
        readfile($zip_filename);

        // Optionally, delete the zip file after download
        unlink($zip_filename);
    } else {
        echo "No records selected!";
    }
}
function generatePDF($no_medrec)
{
    global $koneksi; // Access the database connection

    // Query the database for the record
    $van = mysqli_query($koneksi, "SELECT * FROM data_peserta
    JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
    JOIN tb_per ON data_peserta.id_per = tb_per.id_per
    JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
    WHERE rekam_mcu.no_medrec = '$no_medrec'");

    if (!$van) {
        die('Query Error: ' . mysqli_error($koneksi));
    }

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

    if (!$vans) {
        die('Query Error: ' . mysqli_error($koneksi));
    }

    // $sqls = mysqli_fetch_array($vans);
    // $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE aktif='2'");
    // $tkd = mysqli_fetch_array($dokter);

    // Create PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    // $pdf->SetFont('helvetica', '', 12);

    // Use your HTML template for content
    ob_start(); // Start output buffering

    
?>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Medical Check Up</title>
        <title>Halaman Cetak</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="shortcut icon" href="../img/icons/icon-48x48.png" />

        <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

        <link href="../css/app.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
        <style>

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

    </style>
    </head>

   
<body>
    <div class="row">

        <div class="col-12 w-100" style=" height: 100vh;">
            <table style="border-collapse: collapse; width: 100%; height: 100%;">
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
                                    <img src="<?= htmlspecialchars ($sql['foto']) ?>" style="border: 1px solid orangered;" width="400px" height="400px" alt="">
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
                                            <td style="width: 250px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= htmlspecialchars ($sql['nik']) ?></td>
                                            <td style="width: 170px;">Tanggal Periksa</td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px;">Nama Lengkap</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= htmlspecialchars ($sql['nama']) ?></td>
                                            <td style="width: 170px;">Pemeriksa Akhir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= htmlspecialchars ($sql['dokter']) ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px;">Jenis Kelamin</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= htmlspecialchars ($sql['jenis_kelamin']) ?></td>
                                            <td style="width: 170px;">No. Medrec</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= htmlspecialchars ($sql['no_medrec']) ?></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td style="width: 170px;">Tanggal Lahir</td>
                                            <td style="width: 270px;" class="border border-dark border-start-0 border-top-0 border-bottom-0">: <?= htmlspecialchars ($sql['tgl_lahir']) ?></td>
                                            <td style="width: 170px;">Perusahaan</td>
                                            <td style="width: 270px;">: <?= htmlspecialchars ($sql['nama_per']) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>







        <div class="col-12l-1200 p-4" style=" height: 100vh;">
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
                                        <td style="width: 250px;">: <?= htmlspecialchars ($sql['nik']) ?></td>
                                        <td style="width: 170px;">Tanggal Periksa</td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">Nama Lengkap</td>
                                        <td style="width: 270px;">: <?= htmlspecialchars ($sql['nama']) ?></td>
                                        <td style="width: 170px;">Dokter Penanggung Jawab</td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">Jenis Kelamin</td>
                                        <td style="width: 270px;">: <?= htmlspecialchars ($sql['jenis_kelamin']) ?></td>
                                        <td style="width: 170px;">No. Medrec</td>
                                        <td style="width: 270px;">: <?= htmlspecialchars ($sql['no_medrec']) ?></td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">Tanggal Lahir</td>
                                        <td style="width: 270px;">: <?= htmlspecialchars ($sql['tgl_lahir']) ?></td>
                                        <td style="width: 170px;">Perusahaan</td>
                                        <td style="width: 270px;">: <?= htmlspecialchars ($sql['nama_per']) ?></td>
                                    </tr>
                                    <tr style="text-align: left; padding-left:25px">
                                        <td style="width: 170px;">No. Telepon</td>
                                        <td style="width: 270px;">: <?= htmlspecialchars ($sql['telp']) ?></td>
                                        <td style="width: 170px;">Department</td>
                                        <td style="width: 270px;">: <?= htmlspecialchars ($sql['department']) ?></td>
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
                                        <td class="border border-dark" style="padding: 10px; vertical-align: top; height: 300px; width: 45%;">
                                            <textarea name="" id="autoResizeTextarea" style="font-size: 13px; background: none; border: none; resize: none;"><?= htmlspecialchars ($sql["kesimpulan"]) ?></textarea>
                                        </td>
                                        <td class="border border-dark" style="padding: 10px; vertical-align: top; height: 300px; width: 45%;">

                                            <textarea name="" id="autoResizeTextarea" style="font-size: 13px; background: none; border: none; resize: none;"><?= htmlspecialchars ($sql["saran"]) ?></textarea>
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


    </html>
<?php
    $html_content = ob_get_clean(); // Get the buffered content

    // Convert HTML to PDF
    $pdf->writeHTML($html_content, true, false, true, false, '');

    // Close and output PDF document
    return $pdf->Output('', 'S'); // Return PDF as string
}
