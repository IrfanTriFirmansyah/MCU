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
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan Radiologi</h1> <br>
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
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_radiologi WHERE no_medrec LIKE '%" . $no_medrec . "%'");
            $sql1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu
    JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta
    WHERE data_peserta.id_peserta = '$id_peserta'");


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


                <form action="../proses/inp_rad.php" enctype="multipart/form-data" autocomplete="off" method="POST">
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
                                    <td style="width: 100px;">Tanggal Lahir</td>
                                    <td style="width: 250px;"><b>: <?= $pers['tgl_lahir']; ?></b></td>
                                    <td style="width: 100px;">Tanggal Pemeriksaan</td>
                                    <td style="width: 250px;"><b>: <?= $row1['tgl']; ?></b></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4><b>1. Upload scan hasil</b></h4><br>
                            <!-- <input type="file" class="form-control" accept=".jpg, .jpeg, .png" name="image" id=""> -->
                            <?php
                            if ($row['foto_r'] > 0) { ?>
                                <div class="w-100 d-flex justify-content-center align-items-center p-3">
                                    <img src="../proses/<?= $row['foto_r'] ?>" height="300px" alt="">
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
                            <h4><b>2. Hasil Test</b></h4>
                            <table class="w-100">
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Ekspertise</td>
                                    <td>
                                        <textarea name="ekspertise_r" placeholder="Ekspertise" class="form-control w-75" style="height: 200px;" id="" required><?php if ($row['ekspertise_r']) {
                                                                                                                                                                    echo $row['ekspertise_r'];
                                                                                                                                                                } else { ?>
Cor	        : Normal
Pulmo	: Tak tampak infiltrate         
Ossa costae normal
Diapragma & Sinus kostofrenikus normal <?php } ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Kesan</td>
                                    <td>
                                        <input type="hidden" name="no_medrec" value="<?= $no_medrec ?>" id="">
                                        <input type="text" name="kesan_r" placeholder="kesan" class="form-control w-75" value="<?= $row['kesan_r'] ?>" id="" required>
                                        <!-- <input type="text" name="kesan_r" placeholder="kesan" class="form-control w-75" value="Jantung dan paru dalam batas normal." id="" required> -->
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Saran</td>
                                    <td>
                                        <textarea name="saran_r" placeholder="saran" class="form-control w-75" style="height: 100px;" id=""><?= $row['saran_r'] ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 250px;">Dokter</td>
                                    <td>
                                        <?php
                                        if ($row["dokter_r"] > 0) {?>
                                        <input type="text" name="dokter_r" class="form-control w-75" readonly value="<?=$row['dokter_r'];?>" id="">
                                        <?php
                                        } else { ?>

                                        <select required class="form-select w-75" name="dokter_r" id="">
                                            <option selected disabled>Pilih Dokter</option>
                                        <?php

                                        $dokter = mysqli_query($koneksi, "SELECT nama FROM tb_dokter WHERE sps='Radiologi'");
                                        while($dkt = mysqli_fetch_array($dokter)){ ?>
                                            <option value="<?=$dkt['nama']; ?>"><?=$dkt['nama']; ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                        <?php
                                                                                                                            }
                                        ?>
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
                        url: '../proses/img_rad.php',
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