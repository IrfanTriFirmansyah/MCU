<?php

require '../conn/koneksi.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$per = $_POST['perusahaan'];


if (isset($_POST['date'])) {

    $tgl = $_POST['tgl'];
    $date = new DateTime($tgl);
    $formatDate = $date->format('d-m-Y');

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'TANGGAL PEMERIKSAAN');
    $sheet->setCellValue('C1', 'No. Medrec');
    $sheet->setCellValue('D1', 'NIK');
    $sheet->setCellValue('E1', 'NAMA LENGKAP');
    $sheet->setCellValue('F1', 'NAMA PERUSAHAAN');
    $sheet->setCellValue('G1', 'DIVISI');
    $sheet->setCellValue('H1', 'LOKASI KERJA');
    $sheet->setCellValue('I1', 'JENIS KELAMIN');
    $sheet->setCellValue('J1', 'KESAN PEMERIKSAAN FISIK');
    $sheet->setCellValue('K1', 'BUTA WARNA');
    $sheet->setCellValue('L1', 'KEPALA');
    $sheet->setCellValue('M1', 'MATA');
    $sheet->setCellValue('N1', 'TENSI');
    $sheet->setCellValue('O1', 'TB');
    $sheet->setCellValue('P1', 'BB');
    $sheet->setCellValue('Q1', 'ABDOMEN');
    $sheet->setCellValue('R1', 'ANGGOTA GERAK');
    $sheet->setCellValue('S1', 'HBSAG');
    $sheet->setCellValue('T1', 'FUNGSI HATI');
    $sheet->setCellValue('U1', 'KESAN LABORATORIUM');
    $sheet->setCellValue('V1', 'KESAN AUDIOMETRI');
    $sheet->setCellValue('W1', 'KESAN SPIROMETRI');
    $sheet->setCellValue('X1', 'KESAN EKG');
    $sheet->setCellValue('Y1', 'KESAN RADIOLOGI');
    $sheet->setCellValue('Z1', 'KESIMPULAN');
    $sheet->setCellValue('AA1', 'SARAN');
    $sheet->setCellValue('AB1', 'STATUS KESEHATAN');
    $sheet->setCellValue('AC1', 'KOLESTEROL');
    $sheet->setCellValue('AD1', 'GULA DARAH SEWAKTU');
    $sheet->setCellValue('AE1', 'GULA DARAH 2 JAM PP');
    $sheet->setCellValue('AF1', 'ASAM URAT');

    $id = mysqli_query($koneksi, "SELECT * FROM data_peserta
JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
JOIN tb_per ON data_peserta.id_per = tb_per.id_per
JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
WHERE rekam_mcu.tgl = '$formatDate' AND data_peserta.id_per = '$per' ORDER BY rekam_mcu.id_rm
");

    $i = 2;
    $no = 1;
    while ($i1 = mysqli_fetch_array($id)) {
        $sheet->setCellValue('A' . $i, $no++);
        $sheet->setCellValue('B' . $i, $i1['waktu_daftar']);
        $sheet->setCellValue('C' . $i, $i1['no_medrec']);
        $sheet->setCellValueExplicit('D' . $i, $i1['nik'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('E' . $i, $i1['nama']);
        $sheet->setCellValue('F' . $i, $i1['nama_per']);
        $sheet->setCellValue('G' . $i, $i1['department']);
        $sheet->setCellValue('H' . $i, $i1['nama_paket']);
        $sheet->setCellValue('I' . $i, $i1['jenis_kelamin']);
        $i++;
    }

    $data = mysqli_query($koneksi, "SELECT * FROM rekam_mcu 
LEFT JOIN tb_umum ON rekam_mcu.no_medrec = tb_umum.no_medrec
LEFT JOIN tb_lab ON rekam_mcu.no_medrec = tb_lab.no_medrec
LEFT JOIN tb_audiometri ON rekam_mcu.no_medrec = tb_audiometri.no_medrec
LEFT JOIN tb_spirometri ON rekam_mcu.no_medrec = tb_spirometri.no_medrec
LEFT JOIN tb_ekg ON rekam_mcu.no_medrec = tb_ekg.no_medrec
LEFT JOIN tb_radiologi ON rekam_mcu.no_medrec = tb_radiologi.no_medrec
WHERE rekam_mcu.tgl = '$formatDate' AND rekam_mcu.id_per = '$per' ORDER BY rekam_mcu.id_rm
");



    $i = 2;
    $no = 1;
    while ($d = mysqli_fetch_array($data)) {

        $sheet->setCellValue('J' . $i, $d['kesan_u']);
        $sheet->setCellValue('K' . $i, $d['buta']);
        $sheet->setCellValue('L' . $i, $d['kepala']);
        $sheet->setCellValue('M' . $i, 'VOD : ' . $d['vod'] . ' VOS : ' . $d['vos']);
        $sheet->setCellValue('N' . $i, $d['tekanan']);
        $sheet->setCellValue('O' . $i, $d['tb']);
        $sheet->setCellValue('P' . $i, $d['bb']);
        $sheet->setCellValue('Q' . $i, $d['perut']);
        $sheet->setCellValue('R' . $i, $d['gerak']);
        $sheet->setCellValue('S' . $i, $d['hbsag']);
        $sheet->setCellValue('T' . $i, 'SGOT: ' . $d['sgot'] . ' SGPT : ' . $d['sgpt']);
        $sheet->setCellValue('U' . $i, $d['kesan_lab']);
        $sheet->setCellValue('V' . $i, $d['kesan_a']);
        $sheet->setCellValue('W' . $i, $d['kesan_s']);
        $sheet->setCellValue('X' . $i, $d['kes_e']);
        $sheet->setCellValue('Y' . $i, $d['kesan_r']);
        $sheet->setCellValue('Z' . $i, $d['kesimpulan']);
        $sheet->setCellValue('AA' . $i, $d['saran']);
        $sheet->setCellValue('AB' . $i, $d['ket']);
        $sheet->setCellValue('AC' . $i, $d['kolesterol']);
        $sheet->setCellValue('AD' . $i, $d['gula_darah_sewaktu']);
        $sheet->setCellValue('AE' . $i, $d['gula_darah_2']);
        $sheet->setCellValue('AF' . $i, $d['asam_urat']);
        $i++;
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save('Rekapan Hasil MCU.xlsx');
    echo "<script>window.location = 'Rekapan Hasil MCU.xlsx'</script>";
} else {

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'TANGGAL PEMERIKSAAN');
    $sheet->setCellValue('C1', 'No. Medrec');
    $sheet->setCellValue('D1', 'NIK');
    $sheet->setCellValue('E1', 'NAMA PAKET');
    $sheet->setCellValue('F1', 'NAMA LENGKAP');
    $sheet->setCellValue('G1', 'NAMA PERUSAHAAN');
    $sheet->setCellValue('H1', 'DEPARTMENT');
    $sheet->setCellValue('I1', 'LOKASI KERJA');
    $sheet->setCellValue('J1', 'JENIS KELAMIN');
    $sheet->setCellValue('K1', 'TANGGAL LAHIR');
    $sheet->setCellValue('L1', 'KESAN PEMERIKSAAN FISIK');
    $sheet->setCellValue('M1', 'MATA');
    $sheet->setCellValue('N1', 'TENSI');
    $sheet->setCellValue('O1', 'TB');
    $sheet->setCellValue('P1', 'BB');
    $sheet->setCellValue('Q1', 'ABDOMEN');
    $sheet->setCellValue('R1', 'BUTA WARNA');
    $sheet->setCellValue('S1', 'HBSAG');
    $sheet->setCellValue('T1', 'KOLESTEROL');
    $sheet->setCellValue('U1', 'LDL');
    $sheet->setCellValue('V1', 'HDL');
    $sheet->setCellValue('W1', 'TRIGLISERIDA');
    $sheet->setCellValue('X1', 'GULA DARAH PUASA');
    $sheet->setCellValue('Y1', 'GULA DARAH SEWAKTU');
    $sheet->setCellValue('Z1', 'ASAM URAT');
    $sheet->setCellValue('AA1', 'KESAN LABORATORIUM');
    $sheet->setCellValue('AB1', 'KESAN AUDIOMETRI');
    $sheet->setCellValue('AC1', 'KESAN SPIROMETRI');
    $sheet->setCellValue('AD1', 'KESAN EKG');
    $sheet->setCellValue('AE1', 'KESAN RADIOLOGI');
    $sheet->setCellValue('AF1', 'KESIMPULAN');
    $sheet->setCellValue('AG1', 'SARAN');
    $sheet->setCellValue('AH1', 'STATUS KESEHATAN');

    $id = mysqli_query($koneksi, "SELECT * FROM data_peserta
JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
JOIN tb_per ON data_peserta.id_per = tb_per.id_per
JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
WHERE data_peserta.id_per = '$per' ORDER BY rekam_mcu.id_rm
");

    $data = mysqli_query($koneksi, "SELECT * FROM rekam_mcu 
LEFT JOIN tb_umum ON rekam_mcu.no_medrec = tb_umum.no_medrec
LEFT JOIN tb_lab ON rekam_mcu.no_medrec = tb_lab.no_medrec
LEFT JOIN tb_audiometri ON rekam_mcu.no_medrec = tb_audiometri.no_medrec
LEFT JOIN tb_spirometri ON rekam_mcu.no_medrec = tb_spirometri.no_medrec
LEFT JOIN tb_ekg ON rekam_mcu.no_medrec = tb_ekg.no_medrec
LEFT JOIN tb_radiologi ON rekam_mcu.no_medrec = tb_radiologi.no_medrec
WHERE rekam_mcu.id_per = '$per' ORDER BY rekam_mcu.id_rm
");

    $i = 2;
    $no = 1;
    while ($i1 = mysqli_fetch_array($id)) {

        $waktu_daftar = $i1['waktu_daftar'];
        $tgl_dft = date('d-m-Y H:i:s', strtotime($waktu_daftar));

        $sheet->setCellValue('A' . $i, $no++);
        $sheet->setCellValue('B' . $i, $i1['waktu_daftar']);
        $sheet->setCellValue('C' . $i, $i1['no_medrec']);
        $sheet->setCellValueExplicit('D' . $i, $i1['nik'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('E' . $i, $i1['nama_paket']);
        $sheet->setCellValue('F' . $i, $i1['nama']);
        $sheet->setCellValue('G' . $i, $i1['nama_per']);
        $sheet->setCellValue('H' . $i, $i1['department']);
        $sheet->setCellValue('I' . $i, $i1['lokasi']);
        $sheet->setCellValue('J' . $i, $i1['jenis_kelamin']);
        $sheet->setCellValue('K' . $i, $i1['tgl_lahir']);
        $i++;
    }

    $i = 2;
    $no = 1;
    while ($d = mysqli_fetch_array($data)) {

        $sheet->setCellValue('L' . $i, $d['kesan_u']);
        $sheet->setCellValue('M' . $i, 'VOD : ' . $d['vod'] . ' VOS : ' . $d['vos']);
        $sheet->setCellValue('N' . $i, $d['tekanan']);
        $sheet->setCellValue('O' . $i, $d['tb']);
        $sheet->setCellValue('P' . $i, $d['bb']);
        $sheet->setCellValue('Q' . $i, $d['perut']);
        $sheet->setCellValue('R' . $i, $d['buta']);
        $sheet->setCellValue('S' . $i, $d['hbsag']);
        $sheet->setCellValue('T' . $i, $d['kolesterol']);
        $sheet->setCellValue('U' . $i, $d['ldl']);
        $sheet->setCellValue('V' . $i, $d['hdl']);
        $sheet->setCellValue('W' . $i, $d['trigliserid']);
        $sheet->setCellValue('X' . $i, $d['gula_darah_puasa']);
        $sheet->setCellValue('Y' . $i, $d['gula_darah_sewaktu']);
        $sheet->setCellValue('Z' . $i, $d['asam_urat']);
        $sheet->setCellValue('AA' . $i, $d['kesan_lab']);
        $sheet->setCellValue('AB' . $i, $d['kesan_a']);
        $sheet->setCellValue('AC' . $i, $d['kesan_s']);
        $sheet->setCellValue('AD' . $i, $d['kes_e']);
        $sheet->setCellValue('AE' . $i, $d['kesan_r']);
        $sheet->setCellValue('AF' . $i, $d['kesimpulan']);
        $sheet->setCellValue('AG' . $i, $d['saran']);
        $sheet->setCellValue('AH' . $i, $d['ket']);
        $i++;
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save('Rekapan Hasil MCU.xlsx');
    echo "<script>window.location = 'Rekapan Hasil MCU.xlsx'</script>";
}
