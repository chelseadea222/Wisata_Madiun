<?php
session_start();
require_once __DIR__ . '/koneksi.php';

if (isset($_POST['bayar_tiket'])) {
    $nama_pembeli = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $jumlah_orang = intval($_POST['jumlah']);
    
    if (!isset($_POST['id_wisata']) || empty($_POST['id_wisata'])) {
        echo "<script>alert('Pilih minimal satu destinasi!'); window.history.back();</script>";
        exit;
    }
    
    $daftar_id_wisata = $_POST['id_wisata']; 

    $harga_list = [
        "1" => ["nama" => "Penanjakan 1", "harga" => 220000],
        "2" => ["nama" => "Kawah Bromo", "harga" => 150000],
        "3" => ["nama" => "Pasir Berbisik", "harga" => 75000],
        "4" => ["nama" => "Bukit Teletubbies", "harga" => 50000],
        "5" => ["nama" => "Pura Luhur Poten", "harga" => 50000],
        "6" => ["nama" => "Bukit Kingkong", "harga" => 120000],
        "7" => ["nama" => "Bukit Cinta", "harga" => 100000],
        "8" => ["nama" => "Gunung Widodaren", "harga" => 100000],
        "9" => ["nama" => "Seruni Point", "harga" => 150000],
        "10" => ["nama" => "Padang Savana", "harga" => 50000],
        "11" => ["nama" => "Air Terjun Madakaripura", "harga" => 45000]
    ];

    $total_per_orang = 0;
    $nama_dipilih = [];

    foreach ($daftar_id_wisata as $id) {
        if (isset($harga_list[$id])) {
            $total_per_orang += $harga_list[$id]['harga'];
            $nama_dipilih[] = $harga_list[$id]['nama'];
        }
    }

    $total_bayar = $total_per_orang * $jumlah_orang;
    $destinasi_final = implode(", ", $nama_dipilih); 
    $tanggal = date('Y-m-d H:i:s');

    $query = "INSERT INTO pemesanan_tiket (nama_pembeli, destinasi, jumlah_orang, total_bayar, tanggal_pesan) 
              VALUES ('$nama_pembeli', '$destinasi_final', '$jumlah_orang', '$total_bayar', '$tanggal')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Pemesanan Berhasil!');
                // Karena riwayat_pemesanan.php ada di folder yang sama (api)
                window.location.href = 'riwayat_pesanan.php'; 
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>