<?php
require_once __DIR__ . '/koneksi.php';

if (isset($_POST['submit_booking'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $tipe = $_POST['tipe_penginapan'];
    $tgl_in = $_POST['tgl_checkin'];
    $durasi = intval($_POST['durasi']);
    $total = intval($_POST['total_bayar']);

    $query = "INSERT INTO booking_penginapan (nama_lengkap, no_hp, tipe_penginapan, tgl_checkin, durasi, total_bayar) 
              VALUES ('$nama', '$no_hp', '$tipe', '$tgl_in', '$durasi', '$total')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Booking Berhasil!');
                window.location.href = 'riwayat_booking.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>