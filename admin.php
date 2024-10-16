<?php

session_start();

// Cek apakah user sudah login dan merupakan admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 1) {
	header("Location: admin_login.php");
	exit;
}

// Batasi waktu sesi agar expired setelah periode inaktivitas
$timeout_duration = 1800; // 30 menit

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    // Jika sesi sudah terlalu lama tidak aktif, lakukan logout
    session_unset();     
    session_destroy();   
    header("Location: admin_login.php");
    exit;
}

$_SESSION['LAST_ACTIVITY'] = time(); // Perbarui waktu aktivitas terakhir

?><!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Page</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>
	
	<h1 style="text-align: center">My Blog</h1>
	<hr>
	
	<div style="text-align: center">
		<a href="admin_logout.php">Logout</a>
	</div>
	
	<hr>	
	
	<h3>Halaman administrasi blog</h3>
	
	<p>Coming soon...</p>
	
</body>

</html>
