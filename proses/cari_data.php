<?php
// ../proses/cari_data.php

include '../conn/koneksi.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];

    // Query untuk mencari data berdasarkan NIK
    $sql = mysqli_query($koneksi, "SELECT * FROM data_peserta 
            JOIN tb_per ON data_peserta.id_per = tb_per.id_per
            JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
            WHERE nik LIKE '%" . $nik . "%'");

    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);

        // Tampilkan hasil pencarian secara dinamis
        echo '
        <form id="formSimpan" method="post" enctype="multipart/form-data" action="../proses/simpan_daftar.php">
        <div class="col-12" style="margin-bottom: 10px;">
            <div class="row justify-content-around">
                <div class=" col-5 border border-secondary rounded d-flex justify-content-center align-items-center flex-column p-2">
                    <h4>Foto Awal</h4>
                    <img src="../proses/PesertaBaru/'. $row['foto_lama'] . '" style="height: 300px; " alt="">
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
                    <input type="text" id="nama" name="nama" readonly class="form-control" value="'. $row['nama'] . '">
                </div>
            </div>
            <div class="col-3 fs-3">NIK</div>
            <div class="col-9">
                <div class="input-group mb-3">
                    <input type="text" id="nik" name="nik" class="form-control" value="'. $row['nik'] . '" readonly>
                </div>
            </div>
            <div class="col-3 fs-3">Jenis Kelamin</div>
            <div class="col-9">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" aria-label="Recipient username" value="'. $row['jenis_kelamin'] . '" readonly>
                </div>
            </div>
            <div class="col-3 fs-3">Tanggal Lahir</div>
            <div class="col-9">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" aria-label="Recipient username" value="'. $row['tgl_lahir'] . '" readonly>
                </div>
            </div>
            <div class="col-3 fs-3">Nomor Telepon</div>
            <div class="col-9">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" aria-label="Recipient username" name="telp" value="'. $row['telp'] . '">
                </div>
            </div>
            <div class="col-3 fs-3">Asal Perusahaan</div>
            <div class="col-9">
                <div class="input-group mb-3">
                    <input type="hidden" value="'. $row['id_per'] . '" name="id_per" id="">
                    <input type="text" class="form-control" aria-label="Recipient username" value="'. $row['nama_per'] . '" readonly>
                </div>
            </div>
            <div class="col-3 fs-3">Pilihan PAKET</div>
            <div class="col-9">
                <div class="input-group mb-3">
                    <input type="hidden" value="'. $row['id_paket'] . '" name="id_paket" id="">
                    <input type="text" class="form-control" aria-label="Recipient username" value="'. $row['nama_paket'] . '" readonly>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" onclick="return confirm(\'Apakah data sudah benar?\')"> <i data-feather="printer"></i> Simpan & Print</button>
            </div>
        </div>
    </form>
    
        ';
    } else {
        // Kirim pesan bahwa data tidak ditemukan
        echo 'Data tidak ditemukan';
    }
}
?>
