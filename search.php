<?php

session_start();
include 'koneksi.php';

if (isset($_GET['q'])) {
    // Membersihkan input untuk mencegah SQL Injection dan XSS
    $q = htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8');

    // Menggunakan Prepared Statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("SELECT * FROM post WHERE judul LIKE ? OR konten LIKE ?");
    $searchTerm = "%" . $q . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $posts = $stmt->get_result();
} else {
    die("Parameter pencarian tidak diberikan.");
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

    <h3>Hasil pencarian untuk "<?php echo $q; ?>"</h3>

    <?php echo mysqli_num_rows($posts); ?> hasil

    <hr>

    <?php
    // Menampilkan hasil pencarian
    while ($row = mysqli_fetch_array($posts)) {
        // Escaping output untuk menghindari XSS
        echo "<a href='post.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'><h2>" . htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8') . "</h2></a>";
        echo "<small>Tanggal " . htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8') . "</small>";
        echo "<hr>";
    }

    $stmt->close();
    $conn->close();
    ?>

</body>

</html>
