<?php

include "../conn/koneksi.php";

error_reporting(0);
ini_set('display_errors', 0);

$no_medrec = mysqli_real_escape_string($koneksi, $_POST['no_medrec']);

$hbsag = mysqli_real_escape_string($koneksi, $_POST['hbsag']);
$warna = mysqli_real_escape_string($koneksi, $_POST['warna']);
$jernih = mysqli_real_escape_string($koneksi, $_POST['jernih']);
$protein = mysqli_real_escape_string($koneksi, $_POST['protein']);
$reduksi = mysqli_real_escape_string($koneksi, $_POST['reduksi']);
$ph = mysqli_real_escape_string($koneksi, $_POST['ph']);
$berat = mysqli_real_escape_string($koneksi, $_POST['berat']);
$bilirubin = mysqli_real_escape_string($koneksi, $_POST['bilirubin']);
$urobilinogen = mysqli_real_escape_string($koneksi, $_POST['urobilinogen']);
$nitrit = mysqli_real_escape_string($koneksi, $_POST['nitrit']);
$keton = mysqli_real_escape_string($koneksi, $_POST['keton']);
$glucosa = mysqli_real_escape_string($koneksi, $_POST['glucosa']);
$blood = mysqli_real_escape_string($koneksi, $_POST['blood']);
$leukosit_s = mysqli_real_escape_string($koneksi, $_POST['leukosit_s']);
$eritrosit_s = mysqli_real_escape_string($koneksi, $_POST['eritrosit_s']);
$ephitel = mysqli_real_escape_string($koneksi, $_POST['ephitel']);
$silinder = mysqli_real_escape_string($koneksi, $_POST['silinder']);
$kristal = mysqli_real_escape_string($koneksi, $_POST['kristal']);
$bakteri = mysqli_real_escape_string($koneksi, $_POST['bakteri']);
$hemoglobin = mysqli_real_escape_string($koneksi, $_POST['hemoglobin']);
$leukosit = mysqli_real_escape_string($koneksi, $_POST['leukosit']);
$eritrosit = mysqli_real_escape_string($koneksi, $_POST['eritrosit']);
$mcv = mysqli_real_escape_string($koneksi, $_POST['mcv']);
$mch = mysqli_real_escape_string($koneksi, $_POST['mch']);
$mchc = mysqli_real_escape_string($koneksi, $_POST['mchc']);
$hematokrit = mysqli_real_escape_string($koneksi, $_POST['hematokrit']);
$trombosit = mysqli_real_escape_string($koneksi, $_POST['trombosit']);
$basofil = mysqli_real_escape_string($koneksi, $_POST['basofil']);
$eosinofil = mysqli_real_escape_string($koneksi, $_POST['eosinofil']);
$batang = mysqli_real_escape_string($koneksi, $_POST['batang']);
$segmen = mysqli_real_escape_string($koneksi, $_POST['segmen']);
$limfosit = mysqli_real_escape_string($koneksi, $_POST['limfosit']);
$monosit = mysqli_real_escape_string($koneksi, $_POST['monosit']);
$led = mysqli_real_escape_string($koneksi, $_POST['led']);
$kesan_lab = mysqli_real_escape_string($koneksi, $_POST['kesan_lab']);
$saran_lab = mysqli_real_escape_string($koneksi, $_POST['saran_lab']);
$hcg = mysqli_real_escape_string($koneksi, $_POST['hcg']);
$morphine = mysqli_real_escape_string($koneksi, $_POST['morphine']);
$amphetamine = mysqli_real_escape_string($koneksi, $_POST['amphetamine']);
$metametamin = mysqli_real_escape_string($koneksi, $_POST['metametamin']);
$thc = mysqli_real_escape_string($koneksi, $_POST['thc']);
$benzodiazephime = mysqli_real_escape_string($koneksi, $_POST['benzodiazephime']);
$ureum = mysqli_real_escape_string($koneksi, $_POST['ureum']);
$creatinin = mysqli_real_escape_string($koneksi, $_POST['creatinin']);
$gula_darah_puasa = mysqli_real_escape_string($koneksi, $_POST['gula_darah_puasa']);
$gula_darah_sewaktu = mysqli_real_escape_string($koneksi, $_POST['gula_darah_sewaktu']);
$gula_darah_2 = mysqli_real_escape_string($koneksi, $_POST['gula_darah_2']);
$kolesterol = mysqli_real_escape_string($koneksi, $_POST['kolesterol']);
$trigliserid = mysqli_real_escape_string($koneksi, $_POST['trigliserid']);
$ldl = mysqli_real_escape_string($koneksi, $_POST['ldl']);
$hdl = mysqli_real_escape_string($koneksi, $_POST['hdl']);
$sgot = mysqli_real_escape_string($koneksi, $_POST['sgot']);
$sgpt = mysqli_real_escape_string($koneksi, $_POST['sgpt']);
$gamma = mysqli_real_escape_string($koneksi, $_POST['gamma']);
$asam_urat = mysqli_real_escape_string($koneksi, $_POST['asam_urat']);
$hiv = mysqli_real_escape_string($koneksi, $_POST['hiv']);
$dokter_lab = mysqli_real_escape_string($koneksi, $_POST['dokter_lab']);

$sql = mysqli_query($koneksi, "UPDATE tb_lab SET 
hbsag='$hbsag',
warna='$warna',
jernih='$jernih',
protein='$protein',
reduksi='$reduksi',
ph='$ph',
berat='$berat',
bilirubin='$bilirubin',
urobilinogen='$urobilinogen',
nitrit='$nitrit',
keton='$keton',
glucosa='$glucosa',
blood='$blood',
leukosit_s='$leukosit_s',
eritrosit_s='$eritrosit_s',
ephitel='$ephitel',
silinder='$silinder',
kristal='$kristal',
bakteri='$bakteri',
hemoglobin='$hemoglobin',
leukosit='$leukosit',
eritrosit='$eritrosit',
mcv='$mcv',
mch='$mch',
mchc='$mchc',
hematokrit='$hematokrit',
trombosit='$trombosit',
basofil='$basofil',
eosinofil='$eosinofil',
batang='$batang',
segmen='$segmen',
limfosit='$limfosit',
monosit='$monosit',
led='$led',
hcg='$hcg',
morphine='$morphine',
amphetamine='$amphetamine',
metametamin='$metametamin',
thc='$thc',
benzodiazephime='$benzodiazephime',
ureum='$ureum',
creatinin='$creatinin',
gula_darah_sewaktu='$gula_darah_sewaktu',
gula_darah_puasa='$gula_darah_puasa',
gula_darah_2='$gula_darah_2',
kesan_lab='$kesan_lab',
saran_lab='$saran_lab' ,
kolesterol='$kolesterol' ,
trigliserid='$trigliserid' ,
ldl='$ldl' ,
hdl='$hdl' ,
sgot='$sgot' ,
sgpt='$sgpt' ,
gamma='$gamma' ,
asam_urat='$asam_urat' ,
hiv='$hiv' ,
dokter_lab='$dokter_lab' ,
status='1' WHERE no_medrec='$no_medrec'");

if ($sql > 0) {
    echo "
    <script>
    alert('Berhasil Disimpan');
    history. go(-2);  
    </script>";
} else {
    echo "Error: ";
}
