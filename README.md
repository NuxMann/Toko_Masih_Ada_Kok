# 🛒 Toko Masih Ada Kok

Aplikasi web **Toko Online / Toko Kelontong** berbasis **CodeIgniter 3** dan **MySQL** yang dirancang untuk menampilkan katalog produk per kategori, detail produk, keranjang belanja, serta alur checkout/pembayaran di lingkungan pengembangan lokal.

> **Catatan Status Pembayaran:** Integrasi **Midtrans Payment Gateway asli belum diaktifkan/dihubungkan** pada proyek ini (alur pembayaran masih berupa alur/simulasi lokal dan memerlukan konfigurasi kredensial *Server Key* & *Client Key* Midtrans sebelum digunakan secara penuh).

---

## ✨ Fitur Utama

* **Branding & Identitas Toko:** Menggunakan nama **Toko Masih Ada Kok** pada judul halaman, navigasi, dan identitas antarmuka.
* **Navigasi & Grid Kategori:** Penelusuran produk berdasarkan kategori (seperti *Elektronik*, *Pakaian Pria*, *Pakaian Wanita*, *Pakaian Anak*, dan *Peralatan Olahraga*) baik dari menu maupun grid kategori.
* **Detail Produk & Keranjang Belanja:** Melihat informasi produk, menambah item ke keranjang, menghitung subtotal & total belanja, serta navigasi kembali atau lanjutkan belanja.
* **Alur Checkout & Pembayaran:** Proses checkout pesanan dengan struktur yang disiapkan untuk pengembangan integrasi *payment gateway*.

---

## 🛠️ Stack & Lingkungan Pengembangan

* **Framework:** CodeIgniter 3
* **Bahasa:** PHP 8.1+ (diuji menggunakan PHP 8.1.10 di Laragon)
* **Database:** MySQL / MariaDB (`Database_MySQL/db_toko_online.sql`)
* **Web Server Lokal:** Laragon (Apache / MySQL) atau PHP Built-in Server

---

## 📁 Struktur Folder Utama

```text
toko_kelontong/
├── application/        # Controllers, Models, Views, dan Config CodeIgniter 3
├── Database_MySQL/     # Berisi file SQL (db_toko_online.sql)
├── img/                # Aset gambar antarmuka/banner
├── uploads/            # File gambar produk yang diunggah/digunakan katalog
└── index.php           # Entry point aplikasi
