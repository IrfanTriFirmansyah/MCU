<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';
include '../conn/koneksi.php';
?>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.2"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/body-pix@2.0"></script>

    <style>
        #canvas {
            background-image: url(../img/photos/test.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <main class="content">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 40px; font-weight: bold;">Pendaftaran Peserta</h1>
            <div class="d-flex flex-row">
                <!-- Trigger Modal -->
                <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#myModal">
                    <i data-feather="user-plus"></i> Tambah Peserta
                </button>
                <a href="daftar_peserta.php" class="btn btn-danger ms-3"><i data-feather="arrow-left"></i> Kembali</a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Pilih Jenis Peserta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="pendaftaran_baru.php" class="btn btn-primary me-5 fs-2 fw-bold">Calon Karyawan</a>
                                <a href="pendaftaran_lama.php" class="btn btn-success fs-2 fw-bold">Sudah Karyawan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><br>
        <div class="row ">
            <div class="col-3 fs-3">NIK</div>
            <div class="col-9">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" id="nik" name="nik" minlength="16" maxlength="16" class="form-control" placeholder="Masukkan NIK" aria-label="Recipient's username" aria-describedby="button-addon2" required>
                        <button class="btn btn-outline-secondary btn-primary" type="submit" name="cek"><i data-feather="search"></i> Cari Data</button>
                        <a href="pendaftaran.php" class="btn btn-outline-secondary btn-warning">Reset</a>
                    </div>
                </form>
            </div>

            <?php

            if (isset($_POST['cek'])) {
                $nik = $_POST['nik'];

                // $sq1 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu WHERE nik='$nik'");
                // $ron = mysqli_fetch_array($sq1);
                // if ($ron < 1) {

                $sql = mysqli_query($koneksi, "SELECT * FROM data_peserta 
                JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                WHERE nik LIKE '%" . $nik . "%' ORDER BY data_peserta.id_peserta DESC");


                $row = mysqli_fetch_array($sql);

                if ($row > 0) {
                    echo '<script type="text/javascript">';
                    echo 'setTimeout(function () { swal("Data Berhasil Ditemukan","","success");';
                    echo '}, 100);</script>';

            ?>
                    <form method="post" enctype="multipart/form-data" action="../proses/simpan_daftar.php">
                        <div class="col-12" style="margin-bottom: 10px;">
                            <div class="row justify-content-around">
                                <div class=" col-5 border border-secondary rounded d-flex justify-content-center align-items-center flex-column p-2">
                                    <h4>Foto Awal</h4>
                                    <img src="../proses/PesertaBaru/<?= htmlspecialchars($row['foto_lama']); ?>" style="height: 300px; " alt="">
                                </div>
                                <div class="col-5 border border-secondary rounded d-flex justify-content-center align-items-center flex-column p-2">
                                    <div id="container">
                                        <video id="webcam" style="display: none;" autoplay width="640" height="500"></video>
                                        <canvas id="canvas"></canvas>
                                    </div>
                                    <button id="captureButton" class="btn btn-success">Ambil Gambar</button>
                                    <div id="result" style="display:none;">
                                        <img id="capturedImage" src="" alt="Gambar yang Diambil" style="width: 640px; height: auto;">
                                        <button type="button" class="btn btn-warning" id="retakeButton">Ulangi Pengambilan</button>
                                    </div>
                                    <input type="hidden" id="foto" name="foto">


                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 fs-3">Nama</div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" id="nama" name="nama" readonly class="form-control" value="<?= $row['nama']; ?>">
                                </div>
                            </div>
                            <div class="col-3 fs-3">NIK</div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" id="nik" name="nik" class="form-control" value="<?= $row['nik']; ?>" readonly>
                                    <input type="hidden" id="nik" name="id_peserta" class="form-control" value="<?= $row['id_peserta']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-3 fs-3">Jenis Kelamin</div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" aria-label="Recipient's username" value="<?= $row['jenis_kelamin']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-3 fs-3">Tanggal Lahir</div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" aria-label="Recipient's username" value="<?= $row['tgl_lahir']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-3 fs-3">Nomor Telepon</div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" aria-label="Recipient's username" name="telp" value="<?= $row['telp']; ?>">
                                </div>
                            </div>
                            <div class="col-3 fs-3">Asal Perusahaan</div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="hidden" value="<?= $row['id_per']; ?>" name="id_per" id="">
                                    <input type="text" class="form-control" aria-label="Recipient's username" value="<?= $row['nama_per']; ?>" readonly>
                                </div>
                            </div>

                            <?php
                            if ($row['status'] == 'karyawan') {
                            ?>

                                <div class="col-3 fs-3">Departemen</div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-label="Recipient's username" value="<?= $row['department']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-3 fs-3">Lokasi Kerja</div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <input type="hidden" value="<?= $row['id_per']; ?>" name="id_per" id="">
                                        <input type="text" class="form-control" aria-label="Recipient's username" value="<?= $row['lokasi']; ?>" readonly>
                                    </div>
                                </div>

                            <?php }
                            ?>

                            <div class="col-3 fs-3">Pilihan PAKET</div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="hidden" value="<?= $row['id_paket']; ?>" name="id_paket" id="">
                                    <input type="text" class="form-control" aria-label="Recipient's username" value="<?= $row['nama_paket']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit" onclick="return confirm('Daftarkan Peserta?')"> <i data-feather="printer"></i> DAFTARKAN</button>
                            </div>
                        </div>
                    </form>
        </div>
</body>

</html>

<?php
                } else {
                    echo '<script type="text/javascript">';
                    echo 'setTimeout(function () { swal("Data Tidak Ditemukan","","error");';
                    echo '}, 100);</script>';
                }
                // } else {
                //     echo '<script type="text/javascript">';
                //     echo 'setTimeout(function () { swal("Peserta Sudah Terdaftar","","warning");';
                //     echo '}, 100);</script>';
                // }
            }
?>


<script>
let captureButton = document.getElementById('captureButton');
let resultDiv = document.getElementById('result');
let capturedImage = document.getElementById('capturedImage');
let retakeButton = document.getElementById('retakeButton');
let fotoInput = document.getElementById('foto');

// Menangkap gambar ketika tombol diklik
captureButton.addEventListener('click', () => {
    // Mengambil gambar dari video
    webcamCanvasCtx.drawImage(video, 0, 0);
    let imageDataURL = webcamCanvas.toDataURL('image/png');
    capturedImage.src = imageDataURL;
    resultDiv.style.display = 'block';
    fotoInput.value = imageDataURL;  // Menyimpan data gambar dalam input tersembunyi
});

// Menyembunyikan hasil dan membersihkan canvas jika pengambilan diulang
retakeButton.addEventListener('click', () => {
    resultDiv.style.display = 'none';
    webcamCanvasCtx.clearRect(0, 0, webcamCanvas.width, webcamCanvas.height);
});

    let video = document.getElementById("webcam");
    let webcamCanvas = document.getElementById("canvas");
    let webcamCanvasCtx = webcamCanvas.getContext('2d');

    //In Memory Canvas used for model prediction
    var tempCanvas = document.createElement('canvas');
    var tempCanvasCtx = tempCanvas.getContext('2d');

    let previousSegmentationComplete = true;

    let segmentationProperties = {
        segmentationThreshold: 0.7,
        internalResolution: 'full'
    }

    var model;
    bodyPix.load().then(function(loadedModel) {
        model = loadedModel;
    });

    function main() {
        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(e => {
                    console.log("Error occurred while getting the video stream");
                });
        }

        video.onloadedmetadata = () => {
            webcamCanvas.width = video.videoWidth;
            webcamCanvas.height = video.videoHeight;
            tempCanvas.width = video.videoWidth;
            tempCanvas.height = video.videoHeight;
        };

        video.addEventListener("loadeddata", segmentPersons);
    }

    function segmentPersons() {
        tempCanvasCtx.drawImage(video, 0, 0);
        if (previousSegmentationComplete) {
            previousSegmentationComplete = false;
            // Now classify the canvas image we have available.
            model.segmentPerson(tempCanvas, segmentationProperties)
                .then(segmentation => {
                    processSegmentation(segmentation);
                    previousSegmentationComplete = true;
                });
        }
        //Call this function repeatedly to perform segmentation on all frames of the video.
        window.requestAnimationFrame(segmentPersons);
    }

    function processSegmentation(segmentation) {
        var imgData = tempCanvasCtx.getImageData(0, 0, webcamCanvas.width, webcamCanvas.height);
        //Loop through the pixels in the image
        for (let i = 0; i < imgData.data.length; i += 4) {
            let pixelIndex = i / 4;
            //Make the pixel transparent if it does not belong to a person using the body-pix model's output data array.
            //This removes all pixels corresponding to the background.
            if (segmentation.data[pixelIndex] == 0) {
                imgData.data[i + 3] = 0;
            }
        }
        //Draw the updated image on the canvas
        webcamCanvasCtx.putImageData(imgData, 0, 0);
    }

    main();
</script>

</main>



<?php
include '../main/footer.php';
?>