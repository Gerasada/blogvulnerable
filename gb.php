<?php
session_start();
include 'koneksi.php';

// Menggunakan prepared statement untuk menghindari SQL Injection
$pesan_query = $conn->prepare("SELECT * FROM guestbook ORDER BY tanggal");
$pesan_query->execute();
$pesan = $pesan_query->get_result();

?><!DOCTYPE html>
<html lang="en">

<head>
	<title>Blog</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>
	
	<h1 style="text-align: center">My Blog</h1>
	<hr>
	
	<div style="text-align: center">
		<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) : ?>
		<a href="admin.php">Admin</a> | 
		<?php endif; ?>
		<a href="index.php">Home</a> | 
		<a href="gb.php">Guestbook</a>
	</div>
	
	<hr>
	
	<h2>Guestbook</h2>
	
	<?php
	
	while($row = $pesan->fetch_assoc()) {
		// Menghindari XSS dengan htmlspecialchars
		$nama = htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8');
		$pesan_text = htmlspecialchars($row['pesan'], ENT_QUOTES, 'UTF-8');
		$tanggal = htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8');
		
		echo "<small>Oleh <b>{$nama}</b> pada {$tanggal}</small>";
		echo "<p>{$pesan_text}</p>";
		echo "<hr>";
	}
	
	?>
	
	<h3>Kirim pesan</h3>
	
	<form action="gb_post.php" method="post">
		Nama: <input type="text" name="nama" required><br>
		Pesan: <br>
		<textarea name="pesan" cols="40" rows="5" required></textarea>
		<br>
		<input type="submit" value="Kirim">
	</form>
	
</body>

</html>
