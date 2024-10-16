<?php

session_start();

// Hapus semua variabel sesi
$_SESSION = [];

// Hapus cookie sesi jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hentikan sesi
session_destroy();

// Regenerasi session ID untuk keamanan tambahan
session_regenerate_id(true);

// Pesan logout dan redirect ke halaman login
echo "Anda sudah logout. Mengarahkan ke halaman login...";
header("Refresh: 2; url=admin_login.php");
exit;
