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

// Mengubah format tanggal untuk ditampilkan di form
$display_date = $selected_date ? date('d-m-Y', strtotime($selected_date)) : '';

// Mengubah format tanggal untuk query
$formatted_date = $selected_date ? date('d-m-Y', strtotime($selected_date)) : '';

// Filter berdasarkan pencarian
$date_filter = $formatted_date ? "AND rekam_mcu.tgl LIKE '%$formatted_date%'" : "";
$name_filter = $search_name ? "AND data_peserta.nama LIKE '%$search_name%' OR rekam_mcu.no_medrec LIKE '%$search_name%' OR data_peserta.nik LIKE '%$search_name%'" : "";
$company_filter = $search_company ? "AND tb_per.id_per = '$search_company'" : "";

// Query untuk mendapatkan total data
$total_query = "SELECT COUNT(*) AS total FROM data_peserta 
                JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta
                JOIN tb_per ON data_peserta.id_per = tb_per.id_per
                JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
                WHERE 1=1 $date_filter $name_filter $company_filter";
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
          WHERE 1=1 $date_filter $name_filter $company_filter
          ORDER BY rekam_mcu.id_rm DESC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($koneksi));
}

// Fungsi untuk menentukan pesan waktu
// function getTimeMessage($timestamp) {
//     $hour = date('H', strtotime($timestamp));
//     if ($hour >= 8 && $hour < 12) {
//         return 'PAGI';
//     } elseif ($hour >= 13 && $hour < 24) {
//         return 'SIANG';
//     } else {
//         return '';
//     }
// }

?>

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Daftar Peserta MCU</h1>
        <!-- <a href="../view/pendaftaran.php" class="btn btn-primary"><i data-feather="user-plus"></i> Tambah Peserta</a> -->
        <a href="../view/pendaftaran.php" class="btn btn-primary"><i data-feather="user-plus"></i> Pendaftaran Baru</a>
    </div><br>

    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px;">
        <form method="GET" action="" class="mb-3">
            <div class="row align-items-start">
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($display_date) ?>">
                </div>
                <div class="col-md-3">
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
                    <input type="text" name="name" class="form-control" placeholder="Cari Nama" value="<?= htmlspecialchars($search_name) ?>">
                </div>
                <div class="col-md-2" style="display: flex; flex-direction: row;">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="daftar_peserta.php" class="ms-2 btn btn-danger">Reset</a>
                </div>
            </div>
        </form>

        <table class="table table-striped" style="width:100%; text-align: center;">
            <thead class="table-primary">
                <tr>
                    <!-- <th style="text-align: center;">No.</th> -->
                    <th style="text-align: center; vertical-align: middle;">No. Medrec</th>
                    <th style="text-align: center; vertical-align: middle;">Tanggal</th>
                    <!-- <th style="text-align: center; vertical-align: middle;">Kategori Waktu</th> Kolom baru -->
                    <th style="text-align: center; vertical-align: middle;">Identitas</th>
                    <th style="text-align: center; vertical-align: middle;">Keterangan Instansi</th>
                    <th style="text-align: center; vertical-align: middle;">Foto</th>
                    <!-- <th style="text-align: center; vertical-align: middle;">Perusahaan</th> -->
                    <!-- <th style="text-align: center; vertical-align: middle;">Nama Paket</th> -->
                    <th style="text-align: center; vertical-align: middle;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    // $pesan_waktu = getTimeMessage($row['waktu_daftar']); // Dapatkan pesan waktu
                ?>
                    <tr style="height: 200px;">
                        <!-- <td style="text-align: center;"><?= $no ?></td> -->
                        <td style="text-align: center;"><?= htmlspecialchars($row['no_medrec']); ?><br><b><?=htmlspecialchars($row['id_peserta']); ?></b></td>
                        <td style="text-align: start;"><?= htmlspecialchars($row['waktu_daftar']); ?></td>
                        <!-- <td style="text-align: start;"><?= htmlspecialchars($row['kategori']); ?></td>  -->
                        <td style="text-align: start;">
                            <b style="font-size: 17px;"><?= htmlspecialchars($row['nama']); ?> </b>
                            <ul>
                                <li>NIK/NIP : <?= htmlspecialchars($row['nik']); ?></li>
                                <li>Jenis Kelamin : <?= htmlspecialchars($row['jenis_kelamin']); ?></li>
                                <li>Tanggal Lahir: <?= htmlspecialchars($row['tgl_lahir']); ?></li>
                                <li>Nomor HP: <?= htmlspecialchars($row['telp']); ?></li>
                            </ul>
                    

                        </td>
                        <!-- <td style="text-align: start;"><?= htmlspecialchars($row['nama']); ?></td> -->
                        <td style="text-align: center;"><?= htmlspecialchars($row['nama_per']); ?> <br>
                         <b>   (<?= htmlspecialchars($row['nama_paket']); ?>)</b></td>
                        <td style="text-align: start;"><img src="../proses/<?= $row['foto']; ?>" width="100" height="130" alt=""></td>
                        <!-- <td style="text-align: start;"><?= htmlspecialchars($row['nama_paket']); ?></td> -->
                        <td style="text-align: start;">
                            <div style="display: flex;flex-direction: column;">
                                <a style="width: 130px;" href="../proses/cetak.php?id_peserta=<?= htmlspecialchars($row['id_peserta']); ?>" class="btn btn-success mb-2">Cetak Kartu</a>
                                <?php
                                if ($row['bayar'] == 'Ya') {
                                ?>
                                    <a href="../proses/invoice.php?id_peserta=<?= htmlspecialchars($row['id_peserta']); ?>" class="btn btn-primary  ">Cetak Invoice</a>
                                <?php
                                } else {
                                }
                                ?>
                                <a href="../proses/stiker.php?id_peserta=<?= htmlspecialchars($row['id_peserta']); ?>&nama=<?= htmlspecialchars($row['nama']) ?>" class="btn btn-warning mt-2">Cetak Sticker</a>
                                <!-- <a href="../proses/stiker2.php?id_peserta=<?= htmlspecialchars($row['id_peserta']); ?>&nama=<?= htmlspecialchars($row['nama']) ?>" class="btn btn-warning mb-2 mt-2">Cetak Sticker 2</a> -->
                                <!-- <a href="../proses/hapus_id.php?nik=<?= htmlspecialchars($row['nik']); ?>" class="btn btn-danger">Hapus Peserta</a> -->
                            </div>
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
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '">Previous</a></li>';
                }

                // Tombol halaman
                $start_page = max(1, $page - 3);
                $end_page = min($total_pages, $page + 3);

                if ($start_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=1&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '">1</a></li>';
                    if ($start_page > 2) {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                }

                for ($i = $start_page; $i <= $end_page; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '">' . $i . '</a></li>';
                }

                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '">' . $total_pages . '</a></li>';
                }

                // Tombol "Next"
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&date=' . urlencode($display_date) . '&name=' . urlencode($search_name) . '&company=' . urlencode($search_company) . '">Next</a></li>';
                }
                ?>
            </ul>
        </nav>

    </div>
</main>

<!-- <script>
    let table = new DataTable('#example');
</script> -->

<?php
include '../main/footer.php';
?>