<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';
include '../conn/koneksi.php';
?>


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
        <div class="col-3 fs-3">NIK/NIP</div>
        <div class="col-9">
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK/NIP" aria-label="Recipient's username" aria-describedby="button-addon2" required>
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
                WHERE nik = '" . $nik . "' ORDER BY data_peserta.id_peserta DESC ");


            $row = mysqli_fetch_array($sql);


            // Cek apakah peserta sudah terdaftar pada id_per yang sama di rekam_mcu
            $sql_check_duplicate = "SELECT * FROM rekam_mcu WHERE id_peserta = '$row[id_peserta]' AND id_per = '$row[id_per]'";
            $result_check = $koneksi->query($sql_check_duplicate);

            if ($result_check->num_rows > 0) {
                // Peserta sudah terdaftar, tampilkan pesan SweetAlert2
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { swal("Peserta Sudah pernah MCU, Silahkan Daftarkan Ulang","","error");';
                echo '}, 100);</script>';
                $koneksi->close();
                exit();
            }

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
                                <?php
                                if ($row['foto_lama'] < 1) { ?>
                                    <img src="../img/icons/user.png" style="height: 300px; " alt="">
                                <?php
                                } else {
                                ?>
                                    <img src="../proses/PesertaBaru/<?= htmlspecialchars($row['foto_lama']); ?>" style="height: 300px; " alt="">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-5 border border-secondary rounded d-flex justify-content-center align-items-center flex-column p-2">
                                <h4>Foto Saat Ini</h4>
                                <button type="button" class="btn btn-primary" id="startCamera">Buka Kamera</button>
                                <div id="camera" style="display:none;">
                                    <video id="video" width="320" height="240" style="margin-left: 40px;" autoplay></video>
                                    <button type="button" class="btn btn-success w-100" id="snap">Ambil Gambar</button>
                                    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                                </div>
                                <div id="preview" style="display:none;">
                                    <img id="photo" src="" alt="Gambar Preview" style="margin-left: 40px;">
                                    <button type="button" class="btn btn-warning w-100" id="retake">Ulangi Pengambilan</button>
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
                                <!-- <?php
                                if ($row['jenis_kelamin'] > 0) { ?> -->
                                    <input type="text" class="form-control" aria-label="Recipient's username" value="<?= $row['jenis_kelamin']; ?>" readonly>
                                <!-- <?php
                                } else { ?>
                                    <select name="jk" class="form-select" id="" required>
                                        <option value="LAKI-LAKI">Laki-laki</option>
                                        <option value="PEREMPUAN">Perempuan</option>
                                    </select>
                                <?php
                                } ?> -->
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
                                <input type="text" class="form-control" aria-label="Recipient's username" name="telp" value="<?= $row['telp']; ?>" placeholder="(optional)">
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
                            <button class="btn btn-primary w-100" type="submit" onclick="return confirm('Daftarkan Peserta?')"> <i data-feather="printer"></i> Simpan & Print</button>
                        </div>
                    </div>
                </form>
    </div>

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
    (function() {
        var startCamera = document.getElementById('startCamera');
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var photo = document.getElementById('photo');
        var snap = document.getElementById('snap');
        var retake = document.getElementById('retake');
        var foto = document.getElementById('foto');

        startCamera.addEventListener('click', function() {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                    document.getElementById('camera').style.display = 'block';
                    document.getElementById('startCamera').style.display = 'none';
                })
                .catch(function(err) {
                    console.error("Error accessing the camera: ", err);
                });
        });

        snap.addEventListener('click', function() {
            context.drawImage(video, 0, 0, 320, 240);
            var dataURL = canvas.toDataURL('image/png');
            photo.src = dataURL;
            foto.value = dataURL;
            document.getElementById('preview').style.display = 'block';
            document.getElementById('camera').style.display = 'none';
        });

        retake.addEventListener('click', function() {
            document.getElementById('preview').style.display = 'none';
            document.getElementById('camera').style.display = 'block';
        });
    })();
</script>



</main>



<?php
include '../main/footer.php';
?>