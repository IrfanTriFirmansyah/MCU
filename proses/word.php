<?php

require "../vendor/autoload.php";
require "../conn/koneksi.php";

use PhpOffice\PhpWord\TemplateProcessor;

$nik = $_GET['nik'];

$car = mysqli_query($koneksi, "SELECT * FROM data_peserta WHERE nik='$nik'");
$row = mysqli_fetch_array($car);

$van = mysqli_query($koneksi, "SELECT * FROM rekam_mcu WHERE nik='$nik'");
$sql = mysqli_fetch_array($van);

$templateProcessor = new TemplateProcessor('../main/MCU.docx');

$templateProcessor->setValues(
    [
        'nik' => $row["nik"],
        'nama' => $row["nama"],
        'tgl' => $row['tgl_lahir'],
        'tgl_p' => $sql['tgl'],
        'dokter' => $sql['dokter'],
        'no' => $sql['id'],
    ]
);

$templateProcessor->setImageValue(
    'foto',
    [
        'path' => htmlspecialchars($sql['foto']),
        'width' => 320,
        'height' => 300,
        'ratio' => false
    ]
);

$pathToSave = 'contoh.docx';
$templateProcessor->saveAs($pathToSave);

// Mengonversi Word ke gambar menggunakan LibreOffice
$outputDir = 'output_images';
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// Path untuk menyimpan file PDF sementara
$pdfPath = $outputDir . '/temp.pdf';

// Mengonversi DOCX ke PDF menggunakan LibreOffice
$command = 'libreoffice --headless --convert-to pdf ' . escapeshellarg($pathToSave) . ' --outdir ' . escapeshellarg($outputDir);
exec($command);

// Mengonversi setiap halaman PDF ke gambar JPG
$command = 'convert -density 150 ' . escapeshellarg($pdfPath) . ' -quality 90 ' . escapeshellarg($outputDir . '/page-%d.jpg');
exec($command);

// Hapus file sementara DOCX dan PDF
unlink($pathToSave);
unlink($pdfPath);

// Menampilkan gambar pada halaman HTML untuk dicetak
$images = glob($outputDir . '/page-*.jpg');

echo '<html><head><title>Print</title></head><body>';
foreach ($images as $image) {
    echo '<div style="page-break-after: always;"><img src="' . $image . '" style="width: 100%; height: auto;"></div>';
}
echo '<script>window.onload = function() { window.print(); };</script>';
echo '</body></html>';
?>
