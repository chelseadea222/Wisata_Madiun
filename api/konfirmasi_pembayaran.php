<?php
require_once 'koneksi.php';

if (isset($_POST['upload_bukti'])) {
    $id_trx = mysqli_real_escape_string($koneksi, $_POST['id_transaksi']);
    $foto = $_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];
    
    // Pastikan folder uploads sudah ada
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }
    
    // Penamaan file unik
    $ekstensi = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_baru = "BUKTI_" . $id_trx . "_" . time() . "." . $ekstensi;
    $path = "uploads/" . $nama_baru;
    
    if (move_uploaded_file($tmp, $path)) {
        $query = "UPDATE pemesanan_tiket SET bukti_pembayaran='$nama_baru', status='Diproses' WHERE id_transaksi='$id_trx'";
        if (mysqli_query($koneksi, $query)) {
            header("Location: konfirmasi_pembayaran.php?pesan=berhasil");
            exit;
        } else {
            echo "<script>alert('Gagal memperbarui data di sistem.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 h-screen flex flex-col">

    <header class="h-16 flex-none bg-white border-b border-slate-200 px-6 flex items-center shadow-sm z-20">
        <button onclick="history.back()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
            <i class="bi bi-chevron-left"></i>
        </button>
        <h1 class="ml-4 font-bold text-slate-800 text-sm tracking-wide uppercase">Verifikasi Pembayaran</h1>
    </header>

    <main class="flex-1 flex items-center justify-center p-4">
        
        <div class="bg-white w-full max-w-4xl max-h-[80vh] rounded-3xl shadow-lg flex flex-col lg:flex-row overflow-hidden border border-slate-200">
            
            <div class="bg-slate-900 lg:w-1/3 p-8 text-white flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-black">Konfirmasi</h2>
                    <p class="text-slate-400 text-xs mt-2 leading-relaxed">Pastikan data sesuai dengan bukti transfer Anda.</p>
                </div>
                <div class="hidden lg:block space-y-4">
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300 italic">
                        "Verifikasi akan dilakukan admin dalam 1x24 jam."
                    </div>
                </div>
            </div>

            <div class="flex-1 p-8 overflow-y-auto">
                <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">ID Transaksi</label>
                        <div class="bg-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-600 border border-slate-200">
                            <?= htmlspecialchars($_GET['id'] ?? 'TRX-XXXXXX') ?>
                        </div>
                        <input type="hidden" name="id_transaksi" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2">Unggah Bukti</label>
                        <label for="buktiInput" class="h-40 w-full border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-all">
                            <div id="uploadPrompt" class="text-center">
                                <i class="bi bi-image text-2xl text-slate-300"></i>
                                <p class="text-[10px] text-slate-400 mt-1">Klik untuk pilih gambar</p>
                            </div>
                            <img id="previewImg" class="hidden h-full object-contain p-2">
                        </label>
                        <input type="file" name="bukti" id="buktiInput" accept="image/*" class="hidden" required>
                    </div>

                    <button type="submit" name="upload_bukti" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl text-sm transition-all shadow-lg shadow-amber-500/20 active:scale-95">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        const input = document.getElementById('buktiInput');
        const preview = document.getElementById('previewImg');
        const prompt = document.getElementById('uploadPrompt');

        input.onchange = e => {
            const [file] = input.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                prompt.classList.add('hidden');
            }
        }
    </script>
</body>
</html>