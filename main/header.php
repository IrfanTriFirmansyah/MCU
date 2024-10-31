<?php

include "../conn/koneksi.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="../img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>MCU Cahaya Amalia</title>

	<link rel="stylesheet" href="../css/css/bootstrap.min.css">

	<link href="../css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />

	<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
	<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
	<script src="../js/js/bootstrap.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
	


	<style>
		.hidden {
			display: none;
		}
	</style>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="#">
					<span class="align-middle">Medical CheckUp</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Utama
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="../view/dashboard.php">
							<i class="align-middle" data-feather="database"></i> <span class="align-middle">Beranda</span>
						</a>
					</li>

					</li>

					<li class="sidebar-header">
						Pilihan Pemeriksaan
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="../view/pemeriksaan.php">
							<i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Pemeriksaan</span>
						</a>
					</li>

					<li class="sidebar-header">
						Pilihan Aksi
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="peserta.php">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">Peserta</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="daftar_peserta.php">
							<i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Pendaftaran</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="../view/download_data.php">
							<i class="align-middle" data-feather="download"></i> <span class="align-middle">Download Resume</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="../view/perusahaan.php">
							<i class="align-middle" data-feather="settings"></i> <span class="align-middle">Setting Perusahaan</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="../view/paket.php">
							<i class="align-middle" data-feather="settings"></i> <span class="align-middle">Setting Paket</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="../view/dokter.php">
							<i class="align-middle" data-feather="settings"></i> <span class="align-middle">Setting Dokter</span>
						</a>
					</li>

				</ul>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown"> <span class="text-dark">
									<i class="align-middle" data-feather="user"></i>
									<?php echo $_SESSION['nama']; ?>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="../proses/logout.php"><i class="align-middle" data-feather="log-out"></i> Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>





</body>

<script src="../js/app.js"></script>