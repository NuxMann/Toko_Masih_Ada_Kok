-- Idempotent Indonesian grocery-store sample catalog.
-- Import db_toko_online.sql first. Uses existing tb_barang columns only.
SET NAMES utf8mb4;

INSERT INTO tb_barang (nama_brg, keterangan, kategori, harga, stok, gambar)
SELECT seed.nama_brg, seed.keterangan, seed.kategori, seed.harga, seed.stok, seed.gambar
FROM (
    SELECT 'Beras Ramos 5 kg' nama_brg, 'Beras pulen kemasan 5 kg' keterangan, 'Sembako' kategori, 72000 harga, 35 stok, '0.jpg' gambar
    UNION ALL SELECT 'Minyak Goreng 2 L', 'Minyak goreng sawit kemasan 2 liter', 'Sembako', 36000, 28, '1.jpg'
    UNION ALL SELECT 'Gula Pasir 1 kg', 'Gula pasir putih kemasan 1 kg', 'Sembako', 17500, 42, '2.jpg'
    UNION ALL SELECT 'Mi Instan Goreng', 'Mi instan rasa original per bungkus', 'Sembako', 3500, 120, '4.png'
    UNION ALL SELECT 'Air Mineral 600 ml', 'Air mineral botol 600 ml', 'Minuman', 4000, 80, '5.jpg'
    UNION ALL SELECT 'Teh Kotak 250 ml', 'Minuman teh melati kotak 250 ml', 'Minuman', 5000, 48, '6.jpg'
    UNION ALL SELECT 'Kopi Bubuk', 'Kopi bubuk kemasan ekonomis', 'Minuman', 12000, 25, '7.jpg'
    UNION ALL SELECT 'Sabun Cuci Piring 750 ml', 'Sabun cuci piring lemon 750 ml', 'Perawatan Rumah', 16000, 22, '8.jpg'
    UNION ALL SELECT 'Deterjen Bubuk 1 kg', 'Deterjen bubuk untuk pakaian 1 kg', 'Perawatan Rumah', 21000, 18, '9.jpg'
    UNION ALL SELECT 'Keripik Singkong 100 g', 'Keripik singkong gurih kemasan 100 g', 'Snack', 10000, 30, '10.jpg'
    UNION ALL SELECT 'Biskuit Cokelat 120 g', 'Biskuit cokelat untuk camilan keluarga', 'Snack', 8500, 32, '11.jpg'
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM tb_barang existing WHERE existing.nama_brg = seed.nama_brg);

-- Repair sample image references when the existing dummy records are present.
UPDATE tb_barang SET gambar = CASE nama_brg
    WHEN 'Beras Ramos 5 kg' THEN '0.jpg'
    WHEN 'Minyak Goreng 2 L' THEN '1.jpg'
    WHEN 'Gula Pasir 1 kg' THEN '2.jpg'
    WHEN 'Mi Instan Goreng' THEN '4.png'
    WHEN 'Air Mineral 600 ml' THEN '5.jpg'
    WHEN 'Teh Kotak 250 ml' THEN '6.jpg'
    WHEN 'Kopi Bubuk' THEN '7.jpg'
    WHEN 'Sabun Cuci Piring 750 ml' THEN '8.jpg'
    WHEN 'Deterjen Bubuk 1 kg' THEN '9.jpg'
    WHEN 'Keripik Singkong 100 g' THEN '10.jpg'
    WHEN 'Biskuit Cokelat 120 g' THEN '11.jpg'
    ELSE gambar END
WHERE nama_brg IN ('Beras Ramos 5 kg','Minyak Goreng 2 L','Gula Pasir 1 kg','Mi Instan Goreng',
                   'Air Mineral 600 ml','Teh Kotak 250 ml','Kopi Bubuk','Sabun Cuci Piring 750 ml',
                   'Deterjen Bubuk 1 kg','Keripik Singkong 100 g','Biskuit Cokelat 120 g');
