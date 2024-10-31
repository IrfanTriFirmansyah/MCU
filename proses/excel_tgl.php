<?php
require "../conn/koneksi.php";

require '../vendor/autoload.php';

// $tgl = $_POST['tgl'];

// $date = new DateTime($tgl);
// $formatDate = $date->format('d-m-Y');
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
 
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'No. Medrec');
$sheet->setCellValue('C1', 'NIK');
$sheet->setCellValue('D1', 'NAMA LENGKAP');
$sheet->setCellValue('E1', 'JENIS KELAMIN');
$sheet->setCellValue('F1', 'TANGGAL LAHIR');
// $sheet->setCellValue('G1', 'Buta Warna');
// $sheet->setCellValue('H1', 'KESAN LABORATORIUM');
// $sheet->setCellValue('I1', 'KESAN RADIOLOGI');
// $sheet->setCellValue('J1', 'KESIMPULAN');
// $sheet->setCellValue('K1', 'STATUS KESEHATAN');
 
$data = mysqli_query($koneksi,"SELECT * FROM data_peserta 
LEFT JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
LEFT JOIN tb_per ON data_peserta.id_per = tb_per.id_per
-- LEFT JOIN tb_lab ON data_peserta.nik = tb_lab.nik
-- LEFT JOIN tb_radiologi ON data_peserta.nik = tb_radiologi.nik
WHERE tb_per.nama_per = 'PT. TIRTA ALAM SEGAR' 
");
$i = 2;
$no = 1;
while($d = mysqli_fetch_array($data))
{
    $sheet->setCellValue('A'.$i, $no++);
    $sheet->setCellValue('B'.$i, $d['no_medrec']);
    $sheet->setCellValue('C'.$i1['nik'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValue('D'.$i, $d['nama']);
    $sheet->setCellValue('E'.$i, $d['jenis_kelamin']);
    $sheet->setCellValue('F'.$i, $d['tgl_lahir']);    
    // $sheet->setCellValue('G'.$i, $d['buta']);    
    // $sheet->setCellValue('H'.$i, $d['kesan_lab']);    
    // $sheet->setCellValue('I'.$i, $d['kesan_r']);    
    // $sheet->setCellValue('J'.$i, $d['kesimpulan']);    
    // $sheet->setCellValue('K'.$i, $d['ket']);    
    $i++;
}
 
$writer = new Xlsx($spreadsheet);
$writer->save('Rekapan Hasil MCU.xlsx');
echo "<script>window.location = 'Rekapan Hasil MCU.xlsx'</script>";

 
?>