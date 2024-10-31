<?php

include "../conn/koneksi.php";

$nik = $_POST['nik'];
$test_menit = $_POST['test_menit'];
$test_detik = $_POST['test_detik'];
$nadi_max_menit = $_POST['nadi_max_menit'];
$nadi_max_persen = $_POST['nadi_max_persen'];
$tekanan = $_POST['tekanan'];
$nadi = $_POST['nadi'];
$alasan = $_POST['alasan'];
$kapasitas = $_POST['kapasitas'];
$aritmia = $_POST['aritmia'];
$stt = $_POST['stt'];
$miokard = $_POST['miokard'];
$kes_tekanan = $_POST['kes_tekanan'];
$kebugaran = $_POST['kebugaran'];
$signifikasi = $_POST['signifikasi'];
$kesan_t = $_POST['kesan_t'];
$saran_t = $_POST['saran_t'];
$dokter_t = $_POST['dokter_t'];

$sql = mysqli_query($koneksi, "UPDATE tb_treadmil SET
test_menit='$test_menit',test_detik='$test_detik',nadi_max_menit='$nadi_max_menit',nadi_max_persen='$nadi_max_persen',tekanan='$tekanan',nadi='$nadi',alasan='$alasan',kapasitas='$kapasitas',aritmia='$aritmia',pstt='$stt',miokard='$miokard',kes_tekanan='$kes_tekanan',kebugaran='$kebugaran',signifikasi='$signifikasi',
kesan_t='$kesan_t', saran_t='$saran_t', dokter_t='$dokter_t', status='1' WHERE nik='$nik'");

if ($sql > 0) {
    echo "
    <script>
    alert('Berhasil Disimpan');
    document.location.href = '../view/pemeriksaan.php'
    </script>";
} else {
    echo "Error: ";
}
