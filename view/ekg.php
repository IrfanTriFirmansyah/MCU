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
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan EKG</h1> <br>
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
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_ekg WHERE no_medrec LIKE '%" . $no_medrec . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
            JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta
            WHERE data_peserta.id_peserta = '$id_peserta'");

            $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='EKG'");
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


                <form action="../proses/inp_ekg.php" enctype="multipart/form-data" autocomplete="off" method="POST">
                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>Identitas Peserta</b></h4>
                            <table class="fs-4">
                                <tr style="height: 50px;">
                                    <td style="width: 100px;">NIK</td>
                                    <td style="width: 250px;">
                                        <input type="text" class="border border-0" style="background-color: whitesmoke;" class="fw-bold" value=": <?= $row1['nik'] ?>" readonly>
                                    </td>
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
                                    <td style="width: 100px;">Tanggal Lahir</td>
                                    <td style="width: 250px;"><b>: <?= $pers['tgl_lahir']; ?></b></td>
                                    <td style="width: 100px;">Tanggal Pemeriksaan</td>
                                    <td style="width: 250px;"><b>: <?= $row1['tgl']; ?></b></td>
                                </tr>
                            </table>
                        </div>
                        <!-- <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;"> -->
                        <!-- <h4><b>1. Hasil Test</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Rhythm</td>
                                    <td>
                                        <input type="hidden" name="nik" value="<?= $nik ?>" id="">
                                        <input required type="text" class="form-control w-75" placeholder="Rhythm" name="rhy" id="" value="<?= $row['rhythm'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">P Wave</td>
                                    <td>
                                        <input required type="text" class="form-control w-75" placeholder="P Wave" name="pw" id="" value="<?= $row['pwave'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">PR Interval</td>
                                    <td>
                                        <input required type="text" class="form-control w-75" placeholder="PR Interval" name="pr" id="" value="<?= $row['pr'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">QRS Complex</td>
                                    <td>
                                        <input required type="text" class="form-control w-75" placeholder="QRS Complex" name="qrs" id="" value="<?= $row['qrs'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">ST-T Change</td>
                                    <td>
                                        <input required type="text" class="form-control w-75" placeholder="ST-T Change" name="st" id="" value="<?= $row['stt'] ?>">
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">QTc</td>
                                    <td>
                                        <input required type="text" class="form-control w-75" placeholder="QTc" name="qt" id="" value="<?= $row['qtc'] ?>">
                                    </td>
                                </tr>
                            </table> -->
                        <!-- </div> -->

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>1. Upload scan hasil</b></h4><br>
                            <?php
                            if ($row['foto_ekg'] > 0) { ?>
                                <div class="w-100 d-flex justify-content-center align-items-center p-3">
                                    <img src="../proses/<?= $row['foto_ekg'] ?>" width="950px" height="300px" alt="">
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

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>2. Ekspertise</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Ekspertise</td>
                                    <td>
                                        <input type="hidden" name="no_medrec" value="<?= $row1['no_medrec'] ?>" id="">
                                        <textarea required name="kesan_e" placeholder="Isi ekspertise" class="form-control w-75" style="height: 300px;" id=""><?php if ($row['kesan_e'] > 0) {
                                                                                                                                                                    echo $row['kesan_e'];                                                                                                                                        } else { ?>
SINUS RHYTHM + NORMOAXIS, 
LVH (-), 
ST-T CHANGES (-) <?php } ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Kesan</td>
                                    <td>
                                        <textarea required name="kes_e" placeholder="Isi Kesan" class="form-control w-75" style="height: 100px;" id=""><?php    if( $row['kes_e'] > 0) { echo $row['kes_e']; } else {
?> NORMAL EKG <?php } ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Saran</td>
                                    <td>
                                        <textarea required name="saran_e" placeholder="Isi Saran" class="form-control w-75" style="height: 100px;" id=""><?php    if( $row['saran_e'] > 0) { $row['saran_e']; } else {
?> - <?php } ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Dokter</td>
                                    <td>
                                        <input type="text" readonly name="dokter_e" class="form-control w-75" id="" value="<?php
                                                                                                                            if ($row["dokter_e"] > 0) {
                                                                                                                                echo $row['dokter_e'];
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
                    const noMedrec = '<?php echo $no_medrec; ?>'; // ambil no_medrec dari PHP
                    const formData = new FormData();
                    formData.append('croppedImage', blob);
                    formData.append('no_medrec', noMedrec);

                    $.ajax({
                        url: '../proses/img_ekg.php',
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