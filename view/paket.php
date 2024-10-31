<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

?>

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Daftar Paket</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#static"><i data-feather="user-plus"></i> Tambah Paket</button>
    </div><br>
    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">

            <div class="modal fade" id="static" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Paket</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../proses/aksi_paket.php" method="POST" onsubmit="return validateForm()">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nama Paket :</label>
                                    <input required type="text" name="nama" placeholder="*contoh : PAKET STANDART" class="form-control" id="recipient-name" oninput="this.value = this.value.toUpperCase()">
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Asal Perusahaan :</label>
                                    <select id="company" name="id_per" class="form-select" required>
                                        <option disabled selected>Pilih</option>
                                        <?php
                                        $result = mysqli_query($koneksi, "SELECT * FROM tb_per");

                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id_per'] . "'>" . $row['nama_per'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Pilih Pemeriksaan :</label>
                                    <br>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck1" value="tb_umum" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck1">Pemeriksaan Fisik</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck2" value="tb_lab" autocomplete="off" >
                                    <label class="btn btn-outline-primary mb-1" for="btncheck2">Laboratorium </label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck111" value="hbsag_crm" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck111">HBsAg</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck123" value="darah_lengkap" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck123">Darah Lengkap</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck3000" value="kimia_darah" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck3000">Kimia Darah</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck300" value="fungsi_ginjal" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck300">Fungsi Ginjal</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck3" value="fungsi_hati" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck3">Fungsi Hati</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck321" value="urine_lengkap" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck321">Urine Lengkap</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck9" value="test_hcg" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck9">Test Kehamilan</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck90" value="test_narkoba" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck90">Test Narkoba</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck99" value="test_hiv" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck99">Test HIV</label>

                                    <!-- <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck2" value="tb_lab" autocomplete="off" >
                                    <label class="btn btn-outline-primary mb-1" for="btncheck2">Laboratorium </label> -->

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck4" value="tb_spirometri" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck4">Spirometri</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck5" value="tb_audiometri" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck5">Audiometri</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck6" value="tb_treadmil" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck6">Treadmill</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck7" value="tb_ekg" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck7">EKG</label>

                                    <input type="checkbox" name="pemeriksaan[]" class="btn-check" id="btncheck8" value="tb_radiologi" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck8">Radiologi</label>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Harga Laki-laki:</label>
                                    <input required type="text" name="harga_male" value="0" class="form-control" id="harga_male" oninput="this.value = this.value.toUpperCase()">

                                    <label for="recipient-name" class="col-form-label">Harga Perempuan:</label>
                                    <input required type="text" name="harga_female" value="0" class="form-control" id="harga_female" oninput="this.value = this.value.toUpperCase()">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Bayar Ditempat :</label>

                                    <input type="radio" name="bayar" class="btn-check" id="btncheck100" value="Ya" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck100">Ya</label>

                                    <input type="radio" name="bayar" class="btn-check" id="btncheck1110" value="Tidak" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="btncheck1110">Tidak</label>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="simpan" class="btn btn-primary"><i data-feather="user-plus"></i> Simpan</button>
                            </div>
                        </form>

                        <script>
                            function validateForm() {
                                var hbsagChecked1 = document.getElementById('btncheck3000').checked;
                                var hbsagChecked2 = document.getElementById('btncheck300').checked;
                                var hbsagChecked3 = document.getElementById('btncheck3').checked;
                                var hbsagChecked4 = document.getElementById('btncheck9').checked;
                                var hbsagChecked5 = document.getElementById('btncheck90').checked;
                                var hbsagChecked6 = document.getElementById('btncheck90').checked;
                                var hbsagChecked7 = document.getElementById('btncheck123').checked;
                                var hbsagChecked8 = document.getElementById('btncheck321').checked;
                                var labChecked = document.getElementById('btncheck2').checked;

                                if (hbsagChecked1 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }



                                if (hbsagChecked2 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }



                                if (hbsagChecked3 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }



                                if (hbsagChecked4 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }



                                if (hbsagChecked5 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }



                                if (hbsagChecked6 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }



                                if (hbsagChecked7 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }



                                if (hbsagChecked8 && !labChecked) {
                                    alert('Silahkan pilih Laboratorium');
                                    return false; // mencegah form dari submit
                                }

                                return confirm("Apakah data sudah benar?");

                            }
                        </script>

                    </div>
                </div>
            </div>

        </div>

        <table id="example" class="display" style="width:100%; text-align: center;">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">Kode Paket</th>
                    <th style="text-align: center;">Nama Paket</th>
                    <th style="text-align: center;">Perusahaan</th>
                    <th style="text-align: center;">Harga Laki-laki</th>
                    <th style="text-align: center;">Harga Perempuan</th>
                    <th style="text-align: center;">Bayar Ditempat</th>
                    <th style="text-align: center;">Pemeriksaan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $hoi = mysqli_query($koneksi, "SELECT * FROM tb_paket JOIN tb_per ON tb_paket.id_per = tb_per.id_per");
                while ($fad = mysqli_fetch_array($hoi)) {
                    $no++;
                ?>
                    <tr>
                        <td style="text-align: center;"><?= $no ?></td>
                        <td style="text-align: center;"><?= $fad['id_paket']; ?></td>
                        <td style="text-align: center;"><?= $fad['nama_paket']; ?></td>
                        <td style="text-align: center;"><?= $fad['nama_per']; ?></td>
                        <td style="text-align: center;">Rp <?= $fad['harga_male']; ?></td>
                        <td style="text-align: center;">Rp <?= $fad['harga_female']; ?></td>
                        <td style="text-align: center;"><?= $fad['bayar']; ?></td>
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-info" style="width: 170px;" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $fad['id_paket'] ?>">Lihat Pemeriksaan</button>

                            <div class="modal fade" id="exampleModal<?= $fad['id_paket'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pemeriksaan</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../proses/aksi_paket.php" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3" style="text-align: start;">
                                                    <label for="recipient-name" class="col-form-label">Nama Paket :</label>
                                                    <input type="hidden" name="id" value="<?= $fad['id_paket'] ?>" id="recipient-name">
                                                    <input type="text" value="<?= $fad['nama_paket']; ?>" name="nama_paket" class="form-control" readonly>
                                                </div>
                                                <div class="mb-3" style="text-align: start;">
                                                    <label for="message-text" class="col-form-label">Perusahaan :</label>
                                                    <input type="text" value="<?= $fad['nama_per']; ?>" class="form-control" name="kode" id="" readonly>
                                                </div>
                                                <div class="mb-3" style="text-align: start;">
                                                    <label for="message-text" class="col-form-label">Harga Laki-laki :</label>
                                                    <input type="text" value="<?= $fad['harga_male']; ?>" class="form-control" name="kode" id="" readonly>
                                                </div>
                                                <div class="mb-3" style="text-align: start;">
                                                    <label for="message-text" class="col-form-label">Harga Perempuan :</label>
                                                    <input type="text" value="<?= $fad['harga_female']; ?>" class="form-control" name="kode" id="" readonly>
                                                </div>
                                                <div class="mb-3" style="text-align: start;">
                                                    <label for="message-text" class="col-form-label">Pemeriksaan :</label>
                                                    <?php
                                                    $mor = mysqli_query($koneksi, "SELECT * FROM tb_detail_paket WHERE id_paket = '$fad[id_paket]'");

                                                    while ($rom = mysqli_fetch_array($mor)) {
                                                        $tipe_paket = $rom['tipe_paket'];
                                                        switch ($tipe_paket) {
                                                            case 'tb_umum':
                                                                echo "<input type='text' value='Pemeriksaan Umum' class='form-control mb-1' readonly>";
                                                                break;
                                                            default;
                                                                break;
                                                        }
                                                    }


                                                    // mysqli_data_seek($mor, 0); // Reset the result pointer to the beginning
                                                    // while ($rom = mysqli_fetch_array($mor)) {
                                                    //     $tipe_paket = $rom['tipe_paket'];
                                                    //     if (in_array(
                                                    //         $tipe_paket,
                                                    //         [
                                                    //             'tb_lab'
                                                    //             // , 'fungsi_hati'
                                                    //             // , 'test_kehamilan'
                                                    //             // , 'test_narkoba'
                                                    //             // , 'fungsi_ginjal'
                                                    //             // , 'kimia_darah'
                                                    //         ]
                                                    //     )) {
                                                    //         $showCommonInput = true;
                                                    //         break; // Exit the loop as we only need to show one input
                                                    //     }
                                                    // }

                                                    // if ($showCommonInput) {
                                                    //     echo "<input type='text' value='Laboratorium Lengkap' class='form-control mb-1' readonly>";
                                                    // }


                                                    mysqli_data_seek($mor, 0); // Reset the result pointer to the beginning
                                                    while ($rom = mysqli_fetch_array($mor)) {
                                                        $tipe_paket = $rom['tipe_paket'];
                                                        switch ($tipe_paket) {
                                                            case 'darah_lengkap':
                                                                echo "<input type='text' value='Darah Lengkap' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'urine_lengkap':
                                                                echo "<input type='text' value='Urine Lengkap' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'hbsag_crm':
                                                                echo "<input type='text' value='HBsAg' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'kimia_darah':
                                                                echo "<input type='text' value='Kimia Darah' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'fungsi_ginjal':
                                                                echo "<input type='text' value='Fungsi Ginjal' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'fungsi_hati':
                                                                echo "<input type='text' value='Fungsi Hati' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'test_hcg':
                                                                echo "<input type='text' value='Test Kehamilan' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'test_narkoba':
                                                                echo "<input type='text' value='Test Narkoba' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'test_hiv':
                                                                echo "<input type='text' value='Test HIV' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'tb_spirometri':
                                                                echo "<input type='text' value='Spirometri' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'tb_audiometri':
                                                                echo "<input type='text' value='Audiometri' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'tb_treadmil':
                                                                echo "<input type='text' value='Treadmill' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'tb_ekg':
                                                                echo "<input type='text' value='EKG' class='form-control mb-1' readonly>";
                                                                break;
                                                            case 'tb_radiologi':
                                                                echo "<input type='text' value='Radiologi' class='form-control mb-1' readonly>";
                                                                break;
                                                                // Add more cases if you have additional examination types
                                                            default:
                                                                break;
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <!-- <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Simpan Perubahan</button>
                                            </div> -->
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td style="text-align: center;">
                            <a href="../proses/aksi_paket.php?id=<?= $fad['id_paket']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    let table = new DataTable('#example');

    const exampleModal = document.getElementById('exampleModal')
    if (exampleModal) {
        exampleModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const recipient = button.getAttribute('data-bs-whatever')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = exampleModal.querySelector('.modal-title')
            const modalBodyInput = exampleModal.querySelector('.modal-body input')

            // modalTitle.textContent = `New message to ${recipient}`
            modalBodyInput.value = recipient
        })
    }
</script>
<script>
    document.getElementById('harga_male').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\./g, '');
        e.target.value = new Intl.NumberFormat('de-DE').format(value);
    });

    document.getElementById('harga_female').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\./g, '');
        e.target.value = new Intl.NumberFormat('de-DE').format(value);
    });

    document.getElementById('hargaForm').addEventListener('submit', function() {
        let hargaMaleInput = document.getElementById('harga_male');
        let hargaFemaleInput = document.getElementById('harga_female');

        hargaMaleInput.value = hargaMaleInput.value.replace(/\./g, '');
        hargaFemaleInput.value = hargaFemaleInput.value.replace(/\./g, '');
    });
</script>


<?php
include '../main/footer.php';
?>