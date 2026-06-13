<?php
session_start();
require_once __DIR__ . '/koneksi.php'; 

// Data Koordinat Destinasi di Madiun & Sekitarnya
$destinasi_madiun = [
    ["nama" => "Pahlawan Street Center (PSC)", "lat" => "-7.6273", "lon" => "111.5244"],
    ["nama" => "Taman Sumber Umis", "lat" => "-7.6268", "lon" => "111.5239"],
    ["nama" => "Alun-Alun Kota Madiun", "lat" => "-7.6293", "lon" => "111.5231"],
    ["nama" => "Taman Bantaran Kali Madiun", "lat" => "-7.6200", "lon" => "111.5180"],
    ["nama" => "Monumen Kresek", "lat" => "-7.6583", "lon" => "111.6038"],
    ["nama" => "Madiun Umbul Square", "lat" => "-7.7475", "lon" => "111.5306"],
    ["nama" => "Waduk Bening Widas", "lat" => "-7.5458", "lon" => "111.7833"],
    ["nama" => "Ngrowo Bening Edupark", "lat" => "-7.6433", "lon" => "111.5361"]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Rute & Estimasi Perjalanan - MadiunTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: '#0e7490',    
                        brandDark: '#083344', 
                        accent: '#ea580c',   
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <nav class="bg-white border-b border-slate-200 py-4 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="landingpage.php" class="text-brand font-bold flex items-center gap-2 hover:text-brandDark transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>
            <span class="text-xl font-black tracking-tight text-brandDark">
                MADIUN<span class="text-accent">TRACK</span>
            </span>
        </div>
    </nav>

    <header class="flex-grow flex items-center justify-center p-4 py-10">
        <div class="w-full max-w-4xl bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden flex flex-col md:flex-row">
            
            <div class="w-full md:w-5/12 bg-slate-50 p-8 border-r border-slate-100">
                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-brandDark mb-2">Navigasi Rute</h2>
                    <p class="text-slate-500 text-sm font-medium">Cari jalur terbaik ke lokasi wisata favoritmu.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Lokasi Awal (Rumah)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400"><i class="bi bi-house-door-fill"></i></span>
                            <input type="text" id="input_asal" placeholder="Ketik bebas: Dusun, Desa, Kota..." 
                                class="w-full bg-white border border-slate-200 rounded-xl py-3 pl-11 pr-4 font-semibold text-slate-700 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Destinasi Wisata</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400"><i class="bi bi-geo-alt-fill text-accent"></i></span>
                            <select id="input_tujuan" class="w-full bg-white border border-slate-200 rounded-xl py-3 pl-11 pr-10 font-semibold text-slate-700 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all appearance-none cursor-pointer shadow-sm">
                                <option value="" disabled selected>-- Pilih Lokasi --</option>
                                <?php foreach($destinasi_madiun as $dest): ?>
                                    <option value="<?= $dest['lat'] ?>,<?= $dest['lon'] ?>"><?= $dest['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 pointer-events-none"><i class="bi bi-chevron-down"></i></span>
                        </div>
                    </div>

                    <button id="btn-cek" onclick="hitungRute()" class="w-full bg-brand hover:bg-brandDark text-white font-bold py-3.5 rounded-xl shadow-lg shadow-brand/30 transition-all flex items-center justify-center gap-2 mt-4">
                        Tampilkan Peta Google <i class="bi bi-google"></i>
                    </button>
                </div>
                
                <div id="info_hasil" class="hidden mt-8 space-y-4">
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0"><i class="bi bi-google"></i></div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 leading-none">Rute Akurat Ditemukan!</h4>
                            <p class="text-xs font-semibold text-slate-500 mt-1">Cek peta di sebelah kanan 👉</p>
                        </div>
                    </div>
                    
                    <div class="bg-orange-50 p-4 rounded-xl border border-orange-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                            <img id="icon_cuaca" src="" alt="cuaca" class="w-8 h-8">
                        </div>
                        <div>
                            <h4 class="text-lg font-black text-brandDark leading-none" id="hasil_suhu">- °C</h4>
                            <p class="text-xs font-semibold text-accent mt-1 capitalize" id="hasil_cuaca_desc">Cuaca Tujuan</p>
                        </div>
                    </div>

                    <a id="btn-gmaps" href="#" target="_blank" class="w-full block text-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition-all mt-4 shadow-md text-sm">
                        <i class="bi bi-phone-fill mr-2"></i> Buka Navigasi di HP
                    </a>
                </div>
            </div>

            <div class="w-full md:w-7/12 relative min-h-[400px] md:min-h-full bg-slate-200">
                <div id="map" class="absolute inset-0 w-full h-full z-10"></div>
                
                <div id="pesan_awal" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100 z-20 text-slate-400">
                    <i class="bi bi-geo-alt text-6xl mb-3 opacity-50"></i>
                    <p class="font-bold">Google Maps Siap Digunakan</p>
                    <p class="text-xs">Masukkan lokasi Anda untuk melihat rute.</p>
                </div>
            </div>
        </div>
    </header>

    <script>
    async function hitungRute() {
        const asal = document.getElementById('input_asal').value.trim();
        const tujuanSelect = document.getElementById('input_tujuan');
        
        if (asal === "") { alert("Mohon ketik lokasi awal Anda!"); return; }
        if (tujuanSelect.value === "") { alert("Mohon pilih destinasi wisata!"); return; }

        const destNama = tujuanSelect.options[tujuanSelect.selectedIndex].text;
        const [destLat, destLon] = tujuanSelect.value.split(',');
        const btn = document.getElementById('btn-cek');
        const infoHasil = document.getElementById('info_hasil');
        
        btn.innerHTML = `<i class="bi bi-arrow-repeat animate-spin"></i> Memuat Google Maps...`;
        btn.disabled = true;

        try {
            document.getElementById('pesan_awal').style.display = 'none';

            // 1. EMBED GOOGLE MAPS ASLI
            const mapContainer = document.getElementById('map');
            const originQuery = encodeURIComponent(asal + ", Indonesia");
            const gmapsIframeUrl = `https://maps.google.com/maps?saddr=${originQuery}&daddr=${destLat},${destLon}&output=embed`;

            mapContainer.innerHTML = `<iframe width="100%" height="100%" frameborder="0" style="border:0;" src="${gmapsIframeUrl}" allowfullscreen></iframe>`;

            // 2. PERBAIKAN SISTEM CUACA (Lebih Kebal Error & Ada Fallback)
            let suhu = "30"; // Default estimasi suhu jika API mati
            let cuacaDesc = "Cerah Berawan (Estimasi)";
            let iconCuacaId = "02d"; // Default icon berawan

            try {
                const API_KEY = "c4752a971021db39a254799794cedd5b";
                const weatherRes = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${destLat}&lon=${destLon}&appid=${API_KEY}&units=metric&lang=id`);
                
                // Cek apakah API merespon dengan sukses (Status 200-299)
                if(weatherRes.ok) {
                    const weatherData = await weatherRes.json();
                    if(weatherData.main && weatherData.weather) {
                        suhu = Math.round(weatherData.main.temp);
                        cuacaDesc = weatherData.weather[0].description;
                        iconCuacaId = weatherData.weather[0].icon;
                    }
                } else {
                    console.warn("API Cuaca sedang limit/bermasalah. Menggunakan data cadangan.");
                }
            } catch (e) {
                console.warn("Gagal terhubung ke server cuaca: ", e.message);
            }

            // 3. Tampilkan Hasil Cuaca ke Layar
            document.getElementById('hasil_suhu').innerText = `${suhu} °C`;
            document.getElementById('hasil_cuaca_desc').innerText = cuacaDesc;
            document.getElementById('icon_cuaca').src = `https://openweathermap.org/img/wn/${iconCuacaId}.png`;
            
            // 4. Update Link untuk Tombol HP
            const gmapsAppUrl = `https://www.google.com/maps/dir/?api=1&origin=${originQuery}&destination=${destLat},${destLon}&travelmode=driving`;
            document.getElementById('btn-gmaps').href = gmapsAppUrl;
            
            infoHasil.classList.remove('hidden');

        } catch (error) {
            alert(error.message);
        } finally {
            btn.innerHTML = `Tampilkan Peta Google <i class="bi bi-google"></i>`;
            btn.disabled = false;
        }
    }
    </script>
</body>
</html>