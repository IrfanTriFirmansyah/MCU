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
$name_filter = $search_name ? "AND data_peserta.nama LIKE '%$search_name%' OR data_peserta.nik LIKE '%$search_name%'" : "";
$company_filter = $search_company ? "AND tb_per.id_per = '$search_company'" : "";

// Query untuk mendapatkan total data
$total_query = "SELECT COUNT(*) AS total FROM data_peserta 
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
          JOIN tb_per ON data_peserta.id_per = tb_per.id_per
          JOIN tb_paket ON data_peserta.id_paket = tb_paket.id_paket
          WHERE 1=1 $date_filter $name_filter $company_filter
          ORDER BY data_peserta.id_peserta DESC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($koneksi));
}
$start_no = $offset + 1;

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
        <h1 style="font-size: 40px; font-weight: bold;">Data Peserta</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i data-feather="printer"></i> Cetak Kartu Sekaligus
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">
            <i data-feather="printer"></i> Cetak Stiker 
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Tanggal Upload Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../proses/get_kartu.php">
                            <div class="modal-body">
                                <div class="form-group">
                                    <!-- <label for="tanggal">Tanggal:</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required> -->
                                    <label for="tanggal">NIK:</label>
                                    <input type="text" class="form-control" name="nik" required id="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Isi NIK</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../proses/get_sticker.php">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tanggal">NIK:</label>
                                    <!-- <input type="date" class="form-control" id="tanggal" name="tanggal" required> -->
                                    <input type="text" class="form-control" name="nik" required id="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                    <a href="peserta.php" class="ms-2 btn btn-danger">Reset</a>
                </div>
            </div>
        </form>

        <table class="table table-striped" style="width:100%; text-align: center;">
            <thead class="table-primary">
                <tr>
                    <th style="text-align: center; vertical-align: middle;">No.</th>
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
                while ($row = mysqli_fetch_assoc($result)) {

                    $dd = mysqli_query($koneksi, "SELECT foto FROM rekam_mcu where id_peserta='$row[id_peserta]'");
                    $ds = mysqli_fetch_array($dd);
                ?>
                    <tr style="height: 120px;">
                        <td style="text-align: center;"><?= $start_no++; ?></td>
                        <td style="text-align: start;"><?= $row['waktu']; ?></td>
                        <td style="text-align: start;"><?= $row['nik']; ?></td>
                        <td style="text-align: start;"><?= $row['nama']; ?> <br> <b>(<?= $row['jenis_kelamin']; ?>)</b></td>
                        <td style="text-align: start;"><?= $row['tgl_lahir']; ?></td>
                        <td style="text-align: start;"><?= $row['nama_per']; ?> <br> <b>(<?= $row['status']; ?>)</b></td>
                        <td style="text-align: start;"><?= $row['nama_paket']; ?></td>
                        <td style="text-align: start;">
                            <div style="display: flex; flex-direction: row;">

                                <!-- <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $row['id_peserta'] ?>"><i data-feather="edit"></i></button> -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $row['id_peserta'] ?>"><i data-feather="edit"></i></button>
                                <!-- <a href="../proses/hapus_peserta.php?nik=<?= $row['nik']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus?')"><i data-feather="trash-2"></i></a> -->
                                <a href="../proses/hapus_peserta.php?id_peserta=<?= $row['id_peserta']; ?>" class="ms-2 btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus?')"><i data-feather="trash-2"></i></i></a>

                            </div>
                            <div class="modal fade" id="exampleModal<?= $row['id_peserta'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Peserta</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../proses/update_peserta.php" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3" style="display: flex; justify-content: center; align-items: center;">
                                                    <?php
                                                    if ($row['foto_lama'] > 0) {
                                                    ?>
                                                        <img src="../proses/pesertaBaru/<?= $row['foto_lama']; ?>" width="150" height="200" alt="">
                                                    <?php
                                                    } else { ?>
                                                        <img src="../img/icons/user.png" width="150" height="150" alt="">
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Nama Paket :</label>
                                                    <input type="text" value="<?= $row['nama_paket']; ?>" disabled class="form-control" id="">
                                                    <input type="hidden" value="<?= $row['id_peserta']; ?>" name="id_peserta" class="form-control" id="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Nama :</label>
                                                    <input type="hidden" name="id" value="<?= $row['id_peserta'] ?>" id="recipient-name">
                                                    <input type="text" value="<?= $row['nama']; ?>" name="nama" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">NIK :</label>
                                                    <input type="text" minlength="16" maxlength="16" value="<?= $row['nik']; ?>" class="form-control" name="nik" id="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Jenis Kelamin :</label>
                                                    <select name="jk" id="" class="form-select">
                                                        <option value="<?= $row['jenis_kelamin'] ?>" selected><?= $row['jenis_kelamin'] ?></option>
                                                        <option value="LAKI-LAKI">LAKI-LAKI</option>
                                                        <option value="PEREMPUAN">PEREMPUAN</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Tanggal Lahir :</label>
                                                    <input type="date" value="<?= date('Y-m-d', strtotime($row['tgl_lahir'])); ?>" class="form-control" name="tgl" id="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">No. Telepon :</label>
                                                    <input type="number" value="<?= $row['telp']; ?>" class="form-control" name="telp" id="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Nama Perusahaan :</label>
                                                    <input type="text" value="<?= $row['nama_per']; ?>" class="form-control" readonly id="">
                                                </div>
                                                <!-- <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Paket Yang Dipilih :</label>
                                                    <input type="text" value="<?= $row['nama_paket']; ?>" class="form-control" readonly id="">
                                                </div> -->
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Alamat :</label>
                                                    <textarea name="alamat" id="" cols="30" rows="10" class="form-control"><?= $row['alamat'] ?></textarea>
                                                </div>
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


<?php
include '../main/footer.php';
?>