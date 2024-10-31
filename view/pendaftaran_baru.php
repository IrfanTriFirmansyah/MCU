<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

?>


<main class="content">
    <div class="row" style="padding: 0;">
        <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
            <h1 style="font-size: 40px; font-weight: bold;">Pendaftaran Peserta Baru</h1> <br>
            <div class="d-flex flex-row">
                <a href="upload_data.php" class="btn btn-success me-2"><i data-feather="upload"></i> Upload Pendaftaran Sekaligus</a>
                <a href="pendaftaran.php" class="btn btn-danger"><i data-feather="arrow-left"></i> Kembali</a>
            </div>
        </div>


        <form action="../proses/inp_baru.php" enctype="multipart/form-data" autocomplete="off" method="post">
            <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: white;">
                    <h2 style=" text-align: center;"><b>Form Pendaftaran Peserta Baru</b></h2>
                    <table class="w-100 mt-5 fs-4">
                        <tr style="height: 50px;">
                            <td style="width: 250px; vertical-align: top;">Pas Foto</td>
                            <td>
                                <input type="file" class="form-control" accept=".jpg, .jpeg, .png" name="image" id="imageInput">
                                <div class="w-100 d-flex justify-content-start align-items-center " id="imagePreviewContainer" style="display: none;">
                                    <img id="imagePreview" width="180px" style="display: none;" height="200px" alt="">
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">NIK</td>
                            <td>
                                <input type="text" class="form-control w-75" name="nik" placeholder="Masukkan NIK (16 digit)" maxlength="16" minlength="16" id="" required>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Nama Lengkap</td>
                            <td>
                                <input type="text" class="form-control w-75" name="nama" placeholder="Masukkan Nama Lengkap" id="" required oninput="this.value = this.value.toUpperCase()">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Jenis Kelamin</td>
                            <td>
                                <select name="jk" id="" class="form-select w-25" required>
                                    <option selected disabled>Pilih</option>
                                    <option value="LAKI-LAKI">Laki-Laki</option>
                                    <option value="PEREMPUAN">Perempuan</option>
                                </select>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Tanggal Lahir</td>
                            <td>
                                <input type="date" class="form-control w-25" name="tgl" id="dateInput" required>
                            </td>
                        </tr>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Asal Perusahaan</td>
                            <td>
                                <select id="company" name="asal" class="form-select w-50" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <?php
                                    include '../conn/koneksi.php';
                                    $result = $koneksi->query("SELECT id_per, nama_per FROM tb_per");

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id_per'] . "'>" . $row['nama_per'] . "</option>";
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Pilih Paket</td>
                            <td>
                                <select id="package" name="paket" class="form-select w-50" required>
                                    <!-- Paket akan dimuat berdasarkan perusahaan yang dipilih -->
                                </select>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Nomor Telepon</td>
                            <td>
                                <input type="text" name="telp" class="w-75 form-control" placeholder="no. telepon WA" required value="0" id="" oninput="this.value = this.value.toUpperCase()">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px; vertical-align: top;">Alamat</td>
                            <td>
                                <!-- <input type="date" class="form-control w-25" name="tgl" id="" required> -->
                                <textarea placeholder="Masukkan alamat" name="alamat" id="" cols="30" class="form-control" rows="10" required></textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary me-2" style="width: 150px;" onclick="return confirm('Data Sudah Benar?')">Simpan Peserta</button>
                    </div>
                </div>
            </div>
        </form>


    </div>
</main>


<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("imagePreview").style.display = "block";
                const previewContainer = document.getElementById('imagePreviewContainer');
                const previewImage = document.getElementById('imagePreview');
                previewImage.src = e.target.result;
                previewContainer.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    });
    document.getElementById('dateInput').addEventListener('change', function() {
        let date = new Date(this.value);
        let formattedDate = ("0" + date.getDate()).slice(-2) + '/' + ("0" + (date.getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
        console.log(formattedDate);
    });

    $(document).ready(function() {
            $('#company').change(function() {
                var id_per = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'get_packages.php',
                    data: {id_per: id_per},
                    success: function(response) {
                        $('#package').html(response);
                    }
                });
            });
        });
</script>

<?php
include '../main/footer.php';
?>