<?php

session_start();
include 'koneksi.php';

// Menggunakan Prepared Statement untuk mencegah SQL Injection
$stmt = $conn->prepare("SELECT * FROM post");
$stmt->execute();
$posts = $stmt->get_result();

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

    <form action="search.php" method="get">
        Cari posting:
        <input type="text" name="q" required>
        <input type="submit" value="Cari">
    </form>

    <hr>

    <?php
    // Menampilkan daftar posting dengan escaping output untuk mencegah XSS
    while ($row = mysqli_fetch_array($posts)) {
        echo "<a href='post.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'><h2>" . htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8') . "</h2></a>";
        echo "<small>Tanggal " . htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8') . "</small>";
        echo "<hr>";
    }

    $stmt->close();
    $conn->close();
    ?>

</body>

</html>
