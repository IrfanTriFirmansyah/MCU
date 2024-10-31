<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

$id_peserta = $_GET['id_peserta'];
$no_medrec = $_GET['no_medrec'];
?>


<script>
    function hitungBMI() {
        const tinggi = parseFloat(document.getElementById("tinggi").value);
        const berat = parseFloat(document.getElementById("berat").value);

        if (tinggi > 0 && berat > 0) {
            const tinggiMeter = tinggi / 100;
            const bmi = berat / (tinggiMeter * tinggiMeter);
            let status = "";

            if (bmi < 18.5) {
                status = "Underweight";
            } else if (bmi >= 18.5 && bmi < 25.0) {
                status = "Ideal";
            } else if (bmi >= 25.1 && bmi < 29.9) {
                status = "Overweight";
            } else {
                status = "Obesitas";
            }

            document.getElementById("stat").value = status;
            document.getElementById("imt").value = bmi.toFixed(2);
        }
    }
</script>

<main class="content">
    <div class="row" style="padding: 0;">
        <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan Fisik</h1>
            <input type="hidden" name="no_medrec" value="<?php echo $no_medrec; ?>">

            <button onclick="history. go(-1)" class="btn btn-danger" type="submit">Kembali</button>
        </div><br>

        <?php

        if ($no_medrec > 0) {
            $per = mysqli_query($koneksi, "SELECT * FROM data_peserta 
            JOIN tb_per ON data_peserta.id_per = tb_per.id_per
            JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
            WHERE data_peserta.id_peserta = $id_peserta
            ");
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_umum WHERE no_medrec LIKE '%" . $no_medrec . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
            JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta
            WHERE data_peserta.id_peserta = '$id_peserta'");

            $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Pemeriksaan Fisik'");
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


                <form action="../proses/inp_umum.php" method="POST">
                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>Identitas Peserta</b></h4>
                            <table class="fs-4">
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">NIK</td>
                                    <td style="width: 250px;"><input type="text" class="border border-0" style="background-color: whitesmoke;" class="fw-bold" value=": <?= $row1['nik']; ?>" readonly></td>
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
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>1. Anamnesa</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Keluhan</td>
                                    <td style="width: 250px;">
                                        <input required class="form-check-input" type="radio" name="keluhan" id="yak" value="ya" <?php if ($row['keluhan'] == 'ya') echo "checked"; ?>>
                                        <label class="form-check-label" for="yak">
                                            Ya
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="keluhan" id="tidakk" value="tidak" <?php if ($row['keluhan'] == 'tidak') echo "checked"; ?>>
                                        <label class="form-check-label" for="tidakk">
                                            Tidak
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_keluhan" value="<?= $row['inp_keluhan'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Merokok</td>
                                    <td>
                                        <input required class="form-check-input" type="radio" name="merokok" value="ya" <?php if ($row['merokok'] == 'ya') echo "checked" ?> id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Ya
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="merokok" value="tidak" <?php if ($row['merokok'] == 'tidak') echo "checked" ?> id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Tidak
                                        </label>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Alkohol</td>
                                    <td>
                                        <div>
                                            <input required class="form-check-input" type="radio" name="alkohol" id="alkohol" value="ya" <?php if ($row['alkohol'] == 'ya') echo "checked"; ?>>
                                            <label class="form-check-label" for="alkohol">
                                                Ya
                                            </label>
                                            <input required class="form-check-input ms-6" type="radio" name="alkohol" id="alkohol2" value="tidak" <?php if ($row['alkohol'] == 'tidak') echo "checked"; ?>>
                                            <label class="form-check-label" for="alkohol2">
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Asma</td>
                                    <td>
                                        <div>
                                            <input required class="form-check-input" type="radio" name="asma" id="asma" value="ya" <?php if ($row['asma'] == 'ya') echo "checked"; ?>>
                                            <label class="form-check-label" for="asma">
                                                Ya
                                            </label>
                                            <input required class="form-check-input ms-6" type="radio" name="asma" id="asma2" value="tidak" <?php if ($row['asma'] == 'tidak') echo "checked"; ?>>
                                            <label class="form-check-label" for="asma2">
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">TBC</td>
                                    <td>
                                        <div>
                                            <input required class="form-check-input" type="radio" name="tbc" id="tbc" value="ya" <?php if ($row['tbc'] == 'ya') echo "checked"; ?>>
                                            <label class="form-check-label" for="tbc">
                                                Ya
                                            </label>
                                            <input required class="form-check-input ms-6" type="radio" name="tbc" id="tbc2" value="tidak" <?php if ($row['tbc'] == 'tidak') echo "checked"; ?>>
                                            <label class="form-check-label" for="tbc2">
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Operasi</td>
                                    <td>
                                        <div>
                                            <input required class="form-check-input" type="radio" name="operasi" id="operasi" value="ya" <?php if ($row['operasi'] == 'ya') echo "checked"; ?>>
                                            <label class="form-check-label" for="operasi">
                                                Ya
                                            </label>
                                            <input required class="form-check-input ms-6" type="radio" name="operasi" id="operasi2" value="tidak" <?php if ($row['operasi'] == 'tidak') echo "checked"; ?>>
                                            <label class="form-check-label" for="operasi2">
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" name="inp_operasi" value="<?= $row['inp_operasi'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Alergi</td>
                                    <td>
                                        <div>
                                            <input required class="form-check-input" type="radio" name="alergi" id="alergi" value="ya" <?php if ($row['alergi'] == 'ya') echo "checked"; ?>>
                                            <label class="form-check-label" for="alergi">
                                                Ya
                                            </label>
                                            <input required class="form-check-input ms-6" type="radio" name="alergi" id="alergi2" value="tidak" <?php if ($row['alergi'] == 'tidak') echo "checked"; ?>>
                                            <label class="form-check-label" for="alergi2">
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" name="inp_alergi" value="<?= $row['inp_alergi'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Olahraga</td>
                                    <td> <input required class="form-check-input" type="radio" name="olahraga" id="olgya" value="ya" <?php if ($row['olahraga'] == 'ya') echo "checked"; ?>>
                                        <label class="form-check-label" for="olgya">
                                            Ya
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="olahraga" id="olgga" value="tidak" <?php if ($row['olahraga'] == 'tidak') echo "checked"; ?>>
                                        <label class="form-check-label" for="olgga">
                                            Tidak
                                        </label>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Riwayat Penyakit</td>
                                    <td colspan="2">
                                        <textarea class="form-control w-100" style="height: 100px;" name="rwt_penyakit" id="" required><?php if($row["rwt_penyakit"] > 0) { echo $row['rwt_penyakit'];} else { echo 'Tidak Ada'; } ?> </textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Riwayat Penyakit Keluarga</td>
                                    <td colspan="2">
                                        <textarea class="form-control w-100" style="height: 100px;" name="rwt_penyakit_kel" id="" required><?php if($row["rwt_penyakit_kel"] > 0) { echo $row['rwt_penyakit_kel'];} else { echo 'Tidak Ada'; } ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>2. Tanda-tanda Vital</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td>Tekanan Darah</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="tekanan" value="<?= $row['tekanan'] ?>">
                                            <span class="input-group-text" id="basic-addon2">mm/Hg</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">Tinggi Badan</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" id="tinggi" name="tb" oninput="hitungBMI()" value="<?= $row['tb'] ?>">
                                            <span class="input-group-text" id="basic-addon2">cm</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Detak Nadi</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="detak" value="<?= $row['detak'] ?>">
                                            <span class="input-group-text" id="basic-addon2">/menit</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">Berat Badan</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" id="berat" name="bb" oninput="hitungBMI()" value="<?= $row['bb'] ?>">
                                            <span class="input-group-text" id="basic-addon2">kg</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Nafas</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="nafas" value="<?php if($row["nafas"] > 0) { echo $row['nafas'];} else { echo '20'; } ?>">
                                            <span class="input-group-text" id="basic-addon2">/menit</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">IMT</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" id="imt" name="imt" readonly value="<?= $row['imt'] ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>suhu</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="suhu" value="<?php if($row["suhu"] > 0) { echo $row['suhu'];} else { echo '36,5'; } ?>">
                                            <span class="input-group-text" id="basic-addon2">&deg;C</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">Status</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input type="text" readonly class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="stat" id="stat" value="<?= $row['stat'] ?>">
                                            <!-- <span class="input-group-text" id="basic-addon2">&deg;C</span> -->
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>3. Pemeriksaan Fisik</b></h4>
                            <table class="w-100 mt-3">
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Kepala</td>
                                    <td style="width: 250px;">
                                        <input  required class="form-check-input" type="radio" name="kepala" id="normal0" value="normal" <?php if ($row['kepala'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal0">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="kepala" id="kelainan0" value="kelainan" <?php if ($row['kepala'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan0">
                                            Kelainan
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_kepala" value="<?= $row['inp_kepala'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Leher</td>
                                    <td style="width: 250px;">
                                        <input  required class="form-check-input" type="radio" name="leher" id="normal-1" value="normal" <?php if ($row['leher'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal-1">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="leher" id="kelainan-1" value="kelainan" <?php if ($row['leher'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan-1">
                                            Kelainan
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_leher" value="<?= $row['inp_leher'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">THT</td>
                                    <td style="width: 250px;">
                                        <input  required class="form-check-input" type="radio" name="tht" id="normal" value="normal" <?php if ($row['tht'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="tht" id="kelainan" value="kelainan" <?php if ($row['tht'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan">
                                            Kelainan
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_tht" value="<?= $row['inp_leher'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Dada</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="dada" id="normal1" value="normal" <?php if ($row['dada'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal1">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="dada" id="kelainan1" value="kelainan" <?php if ($row['dada'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan1">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_dada" value="<?= $row['inp_dada'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Jantung</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="jantung" id="normal2" value="normal" <?php if ($row['jantung'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal2">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="jantung" id="kelainan2" value="kelainan" <?php if ($row['jantung'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan2">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_jantung" value="<?= $row['inp_jantung'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Paru</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="paru" id="normal3" value="normal" <?php if ($row['paru'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal3">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="paru" id="kelainan3" value="kelainan" <?php if ($row['paru'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan3">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_paru" value="<?= $row['inp_paru'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Abdomen</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="perut" id="normal4" value="normal" <?php if ($row['perut'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal4">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="perut" id="kelainan4" value="kelainan" <?php if ($row['perut'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan4">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_perut" value="<?= $row['inp_perut'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Saluran Kemih</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="kemih" id="normal5" value="normal" <?php if ($row['kemih'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal5">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="kemih" id="kelainan5" value="kelainan" <?php if ($row['kemih'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan5">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_kemih" value="<?= $row['inp_kemih'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Tulang Belakang</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="sendi" id="normal6" value="normal" <?php if ($row['sendi'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal6">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="sendi" id="kelainan6" value="kelainan" <?php if ($row['sendi'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan6">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_sendi" value="<?= $row['inp_sendi'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Syaraf</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="syaraf" id="normal7" value="normal" <?php if ($row['syaraf'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal7">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="syaraf" id="kelainan7" value="kelainan" <?php if ($row['syaraf'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan7">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_syaraf" value="<?= $row['inp_syaraf'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Anggota Gerak</td>
                                    <td style="width: 250px">
                                        <input  required class="form-check-input" type="radio" name="gerak" id="normal8" value="normal" <?php if ($row['gerak'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal8">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="gerak" id="kelainan8" value="kelainan" <?php if ($row['gerak'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan8">
                                            Kelainan &nbsp;
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_gerak" value="<?= $row['inp_gerak'] ?>">
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>4. Pemeriksaan Mata</b></h4>
                            <table style="width: 100%;">

                                <tr style="height: 60px; background-color: #d3d3d3;">
                                    <td class="border border-secondary p-3" colspan="3">
                                        <b>Visus Mata</b>
                                    </td>
                                </tr>
                                <tr style="height: 60px;">
                                    <td class="border border-secondary p-3">
                                        VOD
                                    </td>
                                    <td class="border border-secondary p-3" colspan="2">
                                        <input required type="text" class="form-control w-100" name="vod" id="" value="<?= $row['vod'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 60px;">
                                    <td class="border border-secondary p-3">
                                        VOS
                                    </td>
                                    <td class="border border-secondary p-3" colspan="2">
                                        <input required type="text" class="form-control w-100" name="vos" id="" value="<?= $row['vos'] ?>">
                                    </td>
                                </tr>

                                <tr style="height: 50px;">
                                    <td style="width: 300px;">Buta Warna</td>
                                    <td style="width: 250px">
                                        <input required class="form-check-input" type="radio" name="buta" id="normal9" value="Normal" <?php if ($row['buta'] == 'Normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal9">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="buta" id="kelainan9" value="Parsial" <?php if ($row['buta'] == 'Parsial') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan9">
                                            Parsial
                                        </label>
                                    </td>
                                    <td>
                                        <input required class="form-check-input ms-6" type="radio" name="buta" id="parsial9" value="Total" <?php if ($row['buta'] == 'Total') echo "checked"; ?>>
                                        <label class="form-check-label" for="parsial9">
                                            Total
                                        </label>
                                    </td>
                                </tr>

                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Note</td>
                                    <td colspan="2">
                                        <textarea name="note_mata" placeholder="note" class="form-control w-75" style="height: 100px;" id=""><?= $row['note_mata'] ?></textarea>
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>5. Pemeriksaan Gigi & Mulut</b></h4> <br>
                            <table class="mb-3" style="width: 100%;">
                                <tr style="height: 60px; background-color: #d3d3d3; text-align: center;">
                                    <td class="border border-secondary p-3">
                                        <b>Bagian</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Hasil Pemeriksaan</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Keterangan</b>
                                    </td>
                                </tr>
                                <tr style="height: 60px;">
                                    <td class="border border-secondary p-3">
                                        Bibir
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input  required class="form-check-input" type="radio" name="bibir" id="normal11" value="normal" <?php if ($row['bibir'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal11">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="bibir" id="kelainan11" value="kelainan" <?php if ($row['bibir'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan11">
                                            Tidak Normal &nbsp;
                                        </label>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="inp_bibir" class="form-control" placeholder="Keterangan" id="" value="<?= $row['inp_bibir'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 60px;">
                                    <td class="border border-secondary p-3">
                                        Gigi
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input  required class="form-check-input" type="radio" name="gigi" id="normal12" value="normal" <?php if ($row['gigi'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal12">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="gigi" id="kelainan12" value="kelainan" <?php if ($row['gigi'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan12">
                                            Tidak Normal &nbsp;
                                        </label>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="inp_gigi" class="form-control" placeholder="Keterangan" id="" value="<?= $row['inp_gigi'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 60px;">
                                    <td class="border border-secondary p-3">
                                        Gusi
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input  required class="form-check-input" type="radio" name="gusi" id="normal13" value="normal" <?php if ($row['gusi'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal13">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="gusi" id="kelainan13" value="kelainan" <?php if ($row['gusi'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan13">
                                            Tidak Normal &nbsp;
                                        </label>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="inp_gusi" class="form-control" placeholder="Keterangan" id="" value="<?= $row['inp_gusi'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 60px;">
                                    <td class="border border-secondary p-3">
                                        Mukosa
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input  required class="form-check-input" type="radio" name="mukosa" id="normal14" value="normal" <?php if ($row['mukosa'] == 'normal') echo "checked"; ?>>
                                        <label class="form-check-label" for="normal14">
                                            Normal
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="mukosa" id="kelainan14" value="kelainan" <?php if ($row['mukosa'] == 'kelainan') echo "checked"; ?>>
                                        <label class="form-check-label" for="kelainan14">
                                            Tidak Normal &nbsp;
                                        </label>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="inp_mukosa" class="form-control" placeholder="Keterangan" id="" value="<?= $row['inp_mukosa'] ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>6. Ekspertise</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Kesan</td>
                                    <td>
                                        <input type="hidden" name="no_medrec" value="<?= $row['no_medrec'] ?>" id="">
                                        <textarea name="kesan_u" placeholder="Kesan" class="form-control w-75" style="height: 100px;" id=""><?php
                                                                                                                            if ($row["kesan_u"] > 0) {
                                                                                                                                echo $row['kesan_u'];
                                                                                                                            } else {
                                                                                                                                echo 'Pemeriksaan Dalam Batas Normal';
                                                                                                                            }
                                                                                                                            ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Saran</td>
                                    <td>
                                        <textarea name="saran_u" placeholder="saran" class="form-control w-75" style="height: 100px;" id=""><?= $row['saran_u'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Dokter</td>
                                    <td>
                                        <input type="text" readonly name="dokter_u" class="form-control w-75" id="" value="<?php
                                                                                                                            if ($row["dokter_u"] > 0) {
                                                                                                                                echo $row['dokter_u'];
                                                                                                                            } else {
                                                                                                                                echo $_SESSION['nama'];
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
            } else {
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { swal("Data Tidak Ditemukan","","error");';
                echo '}, 100);</script>';
            }
        }
        ?>

    </div>
</main>



<?php
include '../main/footer.php';
?>