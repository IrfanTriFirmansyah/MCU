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
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan Spirometri</h1> <br>
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
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_spirometri WHERE no_medrec LIKE '%" . $no_medrec . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
            JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta
            WHERE data_peserta.id_peserta = '$id_peserta'");

            $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Spirometri'");
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


                <form action="../proses/inp_spi.php" enctype="multipart/form-data" autocomplete="off" method="POST">
                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>Identitas Peserta</b></h4>
                            <table class="fs-4">
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">NIK</td>
                                    <td style="width: 250px;"><input type="text" class="border border-0" style="background-color: whitesmoke;" class="fw-bold" value=": <?= $row1['nik'] ?>" readonly></td>
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

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>1. Upload scan hasil</b></h4><br>
                            <input type="file" class="form-control" accept=".jpg, .jpeg, .png" name="image" id="imageInput">
                            <?php
                            if ($row['foto_sp'] > 0) { ?>
                                <div class="w-100 d-flex justify-content-center align-items-center p-3">
                                    <img src="../proses/sp/<?= $row['foto_sp'] ?>" width="550px" height="400px" alt="">
                                </div>
                            <?php
                            } else { ?>
                                <!-- <div class="w-100 d-flex justify-content-center align-items-center p-3" id="imagePreviewContainer" style="display: none;">
                                    <img id="imagePreview" width="550px" height="400px" alt="">
                                </div> -->
                            <?php
                            }
                            ?>
                        </div>

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-3 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>2. Hasil Test</b></h4>
                            <table style="width: 100%;" class="mt-3">
                                <tr style="height: 20px; background-color: #d3d3d3;">
                                    <td class="border border-secondary p-3">
                                        <b>Pemeriksaan</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Nilai</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Prediksi</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>%</b>
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        BEST FVC (L)
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" class="form-control w-100" name="nilai_fvc" id="" value="<?= $row['nilai_fvc'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="pred_fvc" class="form-control" id="" value="<?= $row['pred_fvc'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="persen_fvc" class="form-control" id="" value="<?= $row['persen_fvc'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        BEST FEV 1 (L)
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" class="form-control w-100" name="nilai_fev" id="" value="<?= $row['nilai_fev'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="pred_fev" class="form-control" id="" value="<?= $row['pred_fev'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="persen_fev" class="form-control" id="" value="<?= $row['persen_fev'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        FEV 1 / FCV (%)
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" class="form-control w-100" name="nilai_fcv" id="" value="<?= $row['nilai_fcv'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="pred_fcv" class="form-control" id="" value="<?= $row['pred_fcv'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="persen_fcv" class="form-control" id="" value="<?= $row['persen_fcv'] ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>


                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>3. Ekspertise</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Kesan</td>
                                    <td>
                                        <input type="hidden" name="no_medrec" value="<?= $no_medrec ?>" id="">
                                        <textarea name="kesan_s" placeholder="Kesan" class="form-control w-75" style="height: 100px;" id=""><?php if( $row['kesan_s'] > 0){ echo $row['kesan_s']; } else{ ?>FUNGSI PARU <?php } ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Saran</td>
                                    <td>
                                        <textarea name="saran_s" placeholder="saran" class="form-control w-75" style="height: 100px;" id=""><?= $row['saran_s'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Dokter</td>
                                    <td>
                                        <input type="text" readonly name="dokter_s" class="form-control w-75" id="" value="<?php
                                                                                                                            if ($row["dokter_s"] > 0) {
                                                                                                                                echo $row['dokter_s'];
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

<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById('imagePreviewContainer');
                const previewImage = document.getElementById('imagePreview');
                previewImage.src = e.target.result;
                previewContainer.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<?php
include '../main/footer.php';
?>