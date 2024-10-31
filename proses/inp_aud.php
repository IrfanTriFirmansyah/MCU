<?php

error_reporting(0);
ini_set('display_errors', 0);

include "../conn/koneksi.php";

$no_medrec = $_POST['no_medrec'];
$dlkanan = $_POST['250_kanan'];
$dlkiri = $_POST['250_kiri'];
$bondlkanan = $_POST['bon_250_kn'];
$bondlkiri = $_POST['bon_250_kr'];
$lmkanan = $_POST['500_kanan'];
$lmkiri = $_POST['500_kiri'];
$bonlmkanan = $_POST['bon_500_kn'];
$bonlmkiri = $_POST['bon_500_kr'];
$srkanan = $_POST['1000_kanan'];
$srkiri = $_POST['1000_kiri'];
$bonsrkanan = $_POST['bon_1000_kn'];
$bonsrkiri = $_POST['bon_1000_kr'];
$trkanan = $_POST['2000_kanan'];
$trkiri = $_POST['2000_kiri'];
$bontrkanan = $_POST['bon_2000_kn'];
$bontrkiri = $_POST['bon_2000_kr'];
$erkanan = $_POST['4000_kanan'];
$erkiri = $_POST['4000_kiri'];
$bonerkanan = $_POST['bon_4000_kn'];
$bonerkiri = $_POST['bon_4000_kr'];
$enkanan = $_POST['6000_kanan'];
$enkiri = $_POST['6000_kiri'];
$bonenkanan = $_POST['bon_6000_kn'];
$bonenkiri = $_POST['bon_6000_kr'];
$drkanan = $_POST['8000_kanan'];
$drkiri = $_POST['8000_kiri'];
$bondrkanan = $_POST['bon_8000_kn'];
$bondrkiri = $_POST['bon_8000_kr'];
$kesan_a = $_POST['kesan_a'];
$saran_a = $_POST['saran_a'];
$dokter_a = $_POST['dokter_a'];

$sql = mysqli_query($koneksi, "UPDATE tb_audiometri SET 
    250_kanan='$dlkanan', 
    250_kiri='$dlkiri',
    bon_250_kanan='$bondlkanan', 
    bon_250_kiri='$bondlkiri',
    500_kanan='$lmkanan',
    500_kiri='$lmkiri',
    bon_500_kanan='$bonlmkanan',
    bon_500_kiri='$bonlmkiri',
    1000_kanan='$srkanan',
    1000_kiri='$srkiri',
    bon_1000_kanan='$bonsrkanan',
    bon_1000_kiri='$bonsrkiri',
    2000_kanan='$trkanan',
    2000_kiri='$trkiri',
    bon_2000_kanan='$bontrkanan',
    bon_2000_kiri='$bontrkiri',
    4000_kanan='$erkanan',
    4000_kiri='$erkiri',
    bon_4000_kanan='$bonerkanan',
    bon_4000_kiri='$bonerkiri',
    6000_kanan='$enkanan',
    6000_kiri='$enkiri',
    bon_6000_kanan='$bonenkanan',
    bon_6000_kiri='$bonenkiri',
    8000_kanan='$drkanan',
    8000_kiri='$drkiri',
    bon_8000_kanan='$bondrkanan',
    bon_8000_kiri='$bondrkiri',
    kesan_a='$kesan_a', 
    saran_a='$saran_a', 
    dokter_a='$dokter_a', 
    
    status='1' WHERE no_medrec='$no_medrec'");

if ($sql > 0) {
    echo "
        <script>
        alert('Data Berhasil Disimpan');
        history.go(-2);
        </script>";
} else {
    echo "Error: ";
}
