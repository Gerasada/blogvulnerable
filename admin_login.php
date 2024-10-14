<?php

session_start();
include 'koneksi.php'; // pastikan koneksi.php berisi koneksi yang aman

if (isset($_POST['submit'])) {
    // Mengambil dan membersihkan input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah pengguna ada
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin'] = 1;
            header("Location: admin.php");
            exit();
        } else {
            die("Password salah!");
        }
    } else {
        die("Username tidak ditemukan!");
    }

    $stmt->close();
    $conn->close();
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>

    <h1 style="text-align: center">Login Admin</h1>
    <hr>

    <form action="" method="post">

        <p>Username:</p>
        <input type="text" name="username" required>

        <p>Password:</p>
        <input type="password" name="password" required>

        <br>
        <br>
        <input type="submit" name="submit" value="Login">

    </form>

</body>

</html>
