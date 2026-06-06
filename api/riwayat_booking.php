<?php
require_once __DIR__ . '/koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM booking_penginapan ORDER BY id_booking DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Booking</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 15px; border-left: 5px solid #27ae60; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .status { color: #27ae60; font-weight: bold; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Riwayat Booking Penginapan</h2>
    <div style="max-width:600px; margin:auto;">
        <?php while($row = mysqli_fetch_assoc($query)): ?>
        <div class="card">
            <small>ID: #BOOK-<?= $row['id_booking'] ?></small>
            <h3><?= htmlspecialchars($row['nama_lengkap']) ?></h3>
            <p><strong>Tipe:</strong> <?= $row['tipe_penginapan'] ?> (<?= $row['durasi'] ?> Malam)</p>
            <p><strong>Check-in:</strong> <?= date('d M Y', strtotime($row['tgl_checkin'])) ?></p>
            <p><strong>Total:</strong> Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></p>
            <span class="status">● Terkonfirmasi</span>
        </div>
        <?php endwhile; ?>
        <a href="booking.php" style="display:block; text-align:center;">Kembali Pesan</a>
    </div>
</body>
</html>