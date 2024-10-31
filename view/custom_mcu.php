<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';
?>


<script>
    function hitungBMI() {
        const tinggi = parseFloat(document.getElementById("tinggi").value);
        const berat = parseFloat(document.getElementById("berat").value);

        if (tinggi > 0 && berat > 0) {
            const tinggiMeter = tinggi / 100;
            const bmi = berat / (tinggiMeter * tinggiMeter);
            let status = "";

            if (bmi < 18.5) {
                status = "Underweight";
            } else if (bmi >= 18.5 && bmi < 25.0) {
                status = "Ideal";
            } else if (bmi >= 25.1 && bmi < 29.9) {
                status = "Overweight";
            } else {
                status = "Obesitas";
            }

            document.getElementById("stat").value = status;
            document.getElementById("imt").value = bmi.toFixed(2);
        }
    }
</script>

<main class="content">
    <div class="row" style="padding: 0;">
        <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
            <h1 style="font-size: 40px; font-weight: bold;">Pemeriksaan Fisik</h1>
            <form action="pemeriksaan.php" method="GET">
                <input type="hidden" name="no_medrec" value="<?php echo $no_medrec; ?>">
                <button class="btn btn-danger" type="submit">Kembali</button>
            </form>
        </div><br>

        <form action="../proses/save-rm-custom.php" method="POST">
            <div class="row text-dark" style="margin-left: 1px; margin-top: 20px; ">
                <div class="col-12 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4><b>Identitas Peserta</b></h4>
                    <table class="fs-5 w-100">
                        <tr style="height: 50px;">
                            <td style="width: 100px;">NIK</td>
                            <td style="width: 250px;"><input type="text" class=" form-control" name="nik" class="fw-bold" required></td>
                            <td style="width: 100px;">Nama</td>
                            <td style="width: 250px;"><input type="text" class=" form-control" name="nama" class="fw-bold" required></td>
                            <td style="width: 100px;">Tanggal Lahir</td>
                            <td style="width: 250px;"><input type="date" class=" form-control" name="tgl_lahir" class="fw-bold" required></td>

                        </tr>
                        <tr>
                            <td style="width: 100px;">Perusahaan</td>
                            <td style="width: 250px;"><input type="text" class=" form-control" name="per" class="fw-bold" value="PRIBADI" required></b></td>
                            <td style="width: 100px;">Paket</td>
                            <td style="width: 250px;"><input type="text" class=" form-control" name="paket" value="MEDICAL KARYAWAN" class="fw-bold" required></b></td>
                            <td style="width: 100px;">Tanggal Pemeriksaan</td>
                            <td style="width: 250px;"><input type="date" class=" form-control" name="tgl" class="fw-bold" required></td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">Jenis Kelamin</td>
                            <td style="width: 250px;"><select name="jk" id="" class="form-select">
                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                            </td>
                            <td style="width: 100px;">No. Medrec</td>
                            <td style="width: 250px;"><input type="text" class=" form-control" name="medrec" class="fw-bold" required></td>
                            <td style="width: 100px;">No. Telepon</td>
                            <td style="width: 250px;"><input type="text" class=" form-control" name="telp" class="fw-bold" required></td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4><b>1. Anamnesa</b></h4>
                    <table class="w-100">
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Keluhan</td>
                            <td style="width: 250px;">
                                <input required class="form-check-input" type="radio" name="keluhan" id="yak" value="ya">
                                <label class="form-check-label" for="yak">
                                    Ya
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="keluhan" id="tidakk" value="tidak">
                                <label class="form-check-label" for="tidakk">
                                    Tidak
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_keluhan">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Merokok</td>
                            <td>
                                <input required class="form-check-input" type="radio" name="merokok" value="ya" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Ya
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="merokok" value="tidak" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Tidak
                                </label>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Alkohol</td>
                            <td>
                                <div>
                                    <input required class="form-check-input" type="radio" name="alkohol" id="alkohol" value="ya">
                                    <label class="form-check-label" for="alkohol">
                                        Ya
                                    </label>
                                    <input required class="form-check-input ms-6" type="radio" name="alkohol" id="alkohol2" value="tidak">
                                    <label class="form-check-label" for="alkohol2">
                                        Tidak
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Asma</td>
                            <td>
                                <div>
                                    <input required class="form-check-input" type="radio" name="asma" id="asma" value="ya">
                                    <label class="form-check-label" for="asma">
                                        Ya
                                    </label>
                                    <input required class="form-check-input ms-6" type="radio" name="asma" id="asma2" value="tidak">
                                    <label class="form-check-label" for="asma2">
                                        Tidak
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">TBC</td>
                            <td>
                                <div>
                                    <input required class="form-check-input" type="radio" name="tbc" id="tbc" value="ya">
                                    <label class="form-check-label" for="tbc">
                                        Ya
                                    </label>
                                    <input required class="form-check-input ms-6" type="radio" name="tbc" id="tbc2" value="tidak">
                                    <label class="form-check-label" for="tbc2">
                                        Tidak
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Operasi</td>
                            <td>
                                <div>
                                    <input required class="form-check-input" type="radio" name="operasi" id="operasi" value="ya">
                                    <label class="form-check-label" for="operasi">
                                        Ya
                                    </label>
                                    <input required class="form-check-input ms-6" type="radio" name="operasi" id="operasi2" value="tidak">
                                    <label class="form-check-label" for="operasi2">
                                        Tidak
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" name="inp_operasi">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Alergi</td>
                            <td>
                                <div>
                                    <input required class="form-check-input" type="radio" name="alergi" id="alergi" value="ya">
                                    <label class="form-check-label" for="alergi">
                                        Ya
                                    </label>
                                    <input required class="form-check-input ms-6" type="radio" name="alergi" id="alergi2" value="tidak">
                                    <label class="form-check-label" for="alergi2">
                                        Tidak
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" name="inp_alergi">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Olahraga</td>
                            <td> <input required class="form-check-input" type="radio" name="olahraga" id="olgya" value="ya">
                                <label class="form-check-label" for="olgya">
                                    Ya
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="olahraga" id="olgga" value="tidak">
                                <label class="form-check-label" for="olgga">
                                    Tidak
                                </label>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Riwayat Penyakit</td>
                            <td colspan="2">
                                <textarea class="form-control w-100" style="height: 100px;" name="rwt_penyakit" id="" required></textarea>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Riwayat Penyakit Keluarga</td>
                            <td colspan="2">
                                <textarea class="form-control w-100" style="height: 100px;" name="rwt_penyakit_kel" id="" required></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4><b>2. Tanda-tanda Vital</b></h4>
                    <table class="w-100">
                        <tr style="height: 50px;">
                            <td>Tekanan Darah</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="tekanan">
                                    <span class="input-group-text" id="basic-addon2">mm/Hg</span>
                                </div>
                            </td>
                            <td style="text-align: center;">Tinggi Badan</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" id="tinggi" name="tb" oninput="hitungBMI()">
                                    <span class="input-group-text" id="basic-addon2">cm</span>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td>Detak Nadi</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="detak">
                                    <span class="input-group-text" id="basic-addon2">/menit</span>
                                </div>
                            </td>
                            <td style="text-align: center;">Berat Badan</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" id="berat" name="bb" oninput="hitungBMI()">
                                    <span class="input-group-text" id="basic-addon2">kg</span>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td>Nafas</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="nafas">
                                    <span class="input-group-text" id="basic-addon2">/menit</span>
                                </div>
                            </td>
                            <td style="text-align: center;">IMT</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" id="imt" name="imt" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td>suhu</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="suhu">
                                    <span class="input-group-text" id="basic-addon2">&deg;C</span>
                                </div>
                            </td>
                            <td style="text-align: center;">Status</td>
                            <td style="width: 300px;">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="stat" id="stat">
                                    <!-- <span class="input-group-text" id="basic-addon2">&deg;C</span> -->
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4><b>3. Pemeriksaan Fisik</b></h4>
                    <table class="w-100 mt-3">
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Kepala</td>
                            <td style="width: 250px;">
                                <input required class="form-check-input" type="radio" name="kepala" id="normal0" value="normal">
                                <label class="form-check-label" for="normal0">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="kepala" id="kelainan0" value="kelainan">
                                <label class="form-check-label" for="kelainan0">
                                    Kelainan
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_kepala">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Leher</td>
                            <td style="width: 250px;">
                                <input required class="form-check-input" type="radio" name="leher" id="normal-1" value="normal">
                                <label class="form-check-label" for="normal-1">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="leher" id="kelainan-1" value="kelainan">
                                <label class="form-check-label" for="kelainan-1">
                                    Kelainan
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_leher">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">THT</td>
                            <td style="width: 250px;">
                                <input required class="form-check-input" type="radio" name="tht" id="normal" value="normal">
                                <label class="form-check-label" for="normal">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="tht" id="kelainan" value="kelainan">
                                <label class="form-check-label" for="kelainan">
                                    Kelainan
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_tht">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Dada</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="dada" id="normal1" value="normal">
                                <label class="form-check-label" for="normal1">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="dada" id="kelainan1" value="kelainan">
                                <label class="form-check-label" for="kelainan1">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_dada">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Jantung</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="jantung" id="normal2" value="normal">
                                <label class="form-check-label" for="normal2">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="jantung" id="kelainan2" value="kelainan">
                                <label class="form-check-label" for="kelainan2">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_jantung">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Paru</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="paru" id="normal3" value="normal">
                                <label class="form-check-label" for="normal3">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="paru" id="kelainan3" value="kelainan">
                                <label class="form-check-label" for="kelainan3">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_paru">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Abdomen</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="perut" id="normal4" value="normal">
                                <label class="form-check-label" for="normal4">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="perut" id="kelainan4" value="kelainan">
                                <label class="form-check-label" for="kelainan4">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_perut">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Saluran Kemih</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="kemih" id="normal5" value="normal">
                                <label class="form-check-label" for="normal5">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="kemih" id="kelainan5" value="kelainan">
                                <label class="form-check-label" for="kelainan5">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_kemih">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Tulang Belakang</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="sendi" id="normal6" value="normal">
                                <label class="form-check-label" for="normal6">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="sendi" id="kelainan6" value="kelainan">
                                <label class="form-check-label" for="kelainan6">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_sendi">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Syaraf</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="syaraf" id="normal7" value="normal">
                                <label class="form-check-label" for="normal7">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="syaraf" id="kelainan7" value="kelainan">
                                <label class="form-check-label" for="kelainan7">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_syaraf">
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 300px;">Anggota Gerak</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="gerak" id="normal8" value="normal">
                                <label class="form-check-label" for="normal8">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="gerak" id="kelainan8" value="kelainan">
                                <label class="form-check-label" for="kelainan8">
                                    Kelainan &nbsp;
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="note" id="detailKelainan" name="inp_gerak">
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4><b>4. Pemeriksaan Mata</b></h4>
                    <table style="width: 100%;">

                        <tr style="height: 60px; background-color: #d3d3d3;">
                            <td class="border border-secondary p-3" colspan="3">
                                <b>Visus Mata</b>
                            </td>
                        </tr>
                        <tr style="height: 60px;">
                            <td class="border border-secondary p-3">
                                VOD
                            </td>
                            <td class="border border-secondary p-3" colspan="2">
                                <input required type="text" class="form-control w-100" placeholder="isi 'NORMAL' jika hasil 20/20" name="vod" id="">
                            </td>
                        </tr>
                        <tr style="height: 60px;">
                            <td class="border border-secondary p-3">
                                VOS
                            </td>
                            <td class="border border-secondary p-3" colspan="2">
                                <input required type="text" class="form-control w-100" placeholder="isi 'NORMAL' jika hasil 20/20" name="vos" id="">
                            </td>
                        </tr>

                        <tr style="height: 50px;">
                            <td style="width: 300px;">Buta Warna</td>
                            <td style="width: 250px">
                                <input required class="form-check-input" type="radio" name="buta" id="normal9" value="Normal">
                                <label class="form-check-label" for="normal9">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="buta" id="kelainan9" value="Parsial">
                                <label class="form-check-label" for="kelainan9">
                                    Parsial
                                </label>
                            </td>
                            <td>
                                <input required class="form-check-input ms-6" type="radio" name="buta" id="parsial9" value="Total">
                                <label class="form-check-label" for="parsial9">
                                    Total
                                </label>
                            </td>
                        </tr>

                        <tr style="height: 50px;">
                            <td style="width: 250px;">Note</td>
                            <td colspan="2">
                                <textarea name="note_mata" placeholder="note" class="form-control w-75" style="height: 100px;" id=""></textarea>
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-4 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4><b>5. Pemeriksaan Gigi & Mulut</b></h4> <br>
                    <table class="mb-3" style="width: 100%;">
                        <tr style="height: 60px; background-color: #d3d3d3; text-align: center;">
                            <td class="border border-secondary p-3">
                                <b>Bagian</b>
                            </td>
                            <td class="border border-secondary p-3">
                                <b>Hasil Pemeriksaan</b>
                            </td>
                            <td class="border border-secondary p-3">
                                <b>Keterangan</b>
                            </td>
                        </tr>
                        <tr style="height: 60px;">
                            <td class="border border-secondary p-3">
                                Bibir
                            </td>
                            <td class="border border-secondary p-3">
                                <input required class="form-check-input" type="radio" name="bibir" id="normal11" value="normal">
                                <label class="form-check-label" for="normal11">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="bibir" id="kelainan11" value="kelainan">
                                <label class="form-check-label" for="kelainan11">
                                    Tidak Normal &nbsp;
                                </label>
                            </td>
                            <td class="border border-secondary p-3">
                                <input type="text" name="inp_bibir" class="form-control" placeholder="Keterangan" id="">
                            </td>
                        </tr>
                        <tr style="height: 60px;">
                            <td class="border border-secondary p-3">
                                Gigi
                            </td>
                            <td class="border border-secondary p-3">
                                <input required class="form-check-input" type="radio" name="gigi" id="normal12" value="normal">
                                <label class="form-check-label" for="normal12">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="gigi" id="kelainan12" value="kelainan">
                                <label class="form-check-label" for="kelainan12">
                                    Tidak Normal &nbsp;
                                </label>
                            </td>
                            <td class="border border-secondary p-3">
                                <input type="text" name="inp_gigi" class="form-control" placeholder="Keterangan" id="">
                            </td>
                        </tr>
                        <tr style="height: 60px;">
                            <td class="border border-secondary p-3">
                                Gusi
                            </td>
                            <td class="border border-secondary p-3">
                                <input required class="form-check-input" type="radio" name="gusi" id="normal13" value="normal">
                                <label class="form-check-label" for="normal13">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="gusi" id="kelainan13" value="kelainan">
                                <label class="form-check-label" for="kelainan13">
                                    Tidak Normal &nbsp;
                                </label>
                            </td>
                            <td class="border border-secondary p-3">
                                <input type="text" name="inp_gusi" class="form-control" placeholder="Keterangan" id="">
                            </td>
                        </tr>
                        <tr style="height: 60px;">
                            <td class="border border-secondary p-3">
                                Mukosa
                            </td>
                            <td class="border border-secondary p-3">
                                <input required class="form-check-input" type="radio" name="mukosa" id="normal14" value="normal">
                                <label class="form-check-label" for="normal14">
                                    Normal
                                </label>
                                <input required class="form-check-input ms-6" type="radio" name="mukosa" id="kelainan14" value="kelainan">
                                <label class="form-check-label" for="kelainan14">
                                    Tidak Normal &nbsp;
                                </label>
                            </td>
                            <td class="border border-secondary p-3">
                                <input type="text" name="inp_mukosa" class="form-control" placeholder="Keterangan" id="">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                    <h4><b>6. Ekspertise Pemeriksaan Fisik</b></h4>
                    <table class="w-100">
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Kesan</td>
                            <td>
                                <input type="hidden" name="no_medrec" value="<?= $row['no_medrec'] ?>" id="">
                                <textarea name="kesan_u" placeholder="Kesan" class="form-control w-75" style="height: 100px;" id="">Pemeriksaan Kesehatan dalam Batas Normal</textarea>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Saran</td>
                            <td>
                                <textarea name="saran_u" placeholder="saran" class="form-control w-75" style="height: 100px;" id="">-</textarea>
                            </td>
                        </tr>
                        <tr style="height: 50px;">
                            <td style="width: 250px;">Dokter</td>
                            <td>
                                <input type="text" name="dokter_u" class="form-control w-75" id="" value="dr. Muhammad Aufaiq Akmal Noor">
                                    </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-3 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                <h4><b>Laboratorium</b></h4>
                <table style="width: 100%;">

                    <tr style="height: 20px;" class="bg-primary">
                        <td class="border border-secondary text-white p-3">
                            <b>Pemeriksaan</b>
                        </td>
                        <td class="border border-secondary text-white p-3">
                            <b>Hasil</b>
                        </td>
                        <td class="border border-secondary text-white p-3">
                            <b>Nilai Rujukan</b>
                        </td>
                        <td class="border border-secondary text-white p-3">
                            <b>Satuan</b>
                        </td>
                    </tr>
                    <tr style="height: 50px;">
                        <td>Complete Blood Count</td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>leukosit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="leukosit" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>4.0 - 11.0</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>x 103³ µL</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Eosinofil</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="eosinofil" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>0 - 3</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>%</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Basofil</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="basofil" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>0</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>%</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Batang</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="batang" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>2 - 6</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>%</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Limfosit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="limfosit" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>20 - 40</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>%</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Monosit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="monosit" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>2 - 8</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>%</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Segmen</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="segmen" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>50 - 70</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>%</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Hemoglobin</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="hemoglobin" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Laki-laki = 13.0 - 17.0</b><br>
                            <b>Perempuan = 12.0 - 16.0</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>g/dL</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Eritrosit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="eritrosit" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Laki-laki= 4,7 - 6,1</b><br>
                            <b>Perempuan= 4,0 - 5,5</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>x 10⁶ µL</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Hematokrit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="hematokrit" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Laki-laki = 42 - 54 </b><br>
                            <b>Perempuan = 38 - 46</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>%</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>MCV</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="mcv" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>80 - 100</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>fl</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>MCH</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="mch" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>26 - 34</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>pg</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>MCHC</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="mchc" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>32 - 36</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>g/dl</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Trombosit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="trombosit" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>150 - 450</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>x 10³ µL</b>
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>LED</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="led" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>0 - 20</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                            <b>mm/jam</b>
                        </td>
                    </tr>
                    <td style="height: 40px;">
                        Urine (Makroskopis)
                    </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>WARNA URINE</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="warna" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>KUNING</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>KEJERNIHAN</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="jernih" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>JERNIH</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>PROTEIN</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="protein" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Reduksi</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="reduksi" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>PH</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="ph" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>5 - 8</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>BERAT JENIS</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="berat" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>1.003 - 1.031</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>BILIRUBIN</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="bilirubin" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>UROBILINOGEN</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="urobilinogen" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NITRIT</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="nitrit" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>KETON</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="keton" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>GLUCOSA</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="glucosa" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>BLOOD</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="blood" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>NEGATIF</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">

                        </td>
                    </tr>
                    <tr style="height: 50px;">
                        <td>Urine (Mikroskopis)</td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Leukosit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="leukosit_s" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Laki-laki = <5 /LPB </b><br>
                                    <b>Perempuan = <15 /LPB </b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Eritrosit</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="eritrosit_s" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>1 - 3 /LPB</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Ephitel</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="ephitel" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">

                            < 15
                                </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Silinder</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="silinder" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Negatif</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Kristal</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="kristal" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Negatif</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                        </td>
                    </tr>
                    <tr style="height: 20px;">
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Bakteri</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 350px;">
                            <b><textarea required type="text" class="form-control border border-secondary" name="bakteri" id=""></textarea></b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 300px;">
                            <b>Negatif</b>
                        </td>
                        <td class="border border-secondary p-3" style="width: 200px;">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-12 mt-4 border border-primary border-2 border-start-0 border-end-0 border-bottom-0 p-2 rounded-3 shadow-lg" style="background-color: whitesmoke;">
                <h4><b>6. Ekspertise Laboratorium</b></h4>
                <table class="w-100">
                    <tr style="height: 50px;">
                        <td style="width: 250px;">Kesan</td>
                        <td>
                            <textarea name="kesan_lab" placeholder="Kesan" class="form-control w-75" style="height: 100px;" id="">Hematologi : Dalam Batas Normal
Urine : Dalam Batas Normal</textarea>
                        </td>
                    </tr>
                    <tr style="height: 50px;">
                        <td style="width: 250px;">Saran</td>
                        <td>
                            <textarea name="saran_lab" placeholder="saran" class="form-control w-75" style="height: 100px;" id="">-</textarea>
                        </td>
                    </tr>
                    <tr style="height: 50px;">
                        <td style="width: 250px;">Dokter</td>
                        <td>
                            <input type="text" name="dokter_lab" class="form-control w-75" id="" value="Ratika Prikhastiani, Amd.AK">
                                </td>
                    </tr>
                </table>
            </div>
            <button type="submit" class="mt-4 btn w-100 btn-primary fs-4" onclick="return confirm('Selesaikan Pemeriksaan?')">Simpan Pemeriksaan</button>
        </form>

    </div>
</main>

<?php
include '../main/footer.php';
?>