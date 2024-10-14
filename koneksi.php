<?php

$host = "localhost";
$user = "blog2";
$pass = "blog2";
$db   = "blog2";

$conn = mysqli_connect($host, $user, $pass);
mysqli_select_db($conn, $db);
