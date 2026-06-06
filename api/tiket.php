<?php
session_start();
require_once __DIR__ . '/koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BromoTrack - Logistik Perjalanan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/tiket.css">
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="glass-card">
                <div class="text-center mb-4">
                    <i class="bi bi-truck-flatbed fs-1 text-warning"></i>
                    <h2 class="fw-bold mt-2">Logistik Perjalanan Bromo</h2>
                    <p class="opacity-75 small">Dapatkan estimasi biaya, transportasi, dan waktu tempuh dari lokasi Anda secara instan.</p>
                </div>

                <div class="mb-4">
                    <label class="form-label label-custom mb-2">Kota / Kabupaten Asal:</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-white opacity-50"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" id="input_kota" class="form-control input-custom" placeholder="Contoh: Surabaya, Jakarta, Malang...">
                    </div>
                </div>

                <button class="btn btn-analisis w-100" onclick="hitungLogistik()">
                    Mulai Analisis <i class="bi bi-arrow-right ms-2"></i>
                </button>

                <div id="hasil_analisis" class="result-box">
                    <h5 class="text-warning fw-bold mb-4 d-flex align-items-center">
                        <i class="bi bi-clipboard-data me-2"></i> Hasil Analisis Logistik
                    </h5>
                    <div id="konten_hasil"></div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="landingpage.php" class="text-white-50 text-decoration-none small"><i class="bi bi-house me-1"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function hitungLogistik() {
    const kota = document.getElementById('input_kota').value.trim().toLowerCase();
    const boxHasil = document.getElementById('hasil_analisis');
    const konten = document.getElementById('konten_hasil');

    if (kota === "") {
        alert("Mohon masukkan kota asal terlebih dahulu!");
        return;
    }

    boxHasil.style.display = "block";
    let data = "";

    const createItem = (icon, title, text) => `
        <div class="logistik-item">
            <div class="icon-circle"><i class="bi bi-${icon}"></i></div>
            <div>
                <div class="label-custom small">${title}</div>
                <div class="text-light">${text}</div>
            </div>
        </div>
    `;

    if (kota.includes("probolinggo") || kota.includes("pasuruan") || kota.includes("malang") || kota.includes("lumajang")) {
        data += createItem("bicycle", "Rekomendasi Transportasi", "⚡ <b>Motor atau Mobil Pribadi</b>. Akses paling mudah melalui Sukapura atau Wonokitri.");
        data += createItem("cash-stack", "Estimasi Modal (Biaya)", "Sangat Hemat: Bensin ± Rp 25.000 - Rp 75.000.");
        data += createItem("clock-history", "Estimasi Waktu", "Dekat: 1 - 2 jam perjalanan darat.");
    } 
    else if (kota.includes("surabaya") || kota.includes("sidoarjo") || kota.includes("gresik") || kota.includes("mojokerto") || 
             kota.includes("jember") || kota.includes("situbondo") || kota.includes("kediri") || kota.includes("blitar") || 
             kota.includes("madiun") || kota.includes("banyuwangi") || kota.includes("tuban") || kota.includes("bojonegoro")) {
        data += createItem("car-front", "Rekomendasi Transportasi", "⚡ <b>Mobil Pribadi via Tol</b> atau 💰 <b>Kereta Api Lokal/Bus</b> menuju Stasiun Probolinggo.");
        data += createItem("cash-stack", "Estimasi Modal (Biaya)", "Menengah: ± Rp 150.000 - Rp 350.000 (Bensin/Tol/Tiket).");
        data += createItem("clock-history", "Estimasi Waktu", "Sekitar 3 - 5 jam perjalanan.");
    }
    else if (kota.includes("semarang") || kota.includes("solo") || kota.includes("surakarta") || kota.includes("jogja") || 
             kota.includes("yogyakarta") || kota.includes("klaten") || kota.includes("magelang") || kota.includes("tegal")) {
        data += createItem("train-front", "Rekomendasi Transportasi", "⚡ <b>Kereta Api Jarak Jauh</b> (Turun di Probolinggo/Malang) atau Mobil via Tol Trans Jawa.");
        data += createItem("cash-stack", "Estimasi Modal (Biaya)", "± Rp 400.000 - Rp 800.000 (Tiket Kereta/BBM & Tol).");
        data += createItem("clock-history", "Estimasi Waktu", "Sekitar 6 - 9 jam perjalanan.");
    }
    else if (kota.includes("jakarta") || kota.includes("bandung") || kota.includes("bekasi") || kota.includes("tangerang") || 
             kota.includes("bogor") || kota.includes("depok") || kota.includes("serang") || kota.includes("cimahi")) {
        data += createItem("airplane", "Rekomendasi Transportasi", "⚡ <b>Pesawat</b> (ke Surabaya) + Travel, atau 💰 <b>KA Eksekutif/Ekonomi</b>.");
        data += createItem("cash-stack", "Estimasi Modal (Biaya)", "± Rp 700.000 - Rp 1.800.000 (Menyesuaikan kelas transportasi).");
        data += createItem("clock-history", "Estimasi Waktu", "Udara: 1.5 jam | Darat: 12 - 15 jam.");
    }
    else {
        data += createItem("airplane-fill", "Rekomendasi Transportasi", "Wajib menggunakan <b>Pesawat Terbang</b> menuju Bandara Juanda (Surabaya) atau Abdul Rachman Saleh (Malang).");
        data += createItem("cash-stack", "Estimasi Modal (Biaya)", "Biaya Tiket Pesawat + Sewa Jeep Bromo (Menyesuaikan tarif maskapai).");
        data += createItem("clock-history", "Estimasi Waktu", "Udara: 2 - 5 jam (Tergantung lokasi asal). Disarankan tiba H-1.");
    }

    data += `
        <hr>
        <div class="mt-4 text-center">
            <p class="small text-white-50">Analisis berdasarkan jarak geografis kota <b>${kota.toUpperCase()}</b></p>
            <a href="beli_tiket.php" class="btn btn-primary rounded-pill w-100 py-3 fw-bold">
                Lanjut Pesan Tiket Wisata <i class="bi bi-ticket-perforated ms-2"></i>
            </a>
        </div>
    `;

    konten.innerHTML = data;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>