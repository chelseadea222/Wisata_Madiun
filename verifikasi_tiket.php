<?php
require_once 'koneksi.php';
$id = $_GET['id'];

$query = "UPDATE pemesanan_tiket SET status='Lunas' WHERE id_transaksi='$id'";
if (mysqli_query($koneksi, $query)) {
    header("Location: dashboard_admin.php?pesan=berhasil");
}
?>