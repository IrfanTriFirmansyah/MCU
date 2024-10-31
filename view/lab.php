<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

$id_peserta = $_GET['id_peserta'];
$no_medrec = $_GET['no_medrec'];
?>

<main class="content">
    <div class="row" style="padding: 0;">
        <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan Laboratorium</h1> <br>
            <input type="hidden" name="no_medrec" value="<?php echo $no_medrec; ?>">

            <button onclick="history. go(-1)" class="btn btn-danger" type="submit">Kembali</button>
        </div>


        <?php
        if ($no_medrec > 0) {
            $per = mysqli_query($koneksi, "SELECT * FROM data_peserta 
            JOIN tb_per ON data_peserta.id_per = tb_per.id_per
            JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
            WHERE data_peserta.id_peserta = $id_peserta
            ");
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_lab WHERE no_medrec LIKE '%" . $no_medrec . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
            JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta
            WHERE data_peserta.id_peserta = '$id_peserta'");

            $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Laboratorium'");
            $dkt = mysqli_fetch_array($dokter);

            $pers = mysqli_fetch_array($per);
            $row = mysqli_fetch_array($sql);
            $row1 = mysqli_fetch_array($sql1);


            if ($row > 1) {
                $tanggalLahir = $row1['tgl_lahir'];

                function hitungUmur($tanggalLahir)
                {
                    // Membuat objek DateTime dari tanggal lahir
                    $tanggalLahirObj = new DateTime($tanggalLahir);

                    // Membuat objek DateTime untuk tanggal sekarang
                    $sekarang = new DateTime('today');

                    // Menghitung selisih antara tanggal sekarang dan tanggal lahir
                    $umur = $tanggalLahirObj->diff($sekarang);

                    // Mengembalikan umur dalam tahun
                    return [
                        'tahun' => $umur->y,
                        'bulan' => $umur->m,
                        'hari' => $umur->d
                    ];
                }

        ?>


                <form action="../proses/inp_lab.php" method="POST">
                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: white;">
                            <h4><b>Identitas Peserta</b></h4>
                            <table class="fs-4">
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">NIK</td>
                                    <td style="width: 250px;"><input type="text" class="border border-0" style="background-color: white;" class="fw-bold" value=": <?= $row1['nik'] ?>" readonly></td>
                                    <td style="width: 100px;">Nama</td>
                                    <td style="width: 250px;"><b>: <?= $row1['nama']; ?></b></td>
                                    <td style="width: 100px;">Usia</td>
                                    <td style="width: 250px;"><b>:
                                            <?php
                                            if (isset($tanggalLahir)) {
                                                $umur = hitungUmur($tanggalLahir);
                                                echo "" . $umur['tahun'] . " tahun, " . $umur['bulan'] . " bulan, " . $umur['hari'] . " hari";
                                            }
                                            ?>
                                        </b></td>
                                </tr>
                                <tr style="font-size: 15px;">
                                    <td style="width: 100px;">Perusahaan</td>
                                    <td style="width: 250px;"><b>: <?= $pers['nama_per']; ?></b></td>
                                    <td style="width: 100px;">Paket</td>
                                    <td style="width: 250px;"><b>: <?= $pers['nama_paket']; ?></b></td>
                                    <td style="width: 100px;">Tanggal Pemeriksaan</td>
                                    <td style="width: 250px;"><b>: <?= $row1['tgl']; ?></b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-3 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>1. Hasil Laboratorium</b></h4>
                            <table style="width: 100%;">

                                <tr style="height: 20px;" class="bg-primary">
                                    <td class="border border-secondary text-white p-3">
                                        <b>Pemeriksaan</b>
                                    </td>
                                    <td class="border border-secondary text-white p-3">
                                        <b>Hasil</b>
                                    </td>
                                    <td class="border border-secondary text-white p-3">
                                        <b>Nilai Rujukan</b>
                                    </td>
                                    <td class="border border-secondary text-white p-3">
                                        <b>Satuan</b>
                                    </td>
                                </tr>

                                <?php
                                $mor = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$row1[id_paket]'");
                                while ($rom = mysqli_fetch_array($mor)) {

                                    switch ($rom['tipe_paket']) {
                                        case 'hbsag_crm': ?>

                                            <tr>
                                                <td style="height: 40px;">
                                                    Imunologi/Serologi
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Imunologi/Serologi / hbsAg</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="hbsag" id=""><?= $row['hbsag'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NON REAKTIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>

                                        <?php
                                            break;
                                        case 'darah_lengkap': ?>

                                            <tr style="height: 50px;">
                                                <td>Complete Blood Count</td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>leukosit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="leukosit" id=""><?= $row['leukosit'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>4.0 - 11.0</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>x 103³ µL</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Eosinofil</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="eosinofil" id=""><?= $row['eosinofil'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>0 - 3</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>%</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Basofil</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="basofil" id=""><?= $row['basofil'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>0</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>%</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Batang</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="batang" id=""><?= $row['batang'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>2 - 6</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>%</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Limfosit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="limfosit" id=""><?= $row['limfosit'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>20 - 40</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>%</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Monosit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="monosit" id=""><?= $row['monosit'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>2 - 8</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>%</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Segmen</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="segmen" id=""><?= $row['segmen'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>50 - 70</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>%</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Hemoglobin</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="hemoglobin" id=""><?= $row['hemoglobin'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Laki-laki = 13.0 - 17.0</b><br>
                                                    <b>Perempuan = 12.0 - 16.0</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>g/dL</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Eritrosit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="eritrosit" id=""><?= $row['eritrosit'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Laki-laki= 4,7 - 6,1</b><br>
                                                    <b>Perempuan= 4,0 - 5,5</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>x 10⁶ µL</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Hematokrit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="hematokrit" id=""><?= $row['hematokrit'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Laki-laki = 42 - 54 </b><br>
                                                    <b>Perempuan = 38 - 46</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>%</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>MCV</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="mcv" id=""><?= $row['mcv'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>80 - 100</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>fl</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>MCH</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="mch" id=""><?= $row['mch'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>26 - 34</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>pg</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>MCHC</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="mchc" id=""><?= $row['mchc'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>32 - 36</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>g/dl</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Trombosit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="trombosit" id=""><?= $row['trombosit'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>150 - 450</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>x 10³ µL</b>
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>LED</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="led" id=""><?= $row['led'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>0 - 20</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>mm/jam</b>
                                                </td>
                                            </tr>
                                        <?php break;

                                        case 'urine_lengkap':
                                        ?>
                                            <tr>
                                                <td style="height: 40px;">
                                                    Urine (Makroskopis)
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>WARNA URINE</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="warna" id=""><?= $row['warna'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>KUNING</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>KEJERNIHAN</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="jernih" id=""><?= $row['jernih'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>JERNIH</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>PROTEIN</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="protein" id=""><?= $row['protein'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Reduksi</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="reduksi" id=""><?= $row['reduksi'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>PH</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="ph" id=""><?= $row['ph'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>5 - 8</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>BERAT JENIS</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="berat" id=""><?= $row['berat'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>1.003 - 1.031</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>BILIRUBIN</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="bilirubin" id=""><?= $row['bilirubin'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>UROBILINOGEN</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="urobilinogen" id=""><?= $row['urobilinogen'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NITRIT</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="nitrit" id=""><?= $row['nitrit'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>KETON</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="keton" id=""><?= $row['keton'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>GLUCOSA</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="glucosa" id=""><?= $row['glucosa'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>BLOOD</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="blood" id=""><?= $row['blood'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>NEGATIF</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                            <tr style="height: 50px;">
                                                <td>Urine (Mikroskopis)</td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Leukosit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="leukosit_s" id=""><?= $row['leukosit_s'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Laki-laki = <5 /LPB </b><br>
                                                            <b>Perempuan = <15 /LPB </b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Eritrosit</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="eritrosit_s" id=""><?= $row['eritrosit_s'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>1 - 3 /LPB</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Ephitel</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="ephitel" id=""><?= $row['ephitel'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">

                                                    < 15
                                                        </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Silinder</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="silinder" id=""><?= $row['silinder'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Kristal</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="kristal" id=""><?= $row['kristal'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Bakteri</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="bakteri" id=""><?= $row['bakteri'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <?php break;

                                        case 'test_hcg':
                                            if ($row1['jenis_kelamin'] == 'PEREMPUAN') {
                                            ?>
                                                <tr style="height: 50px;">
                                                    <td>Tes Kehamilan</td>
                                                </tr>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Tes Kehamilan (HCG)</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="hcg" id=""><?= $row['hcg'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Negatif</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                    </td>
                                                </tr>
                                            <?php
                                            } else {
                                            }


                                            break;
                                        case 'fungsi_hati': ?>
                                            <tr style="height: 50px;">
                                                <td>Fungsi Hati</td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>SGOT</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="sgot" id=""><?= $row['sgot'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>
                                                        < 40</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    U/L
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>SGPT</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="sgpt" id=""><?= $row['sgpt'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>
                                                        < 56</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    U/L
                                                </td>
                                            </tr>
                                            <?php
                                            if ($row['gamma_ya'] > 0) {
                                            ?>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>GAMMA GT</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="gamma" id=""><?= $row['gamma'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>0 - 51</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        U/L
                                                    </td>
                                                </tr>
                                            <?php
                                            } else {;
                                            }

                                            break;
                                        case 'test_narkoba':
                                            ?>
                                            <tr style="height: 50px;">
                                                <td>Tes Narkoba</td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Morphine</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="morphine" id=""><?= $row['morphine'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Amphetamine</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="amphetamine" id=""><?= $row['amphetamine'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Metametamin</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="metametamin" id=""><?= $row['metametamin'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>THC</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="thc" id=""><?= $row['thc'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>benzodiazephime</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="benzodiazephime" id=""><?= $row['benzodiazephime'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                </td>
                                            </tr>
                                        <?php
                                            break;
                                        case 'fungsi_ginjal':
                                        ?>
                                            <tr style="height: 50px;">
                                                <td>Fungsi Ginjal</td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Ureum</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="ureum" id=""><?= $row['ureum'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>
                                                        < 40 </b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>mg/dl</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Creatinin</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="creatinin" id=""><?= $row['creatinin'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>0.6 - 1.2</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">
                                                    <b>mg/dl</b>
                                                </td>
                                            </tr>
                                        <?php
                                            break;
                                        case 'kimia_darah':
                                        ?>
                                            <tr style="height: 50px;">
                                                <td>Kimia Darah</td>
                                            </tr>

                                            <?php
                                            if ($row1['status'] == 'cakar') {

                                            ?>

                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Gula Darah Sewaktu</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="gula_darah_sewaktu" id=""><?= $row['gula_darah_sewaktu'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>
                                                            < 180 </b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>

                                                <?php
                                                // if ($row['gdp_ya'] == 'ya') {
                                                ?>

                                                    <tr style="height: 20px;">
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>Gula Darah Puasa</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 350px;">
                                                            <b><textarea required type="text" class="form-control border border-secondary" name="gula_darah_puasa" id=""><?= $row['gula_darah_puasa'] ?></textarea></b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>70-120</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 200px;">
                                                            <b>mg/dl</b>
                                                        </td>
                                                    </tr>


                                                <?php
                                                // }
                                                if ($row['gd2_ya'] == 'ya') {
                                                ?>

                                                    <tr style="height: 20px;">
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>Gula Darah 2 Jam PP</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 350px;">
                                                            <b><textarea required type="text" class="form-control border border-secondary" name="gula_darah_2" id=""><?= $row['gula_darah_2'] ?></textarea></b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>
                                                                < 140 </b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 200px;">
                                                            <b>mg/dl</b>
                                                        </td>
                                                    </tr>

                                                <?php
                                                }
                                                ?>

                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Cholesterol Total</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="kolesterol" id=""><?= $row['kolesterol'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>
                                                            < 200</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>

                                                <?php
                                                if ($row['trigliserida_ya'] == 'ya') {
                                                ?>

                                                    <tr style="height: 20px;">
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>Trigliserd</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 350px;">
                                                            <b><textarea required type="text" class="form-control border border-secondary" name="trigliserid" id=""><?= $row['trigliserid'] ?></textarea></b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>150 - 199</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 200px;">
                                                            <b>mg/dl</b>
                                                        </td>
                                                    </tr>

                                                <?php
                                                }
                                                if ($row['hdl_ya'] == 'ya') {
                                                ?>

                                                    <tr style="height: 20px;">
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>HDL</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 350px;">
                                                            <b><textarea required type="text" class="form-control border border-secondary" name="hdl" id=""><?= $row['hdl'] ?></textarea></b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>> 60</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 200px;">
                                                            <b>mg/dl</b>
                                                        </td>
                                                    </tr>

                                                <?php
                                                }
                                                if ($row['ldl_ya'] == 'ya') {
                                                ?>

                                                    <tr style="height: 20px;">
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>LDL</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 350px;">
                                                            <b><textarea required type="text" class="form-control border border-secondary" name="ldl" id=""><?= $row['ldl'] ?></textarea></b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>
                                                                < 130</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 200px;">
                                                            <b>mg/dl</b>
                                                        </td>
                                                    </tr>

                                                <?php
                                                }

                                                ?>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Asam Urat</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="asam_urat" id=""><?= $row['asam_urat'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Laki-laki = < 7.0</b><br>
                                                                <b>Perempuan = < 6.9</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>

                                            <?php
                                            } else { ?>

                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Gula Darah Sewaktu</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea type="text" class="form-control border border-secondary" name="gula_darah_sewaktu" id=""><?= $row['gula_darah_sewaktu'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>
                                                            < 180 </b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>


                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Gula Darah Puasa</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea type="text" class="form-control border border-secondary" name="gula_darah_puasa" id=""><?= $row['gula_darah_puasa'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>70-120</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>

                                                <?php
                                                if ($row['gd2_ya'] == 'ya') {
                                                ?>
                                                    <tr style="height: 20px;">
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>Gula Darah 2 Jam PP</b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 350px;">
                                                            <b><textarea required type="text" class="form-control border border-secondary" name="gula_darah_2" id=""><?= $row['gula_darah_2'] ?></textarea></b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 300px;">
                                                            <b>
                                                                < 140 </b>
                                                        </td>
                                                        <td class="border border-secondary p-3" style="width: 200px;">
                                                            <b>mg/dl</b>
                                                        </td>
                                                    </tr>
                                                <?php
                                                } ?>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Cholesterol Total</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="kolesterol" id=""><?= $row['kolesterol'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>
                                                            < 200</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Trigliserd</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="trigliserid" id=""><?= $row['trigliserid'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>150 - 199</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>HDL</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="hdl" id=""><?= $row['hdl'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>> 60</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>LDL</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="ldl" id=""><?= $row['ldl'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>
                                                            < 130</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>
                                                <tr style="height: 20px;">
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Asam Urat</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 350px;">
                                                        <b><textarea required type="text" class="form-control border border-secondary" name="asam_urat" id=""><?= $row['asam_urat'] ?></textarea></b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 300px;">
                                                        <b>Laki-laki = < 7.0</b><br>
                                                                <b>Perempuan = < 6.9</b>
                                                    </td>
                                                    <td class="border border-secondary p-3" style="width: 200px;">
                                                        <b>mg/dl</b>
                                                    </td>
                                                </tr>
                                            <?php
                                            }


                                            break;
                                        case 'test_hiv':
                                            ?>
                                            <tr style="height: 50px;">
                                                <td>Test HIV</td>
                                            </tr>
                                            <tr style="height: 20px;">
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>HIV</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 350px;">
                                                    <b><textarea required type="text" class="form-control border border-secondary" name="hiv" id=""><?= $row['hiv'] ?></textarea></b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 300px;">
                                                    <b>Negatif</b>
                                                </td>
                                                <td class="border border-secondary p-3" style="width: 200px;">

                                                </td>
                                            </tr>
                                <?php
                                            break;
                                    }
                                }
                                ?>

                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-3 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>2. Ekspertise</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Kesan</td>
                                    <td>
                                        <input type="hidden" name="no_medrec" value="<?= $no_medrec ?>" id="">
                                        <textarea required name="kesan_lab" placeholder="Kesan" class="form-control w-75" style="height: 100px;" id=""><?= $row['kesan_lab'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">saran</td>
                                    <td>
                                        <textarea required name="saran_lab" placeholder="saran" class="form-control w-75" style="height: 100px;" id=""><?= $row['saran_lab'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Pemeriksa</td>
                                    <td>
                                        <input type="text" readonly name="dokter_lab" class="form-control w-75" id="" value="<?php
                                                                                                                                if ($row["dokter_lab"] > 0) {
                                                                                                                                    echo $row['dokter_lab'];
                                                                                                                                } else {
                                                                                                                                    echo $dkt['nama'];
                                                                                                                                }
                                                                                                                                ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 btn w-100 btn-primary fs-4" onclick="return confirm('Selesaikan Pemeriksaan?')">Simpan Pemeriksaan</button>
                </form>


        <?php
            }
        }
        ?>

    </div>
</main>


<?php
include '../main/footer.php';
?>