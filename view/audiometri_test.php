<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

$id_peserta = $_GET['id_peserta'];
$no_medrec = $_GET['no_medrec'];
?>

<style>
    img {
        max-width: 100%;
    }

    .cropper-container {
        margin-top: 20px;
    }
</style>
<main class="content">
    <div class="row" style="padding: 0;">
        <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan Audiometri</h1> <br>
            <form action="pemeriksaan.php" method="GET">
                <input type="hidden" name="no_medrec" value="<?php echo $no_medrec; ?>">
                <button class="btn btn-danger" type="submit">Kembali</button>
            </form>
        </div>

        <?php
        if ($no_medrec > 0) {
            $per = mysqli_query($koneksi, "SELECT * FROM data_peserta 
            JOIN tb_per ON data_peserta.id_per = tb_per.id_per
            JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
            WHERE data_peserta.id_peserta = $id_peserta
            ");
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_audiometri WHERE no_medrec LIKE '%" . $no_medrec . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
            JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta
            WHERE data_peserta.id_peserta = '$id_peserta'");

            $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Audiometri'");
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

                <form action="../proses/inp_aud.php" enctype="multipart/form-data" autocomplete="off" method="POST">
                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>Identitas Peserta</b></h4>
                            <table class="fs-4">
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">NIK</td>
                                    <td style="width: 250px;"><input type="text" class="border border-0" style="background-color: whitesmoke;" class="fw-bold" name="nik" value=": <?= $row1['nik'] ?>" readonly></td>
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
                            <?php
                            if ($row['foto_aud'] > 0) { ?>
                                <div class="w-100 d-flex justify-content-center align-items-center p-3">
                                    <img src="../proses/<?= $row['foto_aud'] ?>" width="800px" height="300px" alt="">
                                </div>
                            <?php
                            } else { ?>
                                <div id="uploadContainer">
                                    <input type="file" id="inputImage" accept="image/*" class="form-control">
                                </div>
                                <img id="image" style="display:none;">
                                <button id="cropButton" style="display:none;" class="btn btn-primary mt-2">Crop and Upload</button>
                            <?php
                            } ?>
                        </div>

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-3 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>2. Hasil Test</b></h4>
                            <table style="width: 100%;" class="mt-3">
                                <tr style="height: 80px;">
                                    <td>
                                        AIR CONDUCTION (AC) / Hantaran Udara
                                    </td>
                                </tr>
                                <tr style="height: 20px; background-color: #d3d3d3;">
                                    <td class="border border-secondary p-3">
                                        <b>Frekuensi</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Kanan</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Kiri</b>
                                    </td>
                                </tr>
                                <!-- Repeat the rows for each frequency -->
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        250
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" class="form-control w-100" placeholder="kanan" name="250_kanan" id="" value="<?= $row['250_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="250_kiri" class="form-control" placeholder="kiri" id="" value="<?= $row['250_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        500
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="500_kanan" class="form-control" placeholder="kanan" id="" value="<?= $row['500_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="500_kiri" class="form-control" placeholder="kiri" id="" value="<?= $row['500_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        1000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="1000_kanan" class="form-control" placeholder="kanan" id="" value="<?= $row['1000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="1000_kiri" class="form-control" placeholder="kiri" id="" value="<?= $row['1000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        2000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="2000_kanan" class="form-control" placeholder="kanan" id="" value="<?= $row['2000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="2000_kiri" class="form-control" placeholder="kiri" id="" value="<?= $row['2000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        4000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="4000_kanan" class="form-control" placeholder="kanan" id="" value="<?= $row['4000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="4000_kiri" class="form-control" placeholder="kiri" id="" value="<?= $row['4000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        6000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="6000_kanan" class="form-control" placeholder="kanan" id="" value="<?= $row['6000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="6000_kiri" class="form-control" placeholder="kiri" id="" value="<?= $row['6000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        8000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="8000_kanan" class="form-control" placeholder="kanan" id="" value="<?= $row['8000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="8000_kiri" class="form-control" placeholder="kiri" id="" value="<?= $row['8000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 80px;">
                                    <td>
                                        BONE CONDUCTION (BC) / Hantaran Tulang
                                    </td>
                                </tr>
                                <tr style="height: 20px; background-color: #d3d3d3;">
                                    <td class="border border-secondary p-3">
                                        <b>Frekuensi</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Kanan</b>
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <b>Kiri</b>
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        250
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" class="form-control w-100" placeholder="kanan" name="bon_250_kn" id="" value="<?= $row['bon_250_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_250_kr" class="form-control" placeholder="kiri" id="" value="<?= $row['bon_250_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        500
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_500_kn" class="form-control" placeholder="kanan" id="" value="<?= $row['bon_500_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_500_kr" class="form-control" placeholder="kiri" id="" value="<?= $row['bon_500_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        1000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_1000_kn" class="form-control" placeholder="kanan" id="" value="<?= $row['bon_1000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_1000_kr" class="form-control" placeholder="kiri" id="" value="<?= $row['bon_1000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        2000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_2000_kn" class="form-control" placeholder="kanan" id="" value="<?= $row['bon_2000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_2000_kr" class="form-control" placeholder="kiri" id="" value="<?= $row['bon_2000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        4000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_4000_kn" class="form-control" placeholder="kanan" id="" value="<?= $row['bon_4000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_4000_kr" class="form-control" placeholder="kiri" id="" value="<?= $row['bon_4000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        6000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_6000_kn" class="form-control" placeholder="kanan" id="" value="<?= $row['bon_6000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_6000_kr" class="form-control" placeholder="kiri" id="" value="<?= $row['bon_6000_kiri'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td class="border border-secondary p-3">
                                        8000
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_8000_kn" class="form-control" placeholder="kanan" id="" value="<?= $row['bon_8000_kanan'] ?>">
                                    </td>
                                    <td class="border border-secondary p-3">
                                        <input type="text" name="bon_8000_kr" class="form-control" placeholder="kiri" id="" value="<?= $row['bon_8000_kiri'] ?>">
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
                                        <input required type="hidden" name="no_medrec" value="<?= $no_medrec ?>" id="">
                                        <textarea name="kesan_a" placeholder="Kesan" class="form-control w-75" style="height: 100px;" id=""><?= $row['kesan_a'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Saran</td>
                                    <td>
                                        <textarea name="saran_a" placeholder="saran" class="form-control w-75" style="height: 100px;" id=""><?= $row['saran_a'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Dokter</td>
                                    <td>
                                        <input type="text" readonly name="dokter_a" class="form-control w-75" id="" 
                                        value="<?php
                                        if ($row["dokter_a"] > 0) {
                                            echo $row['dokter_a'];
                                        } else{
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

<div class="modal fade" id="cropperModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="imageCropper" src="" alt="Image for cropping">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCrop">Save Crop</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    $(document).ready(function() {
        let cropper;
        let image = document.getElementById('imageCropper');

        $("#inputImage").on("change", function(e) {
            let files = e.target.files;
            let done = function(url) {
                image.src = url;
                $("#cropperModal").modal('show');
            };
            let reader;
            let file;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $("#cropperModal").on("shown.bs.modal", function() {
            cropper = new Cropper(image, {
                aspectRatio: NaN, // Set aspect ratio to free
                viewMode: 1,
                autoCropArea: 1,
            });
        }).on("hidden.bs.modal", function() {
            cropper.destroy();
            cropper = null;
        });

        $("#saveCrop").click(function() {
            let canvas;
            if (cropper) {
                canvas = cropper.getCroppedCanvas();
                canvas.toBlob(function(blob) {
                    let formData = new FormData();
                    formData.append('croppedImage', blob);

                    $.ajax({
                        url: '../proses/up_img.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log('Upload success');
                            $("#cropperModal").modal('hide');
                            alert('Image has been cropped and uploaded');
                            // Gantikan input file dengan gambar hasil crop
                            var uploadedImageUrl = URL.createObjectURL(blob);
                            $("#uploadContainer").html('<img src="' + uploadedImageUrl + '" class="img-fluid">');
                        },
                        error: function() {
                            console.log('Upload error');
                        }
                    });
                });
            }
        });
    });
</script>

<?php
include '../main/footer.php';
?>