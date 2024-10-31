<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

$nik = $_GET['nik'];
?>

<main class="content">
    <div class="row" style="padding: 0;">
        <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan Treadmill</h1> <br>
            <form action="pemeriksaan_.php" method="GET">
                <input type="hidden" name="nik" value="<?php echo $nik; ?>">
                <button class="btn btn-danger" type="submit">Kembali</button>
            </form>
        </div>


        <?php
        if ($nik > 0) {
            $nik = $_GET['nik'];
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_treadmil WHERE nik LIKE '%" . $nik . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM data_peserta WHERE nik = '$nik'");

            $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Treadmill'");
            $dkt = mysqli_fetch_array($dokter);

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


                <form action="../proses/inp_trd.php" method="POST">
                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: white;">
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
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: white;">
                            <h4><b>1. Hasil Test</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td>Durasi Test</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="test_menit" value="<?=$row['test_menit']?>">
                                            <span class="input-group-text" id="basic-addon2">Menit</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control w-25" aria-label="Recipient's username" aria-describedby="basic-addon2" name="test_detik" value="<?=$row['test_detik']?>">
                                            <span class="input-group-text" id="basic-addon2">Detik</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Denyut Nadi Maksimal yang Tercapai</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="nadi_max_menit" value="<?=$row['nadi_max_menit']?>">
                                            <span class="input-group-text" id="basic-addon2">x/menit</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control w-25" aria-label="Recipient's username" aria-describedby="basic-addon2" name="nadi_max_persen" value="<?=$row['nadi_max_persen']?>">
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                            <span>(dari perkiraan maksimal)</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Tekanan Darah Maksimal</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="tekanan" value="<?=$row['tekanan']?>">
                                            <span class="input-group-text" id="basic-addon2">mmHg</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Denyut Nadi</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="nadi" value="<?=$row['nadi']?>">
                                            <span class="input-group-text" id="basic-addon2">mmHg</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Alasan Penghentian</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="alasan penghentian" name="alasan" value="<?=$row['alasan']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Kapasitas Maksimal yang Tercapai</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="kapasitas" value="<?=$row['kapasitas']?>">
                                            <span class="input-group-text" id="basic-addon2">METs</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Aritmia Saat Berlari</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="aritmia saat berlari" name="aritmia" value="<?=$row['aritmia']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td>Perubahan ST-T Saat Berlari</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="perubahan ST-T berlari" name="stt" value="<?=$row['pstt']?>">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: white;">
                            <h4><b>2. Ekspertise</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">Respons Miokard Iskemik</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="Respons Miokard Iskemik" name="miokard" value="<?=$row['miokard']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">Respons Tekanan Darah</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="Respon Tekanan Darah" name="kes_tekanan" value="<?=$row['test_menit']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">Kapasitas Kebugaran</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="Kapasitas Kebugaran" name="kebugaran" value="<?=$row['kebugaran']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">Signifikasi Lainnya</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="Signifikasi Lainnya" name="signifikasi" value="<?=$row['signifikasi']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">Kesan</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <input required type="hidden" name="nik" value="<?=$nik?>" id="">
                                            <textarea class="form-control" style="height: 100px;" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="kesan" name="kesan_t"><?=$row['kesan_t']?></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">Saran</td>
                                    <td style="width: 300px;">
                                        <div class="input-group">
                                            <textarea class="form-control" style="height: 100px;" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="saran" name="saran_t"><?=$row['saran_t']?></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Dokter</td>
                                    <td>
                                        <input type="text" readonly name="dokter_a" class="form-control w-75" id="" value="<?php
                                                                                                                            if ($row["dokter_t"] > 0) {
                                                                                                                                echo $row['dokter_t'];
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