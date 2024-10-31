<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';
include '../conn/koneksi.php';

// Mengatur jumlah data per halaman
$limit = 10;

// Mendapatkan nomor halaman dari URL, jika tidak ada maka set default ke halaman 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Menangkap parameter filter
date_default_timezone_set('Asia/Jakarta');

$selected_date = isset($_GET['date']) ? $_GET['date'] : date('d-m-Y');
$search_name = isset($_GET['name']) ? $_GET['name'] : '';
$search_company = isset($_GET['company']) ? $_GET['company'] : '';
$search_paket = isset($_GET['paket']) ? $_GET['paket'] : '';
$search_ket = isset($_GET['ket']) ? $_GET['ket'] : '';

// Mengubah format tanggal untuk ditampilkan di form
$display_date = $selected_date ? date('d-m-Y', strtotime($selected_date)) : '';

// Mengubah format tanggal untuk query
$formatted_date = $selected_date ? date('d-m-Y', strtotime($selected_date)) : '';

// Filter berdasarkan pencarian
$date_filter = $formatted_date ? "AND rekam_mcu.tgl LIKE '%$formatted_date%'" : "";
$name_filter = $search_name ? "AND (data_peserta.nama LIKE '%$search_name%' OR data_peserta.nik LIKE '%$search_name%' OR rekam_mcu.no_medrec LIKE '%$search_name%')" : "";
$company_filter = $search_company ? "AND tb_per.id_per = '$search_company'" : "";
$paket_filter = $search_paket ? "AND tb_paket.id_paket = '$search_paket'" : "";
$ket_filter = $search_ket ? "AND rekam_mcu.ket = '$search_ket'" : "";

// Query untuk mendapatkan total data
$total_query = "SELECT COUNT(*) AS total FROM data_peserta 
                JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
                JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                WHERE 1=1 $date_filter $name_filter $company_filter $paket_filter $ket_filter";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];

// Menghitung total halaman
$total_pages = ceil($total_data / $limit);

// Query untuk mendapatkan data dengan limit dan offset
$query = "SELECT *
          FROM data_peserta 
          JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
          JOIN tb_per ON data_peserta.id_per = tb_per.id_per
          JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
          WHERE 1=1 $date_filter $name_filter $company_filter $paket_filter $ket_filter
          ORDER BY rekam_mcu.id_rm DESC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($koneksi, $query);

