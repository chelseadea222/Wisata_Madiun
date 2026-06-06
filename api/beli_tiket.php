<?php 
require_once __DIR__ . '/koneksi.php'; 

// Data Destinasi Bromo Lengkap
$wisata_bromo = [
    ["nama" => "Penanjakan 1", "harga" => 220000],
    ["nama" => "Kawah Bromo", "harga" => 150000],
    ["nama" => "Pasir Berbisik", "harga" => 75000],
    ["nama" => "Bukit Teletubbies", "harga" => 50000],
    ["nama" => "Pura Luhur Poten", "harga" => 50000],
    ["nama" => "Bukit Kingkong", "harga" => 120000],
    ["nama" => "Bukit Cinta", "harga" => 100000],
    ["nama" => "Gunung Widodaren", "harga" => 100000],
    ["nama" => "Seruni Point", "harga" => 150000],
    ["nama" => "Padang Savana", "harga" => 50000],
    ["nama" => "Air Terjun Madakaripura", "harga" => 45000]
];

// Inisialisasi variabel untuk modal
$show_payment = false;
$id_transaksi = "";
$final_total = 0;
$nama_pembeli = "";
$metode_dipilih = "";

if (isset($_POST['bayar_tiket'])) {
    $nama_pembeli = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $jumlah_orang = (int)$_POST['jumlah'];
    $id_wisata_array = $_POST['id_wisata'] ?? [];
    $metode_dipilih = $_POST['metode_pembayaran'];

    if (!empty($id_wisata_array)) {
        $total_harga_per_orang = 0;
        $destinasi_pilihan = [];
        
        foreach ($id_wisata_array as $index) {
            $idx = $index - 1;
            $total_harga_per_orang += $wisata_bromo[$idx]['harga'];
            $destinasi_pilihan[] = $wisata_bromo[$idx]['nama'];
        }

        $final_total = $total_harga_per_orang * $jumlah_orang;
        $id_transaksi = "TRX-" . strtoupper(substr(md5(time()), 0, 8));
        $destinasi_str = implode(", ", $destinasi_pilihan);

        $query = "INSERT INTO pemesanan_tiket (id_transaksi, nama_pembeli, destinasi, jumlah_orang, total_bayar, status) 
                  VALUES ('$id_transaksi', '$nama_pembeli', '$destinasi_str', '$jumlah_orang', '$final_total', 'Menunggu Pembayaran')";
        
        if (mysqli_query($koneksi, $query)) {
            $show_payment = true; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket - BromoTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/beli_tiket.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="glass-card">
                <div class="text-center mb-5">
                    <i class="bi bi-ticket-perforated fs-1 text-warning"></i>
                    <h2 class="fw-bold mt-2">Pesan Tiket Wisata</h2>
                    <p class="opacity-75 small">Pilih destinasi favoritmu dan dapatkan E-Ticket instan.</p>
                </div>

                <form action="" method="POST">
                    <div class="mb-4">
                        <label class="label-custom"><i class="bi bi-person me-2"></i>Nama Pengunjung</label>
                        <input type="text" name="nama_pembeli" class="form-control input-custom" placeholder="Nama Lengkap Sesuai KTP" required>
                    </div>

                    <div class="mb-4">
                        <label class="label-custom"><i class="bi bi-geo-alt me-2"></i>Pilih Destinasi</label>
                        <div class="scroll-list">
                            <?php foreach($wisata_bromo as $index => $item): ?>
                            <div class="check-item">
                                <input type="checkbox" name="id_wisata[]" value="<?= $index + 1 ?>" data-harga="<?= $item['harga'] ?>" id="w<?= $index ?>" onchange="updatePrice()">
                                <label for="w<?= $index ?>" class="destinasi-label">
                                    <span><?= $item['nama'] ?></span>
                                    <span class="price-text">Rp<?= number_format($item['harga'], 0, ',', '.') ?></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="label-custom"><i class="bi bi-people me-2"></i>Jumlah Orang</label>
                            <input type="number" name="jumlah" id="jumlah" min="1" value="1" class="form-control input-custom" required oninput="updatePrice()">
                        </div>
                        <div class="col-md-6">
                            <label class="label-custom"><i class="bi bi-wallet2 me-2"></i>Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select input-custom" required>
                                <option value="" disabled selected>Pilih Metode</option>
                                <option value="DANA">DANA</option>
                                <option value="OVO">OVO</option>
                                <option value="BCA">BCA Virtual Account</option>
                                <option value="BNI">BNI Virtual Account</option>
                            </select>
                        </div>
                    </div>

                    <div class="total-box">
                        <span class="small opacity-75">Total Bayar:</span><br>
                        <h3 class="fw-bold mb-0" id="total_bayar_display" style="color: var(--accent);">Rp 0</h3>
                    </div>

                    <button type="submit" name="bayar_tiket" class="btn-pay">Konfirmasi Pemesanan <i class="bi bi-arrow-right ms-2"></i></button>
                </form>

                <div class="text-center mt-4">
                    <a href="landingpage.php" class="text-white-50 text-decoration-none small"><i class="bi bi-house me-1"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" style="display: <?= $show_payment ? 'flex' : 'none' ?>;">
    <div class="pay-card">
        <div class="pay-header">
            <h4 class="fw-bold mb-0 text-white">Selesaikan Pembayaran</h4>
            <small class="text-white-50">ID: <?= $id_transaksi ?></small>
        </div>
        <div class="pay-body">
            <p class="text-white-50 small mb-0">Total transfer (<?= $metode_dipilih ?>):</p>
            <div class="amount-display">Rp <?= number_format($final_total, 0, ',', '.') ?></div>
            
            <div class="bank-details text-white">
                <?php if(in_array($metode_dipilih, ['DANA', 'OVO', 'GOPAY'])): ?>
                    <label class="label-custom">Nomor E-Wallet:</label>
                    <h5 class="fw-bold">0812-3456-7890</h5>
                <?php else: ?>
                    <label class="label-custom">Virtual Account:</label>
                    <h5 class="fw-bold">8801 0812 3456 7890</h5>
                <?php endif; ?>
                <p class="small text-white-50 mt-2 mb-0">A/N BROMOTRACK INDONESIA</p>
            </div>

            <p class="small text-white-50">Status akan diverifikasi manual setelah Anda mengunggah bukti bayar.</p>
            <a href="konfirmasi_pembayaran.php?id=<?= $id_transaksi ?>" class="btn-done">SAYA SUDAH BAYAR</a>
        </div>
    </div>
</div>

<script>
function updatePrice() {
    const checkboxes = document.querySelectorAll('input[name="id_wisata[]"]:checked');
    const jumlahOrang = document.getElementById('jumlah').value || 1;
    const totalDisplay = document.getElementById('total_bayar_display');
    
    let totalHargaPerOrang = 0;
    checkboxes.forEach((cb) => {
        totalHargaPerOrang += parseInt(cb.getAttribute('data-harga'));
    });

    const totalAkhir = totalHargaPerOrang * jumlahOrang;
    totalDisplay.innerText = "Rp " + totalAkhir.toLocaleString('id-ID');
}
updatePrice();
</script>

</body>
</html>