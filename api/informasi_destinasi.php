<?php
/**
 * File: informasi_destinasi.php
 */

include 'koneksi.php'; 

// 1. DAFTAR DATA MENTAH
$wisata_bromo = [
    ["nama" => "Penanjakan 1", "lokasi" => "Pasuruan", "img" => "https://i1-c.pinimg.com/736x/ac/60/f5/ac60f54e7b304d86ba95de24e7ee1c6f.jpg", "lat" => "-7.9261", "lon" => "112.9394", "desc" => "Titik tertinggi melihat matahari terbit dengan latar seluruh pegunungan Bromo yang ikonik."],
    ["nama" => "Kawah Bromo", "lokasi" => "Area Bromo", "img" => "https://hypeabis.id/assets/photo/20211202113902000000YudhaKartikaPratama082245153412MegahnyaKawahBromo.jpg", "lat" => "-7.9425", "lon" => "112.9530", "desc" => "Kawah aktif yang menakjubkan, bisa diakses dengan menaiki 250 anak tangga."],
    ["nama" => "Pasir Berbisik", "lokasi" => "Kaldera Bromo", "img" => "https://i1-c.pinimg.com/736x/fc/e9/44/fce944eaf1f21188f4b0c4da6d8b7025.jpg", "lat" => "-7.9304", "lon" => "112.9645", "desc" => "Hamparan lautan pasir luas yang mengeluarkan suara desis saat tertiup angin."],
    ["nama" => "Bukit Teletubbies", "lokasi" => "Savana Bromo", "img" => "https://i1-c.pinimg.com/736x/d4/5c/1e/d45c1e543df6189c76d981491a90be9b.jpg", "lat" => "-7.9610", "lon" => "112.9691", "desc" => "Bukit-bukit hijau yang cantik dan luas, mirip dengan pemandangan di film."],
    ["nama" => "Pura Luhur Poten", "lokasi" => "Lautan Pasir", "img" => "https://i1-c.pinimg.com/736x/cd/14/27/cd142726f1e1e74c75433961cad34c49.jpg", "lat" => "-7.9351", "lon" => "112.9515", "desc" => "Pura sakral tempat ibadah suku Tengger yang berdiri kokoh di tengah pasir."],
    ["nama" => "Bukit Kingkong", "lokasi" => "Pasuruan", "img" => "https://i1-c.pinimg.com/736x/d7/c5/75/d7c5753291cd9107159b772e7bda0ebe.jpg", "lat" => "-7.9212", "lon" => "112.9421", "desc" => "Spot sunrise alternatif yang menawarkan sudut pandang tebing yang unik."],
    ["nama" => "Bukit Cinta", "lokasi" => "Pasuruan", "img" => "https://i1-c.pinimg.com/736x/d1/5f/df/d15fdfaf936d915f634eabc0a082e7c6.jpg", "lat" => "-7.9250", "lon" => "112.9400", "desc" => "Love Hill, tempat romantis untuk menikmati pemandangan kaldera Bromo."],
    ["nama" => "Gunung Widodaren", "lokasi" => "Dekat Kawah", "img" => "https://i.pinimg.com/736x/c5/00/67/c500670b992fd00d635ddde1cbae3ca3.jpg", "lat" => "-7.9450", "lon" => "112.9500", "desc" => "Tebing batu yang megah, sering menjadi lokasi favorit foto bersama Jeep."],
    ["nama" => "Seruni Point", "lokasi" => "Probolinggo", "img" => "https://i1-c.pinimg.com/736x/2a/d1/90/2ad1900556e92f4820841c56806c9955.jpg", "lat" => "-7.9150", "lon" => "112.9550", "desc" => "Puncak penanjakan ke-2 yang diakses melalui tangga dari arah Probolinggo."],
    ["nama" => "Padang Savana", "lokasi" => "Selatan Bromo", "img" => "https://i1-c.pinimg.com/736x/7e/7d/31/7e7d316adcd2acbc880e9ecf434a0f40.jpg", "lat" => "-7.9650", "lon" => "112.9700", "desc" => "Padang rumput hijau yang memberikan sisi lembut dari alam liar Bromo."],
    ["nama" => "B-29 Argosari", "lokasi" => "Lumajang", "img" => "https://i1-c.pinimg.com/736x/8e/64/b0/8e64b009b8d96f2f8430c345c396aa9f.jpg", "lat" => "-8.0200", "lon" => "113.0000", "desc" => "Dikenal sebagai negeri di atas awan, melihat Bromo dari sisi timur."]
];

