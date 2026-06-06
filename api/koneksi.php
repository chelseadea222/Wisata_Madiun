<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bromo_tracking";

// 1. KONEKSI UNTUK MYSQLI (Digunakan di proses_rating, beli_tiket, dll)
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi MySQLi gagal: " . mysqli_connect_error());
}

// 2. KONEKSI UNTUK PDO (Digunakan di proses_login agar tidak error)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set error mode ke exception agar mudah dilacak jika ada salah typo nama tabel
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika PDO gagal, tampilkan pesan tapi jangan hentikan MySQLi jika sudah jalan
    error_log("Koneksi PDO gagal: " . $e->getMessage());
}
?>