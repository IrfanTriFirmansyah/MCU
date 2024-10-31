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
            <h1 style="font-size: 40px; font-weight: bold;">Resume Akhir Pemeriksaan</h1> <br>
            <input type="hidden" name="no_medrec" value="<?php echo $no_medrec; ?>">
            <button onclick="history. go(-1)" class="btn btn-danger" type="submit">Kembali</button>
        </div>


        <?php
        if ($no_medrec > 0) {
            //         $per = mysqli_query($koneksi, "SELECT * FROM data_peserta 
            // JOIN tb_per ON data_peserta.id_per = tb_per.id_per
            // JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
            //         WHERE data_peserta.id_peserta = $id_peserta
            // ");
            // $sql = mysqli_query($koneksi, "SELECT * FROM tb_ WHERE no_medrec LIKE '%" . $no_medrec . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
    JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta
    WHERE rekam_mcu.no_medrec = '$no_medrec'");


            // $pers = mysqli_fetch_array($per);
            $row1 = mysqli_fetch_array($sql1);

            if ($row1 > 1) {
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


                <form action="../proses/inp_resume.php" method="POST">
                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>Identitas Peserta</b></h4>
                            <table class="fs-4">
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">NIK</td>
                                    <td style="width: 250px;"><b>: <?= $row1['nik']; ?></b></td>
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
                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>Kesimpulan</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Dokter Penanggung Jawab</td>
                                    <td>
                                        <input type="hidden" name="no_medrec" value="<?= $no_medrec ?>" id="">

                                        <?php
                                        $bro = mysqli_query($koneksi, "SELECT * FROM tb_dokter WHERE aktif='2'");
                                        $bre = mysqli_fetch_array($bro) ?>

                                        <input name="dokter" readonly type="text" class="form-control" value="<?= $bre['nama'] ?>" id="">

                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Keterangan</td>
                                    <td>
                                        <input required class="form-check-input" type="radio" name="ket" value="Fit To Work" <?php if ($row1['ket'] == 'Fit To Work') echo "checked"; ?> id="flexRadioDefault1">
                                        <label class="form-check-label text-success fw-bold" for="flexRadioDefault1">
                                            Fit To Work
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="ket" value="Fit With Note" <?php if ($row1['ket'] == 'Fit With Note') echo "checked"; ?> id="flexRadioDefault2">
                                        <label class="form-check-label text-primary fw-bold" for="flexRadioDefault2">
                                            Fit With Note
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="ket" value="Temporary Unfit" <?php if ($row1['ket'] == 'Temporary Unfit') echo "checked"; ?> id="flexRadioDefault3">
                                        <label class="form-check-label text-warning fw-bold" for="flexRadioDefault3">
                                            Temporary Unfit
                                        </label>
                                        <input required class="form-check-input ms-6" type="radio" name="ket" value="Not Fit To Work" <?php if ($row1['ket'] == 'Not Fit To Work') echo "checked"; ?> id="flexRadioDefault4">
                                        <label class="form-check-label text-danger fw-bold" for="flexRadioDefault4">
                                            Not Fit To Work
                                        </label>
                                        <!-- <input required class="form-check-input ms-6" type="radio" name="ket" value="Unfit" <?php if ($row1['ket'] == 'Unfit') echo "checked"; ?> id="flexRadioDefault4">
                                        <label class="form-check-label text-danger fw-bold" for="flexRadioDefault4">
                                            Unfit
                                        </label> -->
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Kesimpulan</td>
                                    <td>
                                        <!-- <input type="hidden" name="nama" value="<?= $row1['nama'] ?>" id=""> -->
                                        <textarea required name="kesimpulan" placeholder="Isi Kesimpulan" class="form-control w-100 " style="height: 100px;" id=""><?= $row1['kesimpulan'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Saran</td>
                                    <td>
                                        <textarea required name="Saran" placeholder="Isi Saran" class="form-control w-100   " style="height: 100px;" id=""><?= $row1['saran'] ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 btn w-100 btn-primary fs-4" onclick="return confirm('Apakah Data Sudah Benar?')">Selesaikan Pemeriksaan & Print Resume</button>
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