<?php
// GANTI BAGIAN INI DENGAN DATA DARI INFINITYFREE
$host = "sql301.infinityfree.com"; // Contoh: sql123.infinityfree.com atau sqlXXX.epizy.com
$user = "if0_42195880";            // Contoh: if0_12345678 atau epiz_12345678
$pass = "trvY9MTJ4etQ3";    // Password Control Panel (vPanel) Anda
$db   = "if0_42195880_madiun_tracking"; // Nama database selalu ada awalan username

// 1. KONEKSI UNTUK MYSQLI 
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi MySQLi gagal: " . mysqli_connect_error());
}

// 2. KONEKSI UNTUK PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Koneksi PDO gagal: " . $e->getMessage());
}
?>