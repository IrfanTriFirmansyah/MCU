<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

?>

<main class="content">
    <h1 style="font-size: 40px; font-weight: bold;">Data Pemeriksaan</h1> <br>

    <div class="row" style="padding: 0;">
        <div class="col-3 fs-3">Cari data</div>
        <div class="col-9">
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK/Nama" required>
                    <button class="btn btn-outline-secondary btn-primary" type="submit" name="cek"><i data-feather="search"></i> Cari Data</button>
                    <a href="pemeriksaan.php" class="btn btn-outline-secondary btn-danger">Reset</a>
                </div>
            </form>
        </div>

        <?php

        if (!isset($_GET['no_medrec'])) {
            if (isset($_GET['cek'])) {
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { swal("Data Berhasil Ditemukan","","success");';
                echo '}, 100);</script>';
                $nik = $_GET['nik'];
                $nik = mysqli_real_escape_string($koneksi, $nik); // Pastikan untuk mengamankan input
                $sql1 = mysqli_query($koneksi, "
                SELECT * FROM data_peserta
                JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
                WHERE nik LIKE '%" . $nik . "%' OR nama LIKE '%" . $nik . "%' OR rekam_mcu.no_medrec LIKE '%" . $nik . "%'
                ORDER BY rekam_mcu.no_medrec DESC
                LIMIT 1
            ");
                $row1 = mysqli_fetch_array($sql1);



                if ($row1 > 1) {

                    // $sql = mysqli_query($koneksi, "SELECT * FROM rekam_mcu 
                    // JOIN tb_umum ON rekam_mcu.no_medrec = tb_umum.no_medrec
                    // JOIN tb_lab ON rekam_mcu.no_medrec = tb_lab.no_medrec
                    // JOIN tb_radiologi ON rekam_mcu.no_medrec = tb_radiologi.no_medrec
                    // JOIN tb_audiometri ON rekam_mcu.no_medrec = tb_audiometri.no_medrec
                    // JOIN tb_spirometri ON rekam_mcu.no_medrec = tb_spirometri.no_medrec
                    // JOIN tb_ekg ON rekam_mcu.no_medrec = tb_ekg.no_medrec
                    // JOIN tb_treadmil ON rekam_mcu.no_medrec = tb_treadmil.no_medrec
                    // WHERE rekam_mcu.no_medrec = '$row1[no_medrec]'");
                    $sql2 = mysqli_query($koneksi, "SELECT * FROM tb_radiologi WHERE no_medrec = '$row1[no_medrec]'");
                    $sql3 = mysqli_query($koneksi, "SELECT * FROM tb_audiometri WHERE no_medrec = '$row1[no_medrec]'");
                    $sql5 = mysqli_query($koneksi, "SELECT * FROM tb_lab WHERE no_medrec = '$row1[no_medrec]'");
                    $sql7 = mysqli_query($koneksi, "SELECT * FROM tb_spirometri WHERE no_medrec = '$row1[no_medrec]'");
                    $sql9 = mysqli_query($koneksi, "SELECT * FROM tb_umum WHERE no_medrec = '$row1[no_medrec]'");
                    $sql10 = mysqli_query($koneksi, "SELECT * FROM tb_ekg WHERE no_medrec = '$row1[no_medrec]'");
                    $sql11 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu WHERE no_medrec = '$row1[no_medrec]'");
                    $sql12 = mysqli_query($koneksi, "SELECT * FROM tb_treadmil WHERE no_medrec = '$row1[no_medrec]'");


                    // $row = mysqli_fetch_array($sql);
                    // echo $row['keluhan'];
                    $row2 = mysqli_fetch_array($sql2);
                    $row3 = mysqli_fetch_array($sql3);
                    $row5 = mysqli_fetch_array($sql5);
                    $row7 = mysqli_fetch_array($sql7);
                    $row9 = mysqli_fetch_array($sql9);
                    $row10 = mysqli_fetch_array($sql10);
                    $row11 = mysqli_fetch_array($sql11);
                    $row12 = mysqli_fetch_array($sql12);

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
                            'hari' => $umur->d,
                            'bulan' => $umur->m,
                            'tahun' => $umur->y
                        ];
                    }

        ?>


                    <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                        <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
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
                                <tr style="font-size: 15px;">
                                    <td style="width: 100px;">Perusahaan</td>
                                    <td style="width: 250px;"><b>: <?= $row1['nama_per']; ?></b></td>
                                    <td style="width: 100px;">Paket</td>
                                    <td style="width: 250px;"><b>: <?= $row1['nama_paket']; ?></b></td>
                                    <td style="width: 100px;">Tanggal Pemeriksaan</td>
                                    <td style="width: 250px;"><b>: <?= $row1['tgl']; ?></b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                            <h4 class="mb-4"><b>Pilih Pemeriksaan</b></h4>

                            <div class="row w-100 justify-content-around gap-3 p-3">

                                <?php

                                $mor = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$row1[id_paket]'");
                                while ($rom = mysqli_fetch_array($mor)) {
                                    

                                    switch ($rom['tipe_paket']) {
                                        case 'tb_umum': ?>
                                            <form action="umum.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                <input type="hidden" name="no_medrec" value="<?php echo $row9['no_medrec']; ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                                <img src="../img/avatars/7.png" class="card-img-top">
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h2><b>Pemeriksaan Fisik</b></h2>
                                                    <?php if ($row9['status'] == '1') { ?>
                                                        <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                                    <?php } elseif ($row9['status'] == '') { ?>
                                                        <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        <?php break;

                                        case 'tb_lab': ?>
                                            <form action="lab.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                <input type="hidden" name="no_medrec" value="<?php echo $row5['no_medrec']; ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                                <img src="../img/avatars/4.png" class="card-img-top">
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h2><b>Laboratorium</b></h2>
                                                    <?php if ($row5['status'] == '1') { ?>
                                                        <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                                    <?php } elseif ($row5['status'] == '') { ?>
                                                        <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        <?php break;

                                        case 'tb_radiologi': ?>
                                            <form action="radiologi.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                <input type="hidden" name="no_medrec" value="<?php echo $row2['no_medrec']; ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                                <img src="../img/avatars/8.png" class="card-img-top">
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h2><b>Radiologi</b></h2>
                                                    <?php if ($row2['status'] == '1') { ?>
                                                        <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                                    <?php } elseif ($row2['status'] == '') { ?>
                                                        <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        <?php break;

                                        case 'tb_audiometri': ?>
                                            <form action="audiometri.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                <input type="hidden" name="no_medrec" value="<?php echo $row3['no_medrec']; ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                                <img src="../img/avatars/1.png" class="card-img-top">
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h2><b>Audiometri</b></h2>
                                                    <?php if ($row3['status'] == '1') { ?>
                                                        <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                                    <?php } elseif ($row3['status'] == '') { ?>
                                                        <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        <?php break;

                                        case 'tb_spirometri': ?>
                                            <form action="spirometri.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                                <input type="hidden" name="no_medrec" value="<?php echo $row7['no_medrec']; ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                                <img src="../img/avatars/9.png" class="card-img-top">
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h2><b>Spirometri</b></h2>

                                                    <?php
                                                    if ($row7['status'] == '1') {
                                                    ?>
                                                        <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                                    <?php
                                                    } elseif ($row7['status'] == '') {
                                                    ?>
                                                        <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </form>
                                        <?php break;

                                        case 'tb_ekg': ?>
                                            <form action="ekg.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                                <input type="hidden" name="no_medrec" value="<?php echo $row10['no_medrec']; ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                                <img src="../img/avatars/6.png" class="card-img-top">
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h2><b>EKG</b></h2>

                                                    <?php
                                                    if ($row10['status'] == '1') {
                                                    ?>
                                                        <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                                    <?php
                                                    } elseif ($row10['status'] == '') {
                                                    ?>
                                                        <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </form>
                                        <?php break;

                                        case 'tb_treadmil': ?>
                                            <form action="treadmil.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                                <input type="hidden" name="no_medrec" value="<?php echo $row12['no_medrec']; ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                                <img src="../img/avatars/3.png" class="card-img-top">
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h2><b>Treadmill</b></h2>

                                                    <?php
                                                    if ($row12['status'] == '1') {
                                                    ?>
                                                        <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                                    <?php
                                                    } elseif ($row12['status'] == '') {
                                                    ?>
                                                        <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </form>
                                <?php break;
                                    }
                                } ?>
                                <form action="resume.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                    <input type="hidden" name="no_medrec" value="<?php echo $row11['no_medrec']; ?>">
                                    <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                    <img src="../img/avatars/resume.jpg" class="card-img-top">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h2><b>Resume Akhir</b></h2>

                                        <?php
                                        if ($row11['ket'] > 0) {
                                        ?>
                                            <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                        <?php
                                        } elseif ($row11['ket']  < 1) {
                                        ?>
                                            <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>


            <?php
                }
            } else {
                // echo '<script type="text/javascript">';
                // echo 'setTimeout(function () { swal("Data Tidak Ditemukan","","error");';
                // echo '}, 100);</script>';
            }
        } else {

            $no_medrec = $_GET['no_medrec'];
            $no_medrec = mysqli_real_escape_string($koneksi, $no_medrec); // Pastikan untuk mengamankan input
            $sql1 = mysqli_query($koneksi, "
                SELECT * FROM data_peserta
                JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
                WHERE no_medrec LIKE '%" . $no_medrec . "%' OR nama LIKE '%" . $no_medrec . "%'
                ORDER BY data_peserta.id_peserta DESC
                LIMIT 1
            ");
            $row1 = mysqli_fetch_array($sql1);

            // $sql = mysqli_query($koneksi, "SELECT * FROM rekam_mcu 
            // JOIN tb_umum ON rekam_mcu.no_medrec = tb_umum.no_medrec
            // JOIN tb_lab ON rekam_mcu.no_medrec = tb_lab.no_medrec
            // JOIN tb_radiologi ON rekam_mcu.no_medrec = tb_radiologi.no_medrec
            // JOIN tb_audiometri ON rekam_mcu.no_medrec = tb_audiometri.no_medrec
            // JOIN tb_spirometri ON rekam_mcu.no_medrec = tb_spirometri.no_medrec
            // JOIN tb_ekg ON rekam_mcu.no_medrec = tb_ekg.no_medrec
            // JOIN tb_treadmil ON rekam_mcu.no_medrec = tb_treadmil.no_medrec
            // WHERE rekam_mcu.no_medrec = '$row1[no_medrec]'");

            $sql2 = mysqli_query($koneksi, "SELECT * FROM tb_radiologi WHERE no_medrec = '$row1[no_medrec]'");
            $sql3 = mysqli_query($koneksi, "SELECT * FROM tb_audiometri WHERE no_medrec = '$row1[no_medrec]'");
            $sql5 = mysqli_query($koneksi, "SELECT * FROM tb_lab WHERE no_medrec = '$row1[no_medrec]'");
            $sql7 = mysqli_query($koneksi, "SELECT * FROM tb_spirometri WHERE no_medrec = '$row1[no_medrec]'");
            $sql9 = mysqli_query($koneksi, "SELECT * FROM tb_umum WHERE no_medrec = '$row1[no_medrec]'");
            $sql10 = mysqli_query($koneksi, "SELECT * FROM tb_ekg WHERE no_medrec = '$row1[no_medrec]'");
            $sql11 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu WHERE no_medrec = '$row1[no_medrec]'");
            $sql12 = mysqli_query($koneksi, "SELECT * FROM tb_treadmil WHERE no_medrec = '$row1[no_medrec]'");

            // $row = mysqli_fetch_array($sql);

            $row2 = mysqli_fetch_array($sql2);
            $row3 = mysqli_fetch_array($sql3);
            $row5 = mysqli_fetch_array($sql5);
            $row7 = mysqli_fetch_array($sql7);
            $row9 = mysqli_fetch_array($sql9);
            $row10 = mysqli_fetch_array($sql10);
            $row11 = mysqli_fetch_array($sql11);
            $row12 = mysqli_fetch_array($sql12);

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
                    'hari' => $umur->d,
                    'bulan' => $umur->m,
                    'tahun' => $umur->y
                ];
            }
            ?>

            <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
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
                        <tr style="font-size: 15px;">
                            <td style="width: 100px;">Perusahaan</td>
                            <td style="width: 250px;"><b>: <?= $row1['nama_per']; ?></b></td>
                            <td style="width: 100px;">Paket</td>
                            <td style="width: 250px;"><b>: <?= $row1['nama_paket']; ?></b></td>
                            <td style="width: 100px;">Tanggal Pemeriksaan</td>
                            <td style="width: 250px;"><b>: <?= $row1['tgl']; ?></b></td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4 class="mb-4"><b>Pilih Pemeriksaan</b></h4>

                    <div class="row w-100 justify-content-around gap-3 p-3">

                        <?php

                        $mor = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$row1[id_paket]'");
                        while ($rom = mysqli_fetch_array($mor)) {

                            switch ($rom['tipe_paket']) {
                                case 'tb_umum': ?>
                                    <form action="umum.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                        <input type="hidden" name="no_medrec" value="<?php echo $row9['no_medrec']; ?>">
                                        <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                        <img src="../img/avatars/7.png" class="card-img-top">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <h2><b>Pemeriksaan Fisik</b></h2>
                                            <?php if ($row9['status'] == '1') { ?>
                                                <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                            <?php } elseif ($row9['status'] == '') { ?>
                                                <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                            <?php } ?>
                                        </div>
                                    </form>
                                <?php break;

                                case 'tb_lab': ?>
                                    <form action="lab.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                        <input type="hidden" name="no_medrec" value="<?php echo $row5['no_medrec']; ?>">
                                        <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                        <img src="../img/avatars/4.png" class="card-img-top">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <h2><b>Laboratorium</b></h2>
                                            <?php if ($row5['status'] == '1') { ?>
                                                <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                            <?php } elseif ($row5['status'] == '') { ?>
                                                <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                            <?php } ?>
                                        </div>
                                    </form>
                                <?php break;

                                case 'tb_radiologi': ?>
                                    <form action="radiologi.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                        <input type="hidden" name="no_medrec" value="<?php echo $row2['no_medrec']; ?>">
                                        <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                        <img src="../img/avatars/8.png" class="card-img-top">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <h2><b>Radiologi</b></h2>
                                            <?php if ($row2['status'] == '1') { ?>
                                                <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                            <?php } elseif ($row2['status'] == '') { ?>
                                                <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                            <?php } ?>
                                        </div>
                                    </form>
                                <?php break;

                                case 'tb_audiometri': ?>
                                    <form action="audiometri.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                        <input type="hidden" name="no_medrec" value="<?php echo $row3['no_medrec']; ?>">
                                        <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                        <img src="../img/avatars/1.png" class="card-img-top">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <h2><b>Audiometri</b></h2>
                                            <?php if ($row3['status'] == '1') { ?>
                                                <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                            <?php } elseif ($row3['status'] == '') { ?>
                                                <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                            <?php } ?>
                                        </div>
                                    </form>
                                <?php break;

                                case 'tb_spirometri': ?>
                                    <form action="spirometri.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                        <input type="hidden" name="no_medrec" value="<?php echo $row7['no_medrec']; ?>">
                                        <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                        <img src="../img/avatars/9.png" class="card-img-top">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <h2><b>Spirometri</b></h2>

                                            <?php
                                            if ($row7['status'] == '1') {
                                            ?>
                                                <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                            <?php
                                            } elseif ($row7['status'] == '') {
                                            ?>
                                                <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </form>
                                <?php break;

                                case 'tb_ekg': ?>
                                    <form action="ekg.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                        <input type="hidden" name="no_medrec" value="<?php echo $row10['no_medrec']; ?>">
                                        <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                        <img src="../img/avatars/6.png" class="card-img-top">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <h2><b>EKG</b></h2>

                                            <?php
                                            if ($row10['status'] == '1') {
                                            ?>
                                                <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                            <?php
                                            } elseif ($row10['status'] == '') {
                                            ?>
                                                <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </form>
                                <?php break;

                                case 'tb_treadmil': ?>
                                    <form action="treadmil.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                        <input type="hidden" name="no_medrec" value="<?php echo $row12['no_medrec']; ?>">
                                        <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                                        <img src="../img/avatars/3.png" class="card-img-top">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <h2><b>Treadmill</b></h2>

                                            <?php
                                            if ($row12['status'] == '1') {
                                            ?>
                                                <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                            <?php
                                            } elseif ($row12['status'] == '') {
                                            ?>
                                                <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </form>
                        <?php break;
                            }
                        } ?>
                        <form action="resume.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                            <input type="hidden" name="no_medrec" value="<?php echo $row11['no_medrec']; ?>">
                            <input type="hidden" name="id_peserta" value="<?php echo $row1['id_peserta']; ?>">
                            <img src="../img/avatars/resume.jpg" class="card-img-top">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h2><b>Resume Akhir</b></h2>

                                <?php
                                if ($row11['ket'] > 0) {
                                ?>
                                    <button type="submit" class="btn btn-success"><i data-feather="check-circle"></i> Sudah Diperiksa</button>
                                <?php
                                } elseif ($row11['ket']  < 1) {
                                ?>
                                    <button type="submit" class="btn btn-danger"><i data-feather="x-circle"></i> Belum Diperiksa</button>
                                <?php
                                }
                                ?>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        <?php
        }
        ?>


</main>


<?php
include '../main/footer.php';
?>