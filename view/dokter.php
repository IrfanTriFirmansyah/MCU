<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

?>

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Daftar Dokter</h1>
        <!-- <a href="../view/pendaftaran.php" class="btn btn-primary"><i data-feather="user-plus"></i> Tambah Peserta</a> -->
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" ><i data-feather="user-plus"></i> Tambah Peserta</button> -->
    </div><br>

    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3 mb-5" style="background-color: white; margin-left: 1px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <h4><b>Dokter Hiperkes (Hygiene Perusahaan dan Kesehatan Kerja)</b></h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i data-feather="user-plus"></i> Tambah Dokter Hiperkes</button>

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Dokter Hiperkes</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../proses/tmb_hiper.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nama :</label>
                                    <input required type="text" name="nama" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Pemeriksaan:</label>
                                    <input type="text" readonly value="Hiperkes" class="form-control" id="recipient-name">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="simpan" class="btn btn-primary"><i data-feather="user-plus"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <form action="../proses/tmb_hiper.php" method="post">
            <div class="row">
                <div class="col-3">
                    Saat ini
                </div>
                <div class="col-1">
                    :
                </div>
                <div class="col-8">

                    <select name="dkt" class="form-select" id="">
                        <?php
                        $daf = mysqli_query($koneksi, "SELECT * FROM tb_dokter WHERE aktif='2'");
                        $def = mysqli_fetch_array($daf); ?>
                        <option value="<?= $def['nama'] ?>" selected><?= $def['nama'] ?></option>
                        <?php


                        $set = mysqli_query($koneksi, "SELECT * FROM tb_dokter WHERE aktif='1'");
                        while ($srs = mysqli_fetch_array($set)) {
                        ?>
                            <option value="<?= $srs['nama'] ?>"><?= $srs['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>

                </div>
                <div class="col-12 g-4" style="height: 70px; display: flex; justify-content: center; align-items: center; flex-direction: column; ">
                    <button type="submit" name="edit" class="mb-3 btn btn-success w-100" onclick="return confirm('Data Sudah Benar?')"><i data-feather="save"></i> Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <h4><b>Dokter Pemeriksa</b></h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#static"><i data-feather="user-plus"></i> Tambah Dokter Pemeriksa</button>

            <div class="modal fade" id="static" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Dokter Pemeriksa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../proses/tmb_pem.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nama :</label>
                                    <input required type="text" name="nama" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Pemeriksaan:</label>
                                    <!-- <input required type="text" name="pem" class="form-control" id=""> -->
                                    <select class="form-select" name="pem" id="">
                                        <option disabled selected>pilih</option>
                                        <option value="Pemeriksaan Fisik">Pemeriksaan Fisik</option>
                                        <option value="Laboratorium">Laboratorium</option>
                                        <option value="EKG">EKG</option>
                                        <option value="Spirometri">Spirometri</option>
                                        <option value="Audiometri">Audiometri</option>
                                        <option value="Treadmill">Treadmill</option>
                                        <option value="Radiologi">Radiologi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="simpan" class="btn btn-primary" onclick="return confirm('Data Sudah Benar?')"><i data-feather="user-plus"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <table id="example" class="display" style="width:100%; text-align: center;">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">Nama Dokter</th>
                    <th style="text-align: center;">Pemeriksaan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $hoi = mysqli_query($koneksi, "SELECT * FROM tb_dokter WHERE aktif=''");
                while ($fad = mysqli_fetch_array($hoi)) {
                    $no++;
                ?>
                    <tr>
                        <td style="text-align: center;"><?= $no ?></td>
                        <td style="text-align: center;"><?= $fad['nama']; ?></td>
                        <td style="text-align: center;"><?= $fad['sps']; ?></td>
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $fad['id'] ?>"><i data-feather="edit"></i></button>
                            <a href="../proses/hapus.php?nama=<?= $fad['nama']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus?')"><i data-feather="trash-2"></i></a>

                            <div class="modal fade" id="exampleModal<?= $fad['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Dokter Pemeriksa</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../proses/update.php" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Nama :</label>
                                                    <input type="hidden" name="id" value="<?= $fad['id'] ?>" id="recipient-name">
                                                    <input type="text" value="<?= $fad['nama']; ?>" name="nama" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Pemeriksaan :</label>
                                                    <input type="text" value="<?= $fad['sps']; ?>" readonly class="form-control" name="pem" id="">
                                                </div>
                                                <?php
                                                if($fad['ttd'] < 1){
                                                ?>
                                                <label for="recipient-name" class="col-form-label">Upload Tanda Tangan :</label>
                                                <div id="uploadContainer">
                                                    <input type="file" id="inputImage" name="ttd" accept="image/*" class="form-control">
                                                </div>
                                                <?php } 
                                                else{ ?>
                                                    <img src="../proses/ttd/<?=$fad['ttd']?>" width="100px" alt="">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Simpan Perubahan</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
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

<script>
    let table = new DataTable('#example');

    // const exampleModal = document.getElementById('exampleModal')
    // if (exampleModal) {
    //     exampleModal.addEventListener('show.bs.modal', event => {
    //         // Button that triggered the modal
    //         const button = event.relatedTarget
    //         // Extract info from data-bs-* attributes
    //         const recipient = button.getAttribute('data-bs-whatever')
    //         // If necessary, you could initiate an Ajax request here
    //         // and then do the updating in a callback.

    //         // Update the modal's content.
    //         const modalTitle = exampleModal.querySelector('.modal-title')
    //         const modalBodyInput = exampleModal.querySelector('.modal-body input')

    //         // modalTitle.textContent = `New message to ${recipient}`
    //         modalBodyInput.value = recipient
    //     })
    // }
</script>
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
                    const noMedrec = '<?php echo $fad['id']; ?>'; // ambil no_medrec dari PHP
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