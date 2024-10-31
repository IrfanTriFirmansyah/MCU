<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

?>

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Daftar Perusahaan</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#static"><i data-feather="user-plus"></i> Tambah Perusahaan</button>
    </div><br>
    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">

            <div class="modal fade" id="static" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Perusahaan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../proses/tmb_per.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nama Perusahaan :</label>
                                    <input required type="text" name="nama" placeholder="*contoh : PT. TIRTA ALAM SEGAR" class="form-control" id="recipient-name" oninput="this.value = this.value.toUpperCase()">
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Kode rekam Medis :</label>
                                    <input required type="text" name="kode" placeholder="*contoh : TAS" class="form-control" id="" oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="simpan" class="btn btn-primary" onclick="return confirm('Data Sudah Benar?')"><i data-feather="user-plus"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <table id="example" class="display" style="width:100%; text-align: center;">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">Id Perusahaan</th>
                    <th style="text-align: center;">Nama Perusahaan</th>
                    <th style="text-align: center;">Kode Rekam Medis</th>
                    <th style="text-align: center; width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $hoi = mysqli_query($koneksi, "SELECT * FROM tb_per");
                while ($fad = mysqli_fetch_array($hoi)) {
                    $no++;
                ?>
                    <tr>
                        <td style="text-align: center;"><?= $no ?></td>
                        <td style="text-align: center;"><?= $fad['id_per']; ?></td>
                        <td style="text-align: center;"><?= $fad['nama_per']; ?></td>
                        <td style="text-align: center;"><?= $fad['kode']; ?></td>
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $fad['id_per'] ?>"><i data-feather="edit"></i></button>
                            <a href="../proses/aksi_per.php?id=<?= $fad['id_per']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus?')"><i data-feather="trash-2"></i></a>

                            <div class="modal fade" id="exampleModal<?= $fad['id_per'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Dokter Pemeriksa</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../proses/aksi_per.php" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Nama :</label>
                                                    <input type="hidden" name="id" value="<?= $fad['id_per'] ?>" id="recipient-name">
                                                    <input type="text" value="<?= $fad['nama_per']; ?>" name="nama_per" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Kode Rekam Medis :</label>
                                                    <input type="text" value="<?= $fad['kode']; ?>" class="form-control" name="kode" id="">
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


<?php
include '../main/footer.php';
?>