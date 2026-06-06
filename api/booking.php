<?php 
require_once __DIR__ . '/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Villa & Camp</title>
    <link rel="stylesheet" href="../css/booking.css">
</head>
<body>

<div class="container">
    <h2>Reservasi Penginapan</h2>
    <form action="proses_booking.php" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama sesuai KTP" required>
            </div>
            
            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <input type="text" name="no_hp" placeholder="Contoh: 08123456xxx" required>
            </div>

            <div class="form-group">
                <label>Tipe Penginapan</label>
                <select name="tipe_penginapan" id="tipe_penginapan" onchange="hitungTotal()" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Villa" data-harga="750000">Villa (Rp 750.000 /malam)</option>
                    <option value="Camp" data-harga="150000">Camp (Rp 150.000 /malam)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Check-in</label>
                <input type="date" name="tgl_checkin" required>
            </div>

            <div class="form-group">
                <label>Durasi (Malam)</label>
                <input type="number" name="durasi" id="durasi" min="1" value="1" oninput="hitungTotal()" required>
            </div>

            <div class="form-group full-width">
                <div class="price-box">
                    <span>Total Estimasi Bayar:</span><br>
                    <strong id="display_total">Rp 0</strong>
                    <input type="hidden" name="total_bayar" id="input_total_bayar">
                </div>
            </div>
        </div>

        <button type="submit" name="submit_booking">PESAN SEKARANG</button>
    </form> 
    
    <a href="landingpage.php" class="back-link">&larr; Kembali ke Beranda</a>
</div>

<script>
function hitungTotal() {
    const tipeSelect = document.getElementById('tipe_penginapan');
    const durasiInput = document.getElementById('durasi');
    const displayTotal = document.getElementById('display_total');
    const inputTotal = document.getElementById('input_total_bayar');

    const selectedOption = tipeSelect.options[tipeSelect.selectedIndex];
    const hargaPerMalam = selectedOption.getAttribute('data-harga') || 0;
    const durasi = durasiInput.value || 0;

    const total = parseInt(hargaPerMalam) * parseInt(durasi);

    displayTotal.innerText = "Rp " + total.toLocaleString('id-ID');
    inputTotal.value = total;
}
</script>
</body>
</html>