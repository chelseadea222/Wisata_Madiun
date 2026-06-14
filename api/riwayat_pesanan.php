<?php
require_once __DIR__ . '/koneksi.php';

// Jalankan kueri dan simpan hasilnya di variabel $result
$sql = "SELECT * FROM pemesanan_tiket ORDER BY id DESC";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - MadiunTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen p-4 lg:p-10">

<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-black text-slate-900">Riwayat Pemesanan</h2>
        <a href="beli_tiket.php" class="text-slate-500 hover:text-amber-500 transition font-bold text-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="space-y-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition hover:shadow-md">
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-slate-100 text-[10px] font-bold text-slate-500 px-2 py-1 rounded-lg uppercase">#<?= $row['id_transaksi'] ?></span>
                            <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded-lg uppercase"><?= $row['status'] ?></span>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg"><?= htmlspecialchars($row['nama_pembeli']) ?></h3>
                        <p class="text-sm text-slate-500 mt-1"><i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($row['destinasi']) ?></p>
                        <p class="text-xs text-slate-400 mt-2 font-medium"><?= date('d M Y, H:i', strtotime($row['tanggal_pesan'])) ?></p>
                    </div>

                    <div class="text-right border-t md:border-t-0 pt-4 md:pt-0 w-full md:w-auto">
                        <p class="text-[10px] uppercase font-bold text-slate-400">Total</p>
                        <strong class="text-xl text-slate-900 block font-black">Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></strong>
                        <p class="text-[10px] text-slate-400 mt-1"><?= $row['jumlah_orang'] ?> Orang</p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <i class="bi bi-ticket-perforated text-5xl text-slate-200"></i>
            <p class="text-slate-400 mt-4 font-medium">Belum ada riwayat pemesanan.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>