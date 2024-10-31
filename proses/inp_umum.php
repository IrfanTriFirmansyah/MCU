<?php

include "../conn/koneksi.php";

$no_medrec = mysqli_real_escape_string($koneksi, $_POST['no_medrec']);
$merokok = mysqli_real_escape_string($koneksi, $_POST['merokok']);
$keluhan = mysqli_real_escape_string($koneksi, $_POST['keluhan']);
$inp_keluhan = mysqli_real_escape_string($koneksi, $_POST['inp_keluhan']);
$alkohol = mysqli_real_escape_string($koneksi, $_POST['alkohol']);
$asma = mysqli_real_escape_string($koneksi, $_POST['asma']);
$tbc = mysqli_real_escape_string($koneksi, $_POST['tbc']);
$operasi = mysqli_real_escape_string($koneksi, $_POST['operasi']);
$inp_operasi = mysqli_real_escape_string($koneksi, $_POST['inp_operasi']);
$alergi = mysqli_real_escape_string($koneksi, $_POST['alergi']);
$inp_alergi = mysqli_real_escape_string($koneksi, $_POST['inp_alergi']);
$olahraga = mysqli_real_escape_string($koneksi, $_POST['olahraga']);
$rwt_penyakit = mysqli_real_escape_string($koneksi, $_POST['rwt_penyakit']);
$rwt_penyakit_kel = mysqli_real_escape_string($koneksi, $_POST['rwt_penyakit_kel']);
$tekanan = mysqli_real_escape_string($koneksi, $_POST['tekanan']);
$tb = mysqli_real_escape_string($koneksi, $_POST['tb']);
$bb = mysqli_real_escape_string($koneksi, $_POST['bb']);
$stat = mysqli_real_escape_string($koneksi, $_POST['stat']);
$imt = mysqli_real_escape_string($koneksi, $_POST['imt']);
$detak = mysqli_real_escape_string($koneksi, $_POST['detak']);
$nafas = mysqli_real_escape_string($koneksi, $_POST['nafas']);
$suhu = mysqli_real_escape_string($koneksi, $_POST['suhu']);
$kepala = mysqli_real_escape_string($koneksi, $_POST['kepala']);
$inp_kepala = mysqli_real_escape_string($koneksi, $_POST['inp_kepala']);
$leher = mysqli_real_escape_string($koneksi, $_POST['leher']);
$inp_leher = mysqli_real_escape_string($koneksi, $_POST['inp_leher']);
$tht = mysqli_real_escape_string($koneksi, $_POST['tht']);
$inp_tht = mysqli_real_escape_string($koneksi, $_POST['inp_tht']);
$dada = mysqli_real_escape_string($koneksi, $_POST['dada']);
$inp_dada = mysqli_real_escape_string($koneksi, $_POST['inp_dada']);
$jantung = mysqli_real_escape_string($koneksi, $_POST['jantung']);
$inp_jantung = mysqli_real_escape_string($koneksi, $_POST['inp_jantung']);
$paru = mysqli_real_escape_string($koneksi, $_POST['paru']);
$inp_paru = mysqli_real_escape_string($koneksi, $_POST['inp_paru']);
$perut = mysqli_real_escape_string($koneksi, $_POST['perut']);
$inp_perut = mysqli_real_escape_string($koneksi, $_POST['inp_perut']);
$kemih = mysqli_real_escape_string($koneksi, $_POST['kemih']);
$inp_kemih = mysqli_real_escape_string($koneksi, $_POST['inp_kemih']);
$sendi = mysqli_real_escape_string($koneksi, $_POST['sendi']);
$inp_sendi = mysqli_real_escape_string($koneksi, $_POST['inp_sendi']);
$syaraf = mysqli_real_escape_string($koneksi, $_POST['syaraf']);
$inp_syaraf = mysqli_real_escape_string($koneksi, $_POST['inp_syaraf']);
$gerak = mysqli_real_escape_string($koneksi, $_POST['gerak']);
$inp_gerak = mysqli_real_escape_string($koneksi, $_POST['inp_gerak']);
$buta = mysqli_real_escape_string($koneksi, $_POST['buta']);
$bibir = mysqli_real_escape_string($koneksi, $_POST['bibir']);
$inp_bibir = mysqli_real_escape_string($koneksi, $_POST['inp_bibir']);
$gigi = mysqli_real_escape_string($koneksi, $_POST['gigi']);
$inp_gigi = mysqli_real_escape_string($koneksi, $_POST['inp_gigi']);
$gusi = mysqli_real_escape_string($koneksi, $_POST['gusi']);
$inp_gusi = mysqli_real_escape_string($koneksi, $_POST['inp_gusi']);
$mukosa = mysqli_real_escape_string($koneksi, $_POST['mukosa']);
$inp_mukosa = mysqli_real_escape_string($koneksi, $_POST['inp_mukosa']);
$vod = mysqli_real_escape_string($koneksi, $_POST['vod']);
$vos = mysqli_real_escape_string($koneksi, $_POST['vos']);
$note_mata = mysqli_real_escape_string($koneksi, $_POST['note_mata']);
$kesan_u = mysqli_real_escape_string($koneksi, $_POST['kesan_u']);
$saran_u = mysqli_real_escape_string($koneksi, $_POST['saran_u']);
$dokter_u = mysqli_real_escape_string($koneksi, $_POST['dokter_u']);

$sql = mysqli_query($koneksi, "UPDATE tb_umum SET 
merokok='$merokok',
keluhan='$keluhan',
inp_keluhan='$inp_keluhan',
alkohol='$alkohol',
asma='$asma',
tbc='$tbc',
operasi='$operasi',
inp_operasi='$inp_operasi',
alergi='$alergi',
inp_alergi='$inp_alergi',
olahraga='$olahraga',
rwt_penyakit='$rwt_penyakit',
rwt_penyakit_kel='$rwt_penyakit_kel',
tekanan='$tekanan',
tb='$tb',
bb='$bb',
stat='$stat',
imt='$imt',
detak='$detak',
nafas='$nafas',
suhu='$suhu',
kepala='$kepala',
inp_kepala='$inp_kepala',
leher='$leher',
inp_leher='$inp_leher',
tht='$tht',
inp_tht='$inp_tht',
dada='$dada',
inp_dada='$inp_dada',
jantung='$jantung',
inp_jantung='$inp_jantung',
paru='$paru',
inp_paru='$inp_paru',
perut='$perut',
inp_perut='$inp_perut',
kemih='$kemih',
inp_kemih='$inp_kemih',
sendi='$sendi',
inp_sendi='$inp_sendi',
syaraf='$syaraf',
inp_syaraf='$inp_syaraf',
gerak='$gerak',
inp_gerak='$inp_gerak',
buta='$buta',
bibir='$bibir',
inp_bibir='$inp_bibir',
gigi='$gigi',
inp_gigi='$inp_gigi',
gusi='$gusi',
inp_gusi='$inp_gusi',
mukosa='$mukosa',
inp_mukosa='$inp_mukosa',
vod = '$vod',
vos = '$vos',
note_mata = '$note_mata',
kesan_u='$kesan_u', 
saran_u='$saran_u', 
dokter_u='$dokter_u', 
status='1' 
WHERE no_medrec='$no_medrec'");

if ($sql> 0) {
    echo "
    <script>
    alert('Berhasil Disimpan');
    history. go(-2);
    </script>";
} else {
    echo "Error: ";
}
?>