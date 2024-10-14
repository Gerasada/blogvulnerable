<?php

session_start();
include 'koneksi.php';

if (isset($_GET['id'])) {
    // Validasi ID untuk memastikan hanya angka yang diterima
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
    if ($id === false) {
        die("ID tidak valid.");
    }

    // Menggunakan Prepared Statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT * FROM post WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika post ditemukan
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        die("Post tidak ditemukan.");
    }

    $stmt->close();
    $conn->close();
} else {
    die("ID tidak diberikan.");
}

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

    <h2><?php echo htmlspecialchars($post['judul'], ENT_QUOTES, 'UTF-8'); ?></h2>
    <small>Tanggal <?php echo htmlspecialchars($post['tanggal'], ENT_QUOTES, 'UTF-8'); ?></small>

    <p><?php echo nl2br(htmlspecialchars($post['konten'], ENT_QUOTES, 'UTF-8')); ?></p>

</body>

</html>
