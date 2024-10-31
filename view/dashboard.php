<?php
session_start();
if ($_SESSION['status'] != "login") {
	header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';
?>

<main class="content">
	<div class="container-fluid p-0">
		<h1 style="font-size: 30px;">Selamat Datang di Aplikasi,</h1>
		<h1 style="font-size: 40px; font-weight: bold;">Medical CheckUp Klinik Cahaya Amalia</h1>	
	</div>
</main>


<?php
include '../main/footer.php';
?>