$sql1 = mysqli_query($koneksi, "
                SELECT * FROM data_peserta
                JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
                ORDER BY rekam_mcu.no_medrec DESC
            ");

$row1 = mysqli_fetch_array($sql1);


if (!$result) {
    echo "test";
}
$start_no = $offset + 1;
?>

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Data Peserta</h1>
    </div><br>

    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px;">
        <form method="GET" action="" class="mb-3">
            <div class="row align-items-start">
                <div class="col-md-4">
                    <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($display_date) ?>">
                </div>
                <div class="col-md-4">
                    <select name="company" class="form-select">
                        <option value="">Pilih Perusahaan</option>
                        <?php
                        // Loop untuk membuat pilihan dropdown perusahaan
                        $company_result = mysqli_query($koneksi, "SELECT * FROM tb_per");
                        while ($test = mysqli_fetch_array($company_result)) { ?>
                            <option value="<?= $test['id_per'] ?>"><?= $test['nama_per'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="paket" id="paket" class="form-select mb-3">
                        <option value="">Pilih Paket</option>
                        <?php
                        // Loop untuk membuat pilihan dropdown perusahaan
                        $paket_result = mysqli_query($koneksi, "SELECT * FROM tb_paket");
                        while ($test = mysqli_fetch_array($paket_result)) { ?>
                            <option value="<?= $test['id_paket'] ?>"><?= $test['nama_paket'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="ket" id="ket" class="form-select mb-3">
                        <option value="">Pilih Status</option>
                            <option value=" ">Belum Periksa</option>
                            <option value="Fit To Work">Fit To Work</option>
                            <option value="Fit With Note">Fit With Note</option>
                            <option value="Temporary Unfit">Temporary Unfit</option>
                            <option value="Not Fit To Work">Not Fit To Work</option>
                        
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Cari Nama" value="<?= htmlspecialchars($search_name) ?>">
                </div>
                <div class="col-md-2" style="display: flex; flex-direction: row;">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="pemeriksaan.php" class="ms-2 btn btn-danger">Reset</a>
                </div>
            </div>
        </form>

        <!-- Tabel data peserta -->
        <table class="table table-striped" style="width:100%; text-align: center;">
            <thead class="table-primary">
                <tr>
                    <th style="text-align: center; vertical-align: middle;">No. Medrec</th>
                    <th style="text-align: center; vertical-align: middle;">Waktu</th>
                    <th style="text-align: center; vertical-align: middle;">NIK/NIP</th>
                    <th style="text-align: center; vertical-align: middle;">Nama</th>
                    <th style="text-align: center; vertical-align: middle;">Tanggal Lahir</th>
                    <th style="text-align: center; vertical-align: middle;">Perusahaan</th>
                    <th style="text-align: center; vertical-align: middle;">Paket Yang Dipilih</th>
                    <th style="text-align: center; vertical-align: middle;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php

                while ($row = mysqli_fetch_array($result)) {


                    $sql2 = mysqli_query($koneksi, "SELECT * FROM tb_radiologi WHERE no_medrec = '$row[no_medrec]'");
                    $sql3 = mysqli_query($koneksi, "SELECT * FROM tb_audiometri WHERE no_medrec = '$row[no_medrec]'");
                    $sql5 = mysqli_query($koneksi, "SELECT * FROM tb_lab WHERE no_medrec = '$row[no_medrec]'");
                    $sql7 = mysqli_query($koneksi, "SELECT * FROM tb_spirometri WHERE no_medrec = '$row[no_medrec]'");
                    $sql9 = mysqli_query($koneksi, "SELECT * FROM tb_umum WHERE no_medrec = '$row[no_medrec]'");
                    $sql10 = mysqli_query($koneksi, "SELECT * FROM tb_ekg WHERE no_medrec = '$row[no_medrec]'");
                    $sql11 = mysqli_query($koneksi, "SELECT * FROM rekam_mcu WHERE no_medrec = '$row[no_medrec]'");
                    $sql12 = mysqli_query($koneksi, "SELECT * FROM tb_treadmil WHERE no_medrec = '$row[no_medrec]'");


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

                    // $tanggalLahir = $row['tgl_lahir'];


                    // function hitungUmur($tanggalLahir)
                    // {
                    //     // Membuat objek DateTime dari tanggal lahir
                    //     $tanggalLahirObj = new DateTime($tanggalLahir);

                    //     // Membuat objek DateTime untuk tanggal sekarang
                    //     $sekarang = new DateTime('today');

                    //     // Menghitung selisih antara tanggal sekarang dan tanggal lahir
                    //     $umur = $tanggalLahirObj->diff($sekarang);

                    //     // Mengembalikan umur dalam tahun
                    //     return [
                    //         'hari' => $umur->d,
                    //         'bulan' => $umur->m,
                    //         'tahun' => $umur->y
                    //     ];
                    // }

                ?>
                    <tr style="height: 120px;">
                        <td style="text-align: center;"><?= $row['no_medrec'] ?></td>
                        <td style="text-align: start;"><?= $row['waktu_daftar']; ?></td>
                        <td style="text-align: start;"><?= $row['nik']; ?></td>
                        <td style="text-align: start;"><?= $row['nama']; ?></td>
                        <td style="text-align: start;"><?= $row['tgl_lahir']; ?></td>
                        <td style="text-align: start;"><?= $row['nama_per']; ?></td>
                        <td style="text-align: start;"><?= $row['nama_paket']; ?></td>
                        <td style="text-align: start;">
                            <div style="display: flex; flex-direction: row;">
                                <?php
                                if ($row['ket'] < 1) {
                                ?>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $row['id_rm'] ?>">Lihat Pemeriksaan</button>
                                <?php
                                } else { ?>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $row['id_rm'] ?>">Sudah Diperiksa</button>
                                <?php
                                } ?>
                            </div>
                            <!-- Modal Ubah Data Peserta -->
                            <div class="modal fade" id="exampleModal<?= $row['id_rm'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $row['nama'] ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row w-100 justify-content-around gap-3 p-3">

                                                <?php
                                                $q1 = mysqli_query($koneksi, "SELECT no_medrec FROM tb_umum WHERE no_medrec = '$row[no_medrec] '");
                                                $w1 = mysqli_num_rows($q1);
                                                if ($w1) { ?>
                                                    <form action="umum.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                        <input type="hidden" name="no_medrec" value="<?php echo $row9['no_medrec']; ?>">
                                                        <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                                <?php
                                                }
                                                $q2 = mysqli_query($koneksi, "SELECT no_medrec FROM tb_lab WHERE no_medrec = '$row[no_medrec] '");
                                                $w2 = mysqli_num_rows($q2);
                                                if ($w2) { ?>
                                                    <form action="lab.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                        <input type="hidden" name="no_medrec" value="<?php echo $row5['no_medrec']; ?>">
                                                        <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                                <?php
                                                }
                                                $q3 = mysqli_query($koneksi, "SELECT no_medrec FROM tb_radiologi WHERE no_medrec = '$row[no_medrec] '");
                                                $w3 = mysqli_num_rows($q3);
                                                if ($w3) { ?>
                                                    <form action="radiologi.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                        <input type="hidden" name="no_medrec" value="<?php echo $row2['no_medrec']; ?>">
                                                        <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                                <?php
                                                }
                                                $q4 = mysqli_query($koneksi, "SELECT no_medrec FROM tb_audiometri WHERE no_medrec = '$row[no_medrec] '");
                                                $w4 = mysqli_num_rows($q4);
                                                if ($w4) { ?>
                                                    <form action="audiometri.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none;">
                                                        <input type="hidden" name="no_medrec" value="<?php echo $row3['no_medrec']; ?>">
                                                        <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                                <?php
                                                }
                                                $q5 = mysqli_query($koneksi, "SELECT no_medrec FROM tb_spirometri WHERE no_medrec = '$row[no_medrec] '");
                                                $w5 = mysqli_num_rows($q5);
                                                if ($w5) { ?>
                                                    <form action="spirometri.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                                        <input type="hidden" name="no_medrec" value="<?php echo $row7['no_medrec']; ?>">
                                                        <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                                <?php
                                                }
                                                $q6 = mysqli_query($koneksi, "SELECT no_medrec FROM tb_ekg WHERE no_medrec = '$row[no_medrec] '");
                                                $w6 = mysqli_num_rows($q6);
                                                if ($w6) { ?>
                                                    <form action="ekg.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                                        <input type="hidden" name="no_medrec" value="<?php echo $row10['no_medrec']; ?>">
                                                        <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                                <?php
                                                }
                                                $q7 = mysqli_query($koneksi, "SELECT no_medrec FROM tb_treadmil WHERE no_medrec = '$row[no_medrec] '");
                                                $w7 = mysqli_num_rows($q7);
                                                if ($w7) { ?>
                                                    <form action="treadmil.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                                        <input type="hidden" name="no_medrec" value="<?php echo $row12['no_medrec']; ?>">
                                                        <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                                <?php
                                                }

                                                ?>
                                                <form action="resume.php" method="GET" class="card p-2" style="width: 18rem; box-shadow: 0px 0px 10px black; text-decoration: none; ">
                                                    <input type="hidden" name="no_medrec" value="<?php echo $row11['no_medrec']; ?>">
                                                    <input type="hidden" name="id_peserta" value="<?php echo $row['id_peserta']; ?>">
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
                                </div>
                                <!-- End of Modal -->
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                // Tombol "Previous"
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&ket=' . urlencode($search_ket) . '">Previous</a></li>';
                }

                // Tombol halaman
                $start_page = max(1, $page - 3);
                $end_page = min($total_pages, $page + 3);

                if ($start_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=1&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&ket=' . urlencode($search_ket) . '">1</a></li>';
                    if ($start_page > 2) {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                }

                for ($i = $start_page; $i <= $end_page; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&ket=' . urlencode($search_ket) . '">' . $i . '</a></li>';
                }

                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&ket=' . urlencode($search_ket) . '">' . $total_pages . '</a></li>';
                }

                // Tombol "Next"
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&ket=' . urlencode($search_ket) . '">Next</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</main>

<?php
include '../main/footer.php';
?>