// 2. PROSES OTOMATIS MENJADI ARRAY KEY-VALUE
// ... array $wisata_bromo di sini ...

// 2. PROSES HARUS DI ATAS PENGAMBILAN NAMA_ITEM
$data_wisata_default = [];
foreach ($wisata_bromo as $w) {
    $data_wisata_default[$w['nama']] = [
        "lokasi"        => $w['lokasi'],
        "img"           => $w['img'],
        "telp"          => "08123456789",
        "kondisi_jalan" => "Kondisi akses jalan cukup bagus (Jeep & Motor).",
        "fasilitas"     => ["Musholla", "Toilet", "Warung"],
        "harga"         => 5000,
        "lat"           => $w['lat'],
        "lon"           => $w['lon']
    ];
}

// 3. AMBIL DATA BERDASARKAN URL
$nama_item = isset($_GET['item']) ? $_GET['item'] : 'Penanjakan 1';

// 4. MENGISI VARIABEL $detail
$detail = isset($data_wisata_default[$nama_item]) ? $data_wisata_default[$nama_item] : reset($data_wisata_default);
// 5. LOGIKA DATABASE: Statistik Rating (Tetap seperti kode Anda)
$query_stats = mysqli_query($koneksi, "SELECT 
    AVG(rating) as rata_rata, 
    COUNT(*) as total,
    COUNT(IF(rating = 5, 1, NULL)) as b5,
    COUNT(IF(rating = 4, 1, NULL)) as b4,
    COUNT(IF(rating = 3, 1, NULL)) as b3,
    COUNT(IF(rating = 2, 1, NULL)) as b2,
    COUNT(IF(rating = 1, 1, NULL)) as b1
    FROM ulasan WHERE nama_wisata = '$nama_item'");

$stats = mysqli_fetch_assoc($query_stats);
$rating_rata = round($stats['rata_rata'], 1) ?: 0;
$total_ulasan = $stats['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail - <?= htmlspecialchars($nama_item) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Plus Jakarta Sans', sans-serif; } 
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800">

    <nav class="p-6">
        <a href="landingpage.php" class="text-sky-600 font-bold flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 items-start">
            <img src="<?= $detail['img'] ?>" class="w-full h-[450px] object-cover rounded-3xl shadow-xl" alt="<?= $nama_item ?>">
            <div class="flex flex-col">
                <h1 class="text-5xl font-extrabold text-sky-950 mb-4"><?= htmlspecialchars($nama_item) ?></h1>
                <p class="text-slate-600 mb-8 text-lg leading-relaxed">
                    Untuk menemukan <?= htmlspecialchars($nama_item) ?>, Anda dapat mencari di peta dengan kata kunci tersebut. Jika Anda menggunakan aplikasi peta seperti Google Maps, lokasi akan muncul di wilayah Kabupaten Madiun/Pasuruan.
                </p>
                <div class="space-y-3 mb-8">
                    <div class="flex items-center text-sky-700 font-bold"><i class="bi bi-geo-alt-fill mr-3"></i> <?= $detail['lokasi'] ?></div>
                    <div class="flex items-center text-slate-600"><i class="bi bi-telephone-fill mr-3"></i> <?= $detail['telp'] ?></div>
                    <button class="bg-[#0e5e6f] hover:bg-sky-900 text-white px-8 py-3 rounded-xl flex items-center gap-3 shadow-lg w-fit transition-all mt-4">
                        <i class="bi bi-badge-vr-fill"></i> Lihat Tur Virtual 360°
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-8 border-t pt-8 border-slate-200">
                    <div>
                        <h4 class="font-bold text-sky-900 text-lg mb-2 text-sky-900">Kondisi Jalan</h4>
                        <p class="text-sm text-slate-500 leading-relaxed"><?= $detail['kondisi_jalan'] ?></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sky-900 text-lg mb-2 text-sky-900">Fasilitas Wisata</h4>
                        <ul class="text-sm text-slate-500 space-y-1">
                            <?php foreach($detail['fasilitas'] as $f): ?>
                                <li class="flex items-center gap-2 font-medium">• <?= $f ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-10 shadow-md border border-slate-100">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 pb-8 border-b border-slate-100">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <p class="text-orange-400 font-bold uppercase tracking-widest text-xs mb-2">Penilaian Produk</p>
                    <div class="flex items-center gap-5">
                        <div class="flex flex-col items-center">
                            <span class="text-7xl font-black text-sky-950 leading-none"><?= $rating_rata ?></span>
                            <span class="text-slate-400 font-bold text-lg">/ 5</span>
                        </div>
                        <div class="h-16 w-px bg-slate-100 hidden md:block"></div> 
                        <div>
                            <div class="text-orange-400 text-2xl flex gap-1 mb-1">
                                <?php for($i=1; $i<=5; $i++) echo ($i <= round($rating_rata)) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
                            </div>
                            <p class="text-slate-500 font-medium"><?= $total_ulasan ?> Penilaian Asli</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col items-center md:items-end gap-4">
                    <div class="flex flex-wrap gap-2 justify-center md:justify-end" id="filter-container">
                        <button onclick="filterRating('semua', this)" class="filter-btn bg-[#ea580c] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition">Semua</button>
                        <button onclick="filterRating(5, this)" class="filter-btn bg-slate-50 text-slate-600 px-5 py-2.5 rounded-xl font-bold border border-slate-200 hover:bg-white transition text-sm">5 Bintang (<?= $stats['b5'] ?>)</button>
                        <button onclick="filterRating(4, this)" class="filter-btn bg-slate-50 text-slate-600 px-5 py-2.5 rounded-xl font-bold border border-slate-200 hover:bg-white transition text-sm">4 Bintang (<?= $stats['b4'] ?>)</button>
                        <button onclick="filterRating(3, this)" class="filter-btn bg-slate-50 text-slate-600 px-5 py-2.5 rounded-xl font-bold border border-slate-200 hover:bg-white transition text-sm">3 Bintang (<?= $stats['b3'] ?>)</button>
                        <button onclick="filterRating(2, this)" class="filter-btn bg-slate-50 text-slate-600 px-5 py-2.5 rounded-xl font-bold border border-slate-200 hover:bg-white transition text-sm">2 Bintang (<?= $stats['b2'] ?>)</button>
                        <button onclick="filterRating(1, this)" class="filter-btn bg-slate-50 text-slate-600 px-5 py-2.5 rounded-xl font-bold border border-slate-200 hover:bg-white transition text-sm">1 Bintang (<?= $stats['b1'] ?>)</button>
                    </div>
                    <a href="rating.php?item=<?= urlencode($nama_item) ?>" class="bg-sky-50 text-sky-600 px-6 py-2 rounded-full font-bold text-xs hover:bg-sky-600 hover:text-white transition-all flex items-center gap-2 border border-sky-100">
                        <i class="bi bi-pencil-fill"></i> Berikan Penilaian
                    </a>
                </div>
            </div>

            <div id="daftar-ulasan" class="space-y-6 min-h-[200px]">
                <div class="flex justify-center py-20">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-[#ea580c]"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // --- 1. LOGIKA API CUACA ---
    const BROMO_LAT = '<?= $detail["lat"] ?>';
    const BROMO_LON = '<?= $detail["lon"] ?>';
    const WEATHER_KEY = 'c4752a971021db39a254799794cedd5b'; 

    async function fetchWeather() {
    const tabs = document.getElementById('weather-tabs');
    const main = document.getElementById('weather-main');
    
    // Ganti API KEY dengan yang baru ini
    const NEW_KEY = 'c4752a971021db39a254799794cedd5b'; 

    try {
        const response = await fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${BROMO_LAT}&lon=${BROMO_LON}&appid=${NEW_KEY}&units=metric&lang=id`);
        
        // Cek jika statusnya bukan 200 (OK)
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message); 
        }

        const data = await response.json();
        const weatherData = data.list.filter((_, index) => index % 8 === 0);
        
        tabs.innerHTML = '';
        weatherData.forEach((day, index) => {
            const date = new Date(day.dt * 1000);
            const btn = document.createElement('button');
            btn.className = `weather-btn px-6 py-2 rounded-xl font-bold transition-all border border-white/10 ${index === 0 ? 'bg-white text-[#0e5e6f]' : 'text-white hover:bg-white/10'}`;
            btn.innerText = date.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric' });
            btn.onclick = () => showWeatherDetail(weatherData, index);
            tabs.appendChild(btn);
        });
        showWeatherDetail(weatherData, 0);

    } catch (e) {
        console.error("LOG ERROR CUACA:", e.message); // Cek F12 untuk melihat ini
        main.innerHTML = `<p class='opacity-50 italic'>Gagal: ${e.message}</p>`;
    }
}

    function showWeatherDetail(list, index) {
        const data = list[index];
        const main = document.getElementById('weather-main');
        const details = document.getElementById('weather-details');
        document.querySelectorAll('.weather-btn').forEach((b, i) => {
            if(i === index) b.className = "weather-btn px-6 py-2 rounded-xl font-bold transition-all border border-white/10 bg-white text-[#0e5e6f]";
            else b.className = "weather-btn px-6 py-2 rounded-xl font-bold transition-all border border-white/10 text-white hover:bg-white/10";
        });
        const icon = `https://openweathermap.org/img/wn/${data.weather[0].icon}@4x.png`;
        main.innerHTML = `<img src="${icon}" class="w-32 h-32"><div class="text-7xl font-black">${Math.round(data.main.temp)}°C</div><p class="mt-4 text-xl font-medium">Terasa seperti ${Math.round(data.main.feels_like)}°C | <span class="capitalize">${data.weather[0].description}</span></p>`;
        details.innerHTML = `<div><i class="bi bi-wind text-xl mb-1 block"></i><p>${data.wind.speed} km/h</p></div><div><i class="bi bi-speedometer text-xl mb-1 block"></i><p>${data.main.pressure} hPa</p></div><div><i class="bi bi-droplets text-xl mb-1 block"></i><p>${data.main.humidity}%</p></div><div><i class="bi bi-eye text-xl mb-1 block"></i><p>${(data.visibility/1000).toFixed(1)} km</p></div>`;
    }

    // --- 2. LOGIKA FILTER RATING (AJAX) ---
    async function filterRating(star, btn) {
        const container = document.getElementById('daftar-ulasan');
        const namaWisata = '<?= addslashes($nama_item) ?>';
        
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-[#ea580c]', 'text-white', 'shadow-md');
            b.classList.add('bg-slate-50', 'text-slate-600', 'border-slate-200');
        });
        btn.classList.remove('bg-slate-50', 'text-slate-600', 'border-slate-200');
        btn.classList.add('bg-[#ea580c]', 'text-white', 'shadow-md');

        container.innerHTML = `<div class="flex justify-center py-20"><div class="animate-spin rounded-full h-10 w-10 border-b-2 border-[#ea580c]"></div></div>`;

        try {
            const response = await fetch(`get_ulasan.php?wisata=${encodeURIComponent(namaWisata)}&rating=${star}`);
            if (!response.ok) throw new Error("File get_ulasan.php tidak ditemukan!");
            const html = await response.text();
            container.innerHTML = html;
        } catch (e) {
            container.innerHTML = `<div class="text-center py-10 text-red-500"><i class="bi bi-exclamation-circle"></i> Gagal memuat ulasan.</div>`;
        }
    }

    // --- INISIALISASI ---
    document.addEventListener("DOMContentLoaded", () => {
        fetchWeather();
        const btnSemua = document.querySelector('.filter-btn');
        if(btnSemua) btnSemua.click();
    });
    </script>
</body>
</html>