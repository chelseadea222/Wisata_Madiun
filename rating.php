<?php 
/**
 * File: rating.php
 */
include 'koneksi.php';

// Ambil nama item dari URL, pastikan tidak kosong
$item = isset($_GET['item']) ? $_GET['item'] : '';

// Jika tidak ada item di URL, arahkan kembali ke index agar tidak error
if (empty($item)) {
    header("Location: landingpage.php");
    exit;
}

if(isset($_POST['submit'])) {
    // 1. Ambil data dan bersihkan (Security)
    $nama_wisata = mysqli_real_escape_string($koneksi, $_POST['nama_wisata']);
    $nama_user   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $rating      = (int)$_POST['rating'];
    $komentar    = mysqli_real_escape_string($koneksi, $_POST['komentar']);
    
    // 2. Query Insert - Pastikan kolom sesuai dengan tabel di database Anda
    // Asumsi nama kolom: nama_wisata, nama_user, rating, komentar, tanggal
    $query = "INSERT INTO ulasan (nama_wisata, nama_user, rating, komentar, tanggal) 
              VALUES ('$nama_wisata', '$nama_user', '$rating', '$komentar', NOW())";
    
    $insert = mysqli_query($koneksi, $query);
    
    if($insert) {
        // Redirect kembali ke halaman detail dengan item yang sama
        header("Location: informasi_destinasi.php?item=" . urlencode($nama_wisata));
        exit;
    } else {
        echo "<script>alert('Gagal mengirim ulasan: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Penilaian - <?= htmlspecialchars($item) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl w-full max-w-lg border border-slate-100">
        <div class="text-center mb-8">
            <div class="bg-orange-100 w-16 h-16 rounded-2xl flex items-center justify-center text-[#ea580c] text-3xl mx-auto mb-4">
                <i class="bi bi-star-fill"></i>
            </div>
            <h2 class="text-2xl font-black text-sky-950">Beri Penilaian</h2>
            <p class="text-slate-400 text-sm mt-1"><?= htmlspecialchars($item) ?></p>
        </div>

        <form action="" method="POST" class="space-y-5">
            <input type="hidden" name="nama_wisata" value="<?= htmlspecialchars($item) ?>">

            <div>
                <label class="block font-bold text-xs uppercase tracking-widest text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Masukkan nama Anda..." 
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-[#ea580c] focus:border-transparent outline-none transition">
            </div>

            <div>
                <label class="block font-bold text-xs uppercase tracking-widest text-slate-500 mb-2">Rating Bintang</label>
                <select name="rating" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-[#ea580c] outline-none cursor-pointer appearance-none">
                    <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                    <option value="4">⭐⭐⭐⭐ (Puas)</option>
                    <option value="3">⭐⭐⭐ (Cukup)</option>
                    <option value="2">⭐⭐ (Kurang Puas)</option>
                    <option value="1">⭐ (Buruk)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-xs uppercase tracking-widest text-slate-500 mb-2">Ulasan Anda</label>
                <textarea name="komentar" rows="4" required placeholder="Ceritakan pengalaman Anda di sini..." 
                          class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-[#ea580c] outline-none transition"></textarea>
            </div>

            <div class="pt-2">
                <button type="submit" name="submit" class="w-full bg-[#ea580c] hover:bg-[#c2410c] text-white font-black py-4 rounded-2xl shadow-lg shadow-orange-200 transition-all uppercase tracking-widest">
                    Kirim Penilaian
                </button>
                <a href="javascript:history.back()" class="block text-center text-slate-400 text-xs mt-6 font-bold uppercase tracking-tighter hover:text-slate-600 transition">
                    <i class="bi bi-arrow-left"></i> Kembali Tanpa Menilai
                </a>
            </div>
        </form>
    </div>

</body>
</html>