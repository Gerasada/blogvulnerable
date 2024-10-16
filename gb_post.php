<?php

session_start();

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi dan sanitasi input pengguna
    $nama = htmlspecialchars(trim($_POST['nama']), ENT_QUOTES, 'UTF-8');
    $pesan = htmlspecialchars(trim($_POST['pesan']), ENT_QUOTES, 'UTF-8');

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("INSERT INTO guestbook (id, tanggal, nama, pesan) VALUES (NULL, NOW(), ?, ?)");
    $stmt->bind_param("ss", $nama, $pesan); // "ss" menunjukkan dua parameter string

    if ($stmt->execute()) {
        echo "Pesan Anda sudah disimpan.";
    } else {
        echo "Terjadi kesalahan, silakan coba lagi.";
    }

    $stmt->close();
    $conn->close();
}
?>
