<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';
include '../conn/koneksi.php'; // Pastikan file koneksi disertakan

// Mengatur jumlah data per halaman
$limit = 10;

// Mendapatkan nomor halaman dari URL, jika tidak ada maka set default ke halaman 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Menangkap parameter filter
$selected_date = isset($_GET['date']) ? $_GET['date'] : '';
$search_name = isset($_GET['name']) ? $_GET['name'] : '';
$search_company = isset($_GET['company']) ? $_GET['company'] : '';
$search_paket = isset($_GET['paket']) ? $_GET['paket'] : '';
$search_department = isset($_GET['department']) ? $_GET['department'] : '';

// Mengubah format tanggal untuk ditampilkan di form
$display_date = $selected_date ? date('d-m-Y', strtotime($selected_date)) : '';

// Mengubah format tanggal untuk query
$formatted_date = $selected_date ? date('d-m-Y', strtotime($selected_date)) : '';


// Filter berdasarkan pencarian
$date_filter = $formatted_date ? "AND rekam_mcu.tgl LIKE '%$formatted_date%'" : "";
$name_filter = $search_name ? "AND data_peserta.nama LIKE '%$search_name%'" : "";
$company_filter = $search_company ? "AND tb_per.id_per = '$search_company'" : "";
$paket_filter = $search_paket ? "AND tb_paket.id_paket = '$search_paket'" : "";
$department_filter = $search_department ? "AND data_peserta.department = '$search_department'" : "";

// Query untuk mendapatkan total data
$total_query = "SELECT COUNT(*) AS total FROM data_peserta 
                JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
                JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                WHERE 1=1 $date_filter $name_filter $company_filter $paket_filter $department_filter";
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
          WHERE 1=1 $date_filter $name_filter $company_filter $paket_filter $department_filter
          ORDER BY rekam_mcu.id_rm DESC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($koneksi));
}

// Fungsi untuk menentukan pesan waktu
// function getTimeMessage($timestamp) {
//     $hour = date('H', strtotime($timestamp));
//     return ($hour < 12) ? 'PAGI' : 'SIANG';
// }

?>

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Download Peserta MCU</h1>
        <div style="display: flex; justify-content: space-between; width: 37%;">
            <a href="rekap_pdf.php" class="btn btn-warning">Download Rekap PDF</a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Download Rekap Excel</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Tanggal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../proses/excel.php" method="post">
                                <label for="company">Pilih Perusahaan:</label>
                                <select name="perusahaan" id="company" class="form-select mb-3">
                                    <?php
                                    // Loop untuk membuat pilihan dropdown perusahaan
                                    $company_result = mysqli_query($koneksi, "SELECT * FROM tb_per");
                                    while ($test = mysqli_fetch_array($company_result)) { ?>
                                        <option value="<?= $test['id_per'] ?>"><?= $test['nama_per'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                                <div style="display: flex; justify-content: space-between; width: 100%;">
                                    <button name="all" class="btn btn-primary">Semua Tanggal</button>
                                    <span class="border"></span>
                                    <input type="date" class="form-control w-50" name="tgl" id="">
                                    <button type="submit" class="btn btn-success" name="date">Pilih</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>

    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px;">
        <form method="GET" action="" class="mb-3">
            <div class="row align-items-start g-2">
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
                    <select name="department" class="form-select">
                        <option value="">Pilih department</option>
                        <?php
                        // Query untuk mengambil department yang unik
                        $company_result = mysqli_query($koneksi, "SELECT DISTINCT department FROM data_peserta");
                        while ($test = mysqli_fetch_array($company_result)) { ?>
                            <option value="<?= $test['department'] ?>"><?= $test['department'] ?></option>
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
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Cari Nama" value="<?= htmlspecialchars($search_name) ?>">
                </div>
                <div class="col-md-2" style="display: flex; flex-direction: row;">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="download_data.php" class="ms-2 btn btn-danger">Reset</a>
                </div>
            </div>
        </form>

        <table class="table table-striped" style="width:100%; text-align: center;">
            <thead class="table-primary">
                <tr>
                    <th style="text-align: center; vertical-align: middle;">No. Medrec</th>
                    <th style="text-align: center; vertical-align: middle;">Tanggal</th>
                    <!-- <th style="text-align: center; vertical-align: middle;">Kategori Waktu</th> -->
                    <th style="text-align: center; vertical-align: middle;">NIK/NIP</th>
                    <th style="text-align: center; vertical-align: middle;">Nama</th>
                    <th style="text-align: center; vertical-align: middle;">Tanggal Lahir</th>
                    <th style="text-align: center; vertical-align: middle;">Perusahaan</th>
                    <th style="text-align: center; vertical-align: middle;">Nama Paket</th>
                    <th style="text-align: center; vertical-align: middle;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    // $waktu_pesan = getTimeMessage($row['waktu_daftar']);
                ?>
                    <tr>
                        <td style="text-align: center;"><b><?= htmlspecialchars($row['no_medrec']); ?></b></td>
                        <td style="text-align: start;"><?= htmlspecialchars($row['waktu_daftar']); ?></td>
                        <!-- <td style="text-align: start;"><?= htmlspecialchars($row['kategori']); ?></td> -->
                        <td style="text-align: start;"><?= htmlspecialchars($row['nik']); ?></td>
                        <td style="text-align: start;"><?= htmlspecialchars($row['nama']); ?></td>
                        <td style="text-align: start;"><?= htmlspecialchars($row['tgl_lahir']); ?></td>
                        <td style="text-align: start;"><?= htmlspecialchars($row['nama_per']); ?></td>
                        <td style="text-align: start;"><?= htmlspecialchars($row['nama_paket']); ?></td>
                        <td style="text-align: center; color:red; ">
                            <?php
                            if ($row['ket'] > 0) {
                                if ($row['status'] == 'cakar') {
                            ?>
                                    <a href="../proses/save-rm.php?no_medrec=<?= urlencode($row['no_medrec']); ?>&nama=<?= urlencode($row['nama']); ?>" class="btn btn-warning"><i data-feather="download"></i></a>
                                <?php
                                } elseif ($row['status'] == 'karyawan') { ?>
                                    <a href="../proses/save-rm.php?no_medrec=<?= urlencode($row['no_medrec']); ?>&nama=<?= urlencode($row['nama']); ?>" class="btn btn-warning mb-2">Template 1</i></a>
                                    <a href="../proses/save-rm-2.php?no_medrec=<?= urlencode($row['no_medrec']); ?>&nama=<?= urlencode($row['nama']); ?>" class="btn btn-danger mb-2">Template 2</i></a>
                            <?php
                                }
                            } else {
                                echo "Belum Terselesaikan";
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                // Tombol "Previous"
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&department=' . urlencode($search_department) . '">Previous</a></li>';
                }

                // Tombol halaman
                $start_page = max(1, $page - 3);
                $end_page = min($total_pages, $page + 3);

                if ($start_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=1&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&department=' . urlencode($search_department) . '">1</a></li>';
                    if ($start_page > 2) {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                }

                for ($i = $start_page; $i <= $end_page; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&department=' . urlencode($search_department) . '">' . $i . '</a></li>';
                }

                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&department=' . urlencode($search_department) . '">' . $total_pages . '</a></li>';
                }

                // Tombol "Next"
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '&paket=' . urlencode($search_paket) . '&department=' . urlencode($search_department) . '">Next</a></li>';
                }
                ?>
            </ul>
        </nav>

    </div>
</main>

<?php
include '../main/footer.php';
?>