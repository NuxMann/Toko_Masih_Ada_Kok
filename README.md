# 🛒 Toko Masih Ada Kok

<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Plus+Jakarta+Sans&weight=700&size=24&duration=2600&pause=900&color=2563EB&center=true&vCenter=true&width=640&lines=Toko+Masih+Ada+Kok+%F0%9F%9B%92;Katalog+%E2%80%A2+Kategori+%E2%80%A2+Keranjang+%E2%80%A2+Checkout;CodeIgniter+3+%2B+MySQL+(Laragon)" alt="Toko Masih Ada Kok Animated Banner" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Framework-CodeIgniter%203-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white" alt="CodeIgniter 3" />
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+" />
  <img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Midtrans%20Gateway-Belum%20Aktif-F59E0B?style=for-the-badge" alt="Midtrans Belum Aktif" />
</p>

Aplikasi web **Toko Online / Toko Kelontong** berbasis **CodeIgniter 3** dan **MySQL** untuk menampilkan daftar produk per kategori, halaman detail produk, pengelolaan keranjang belanja, serta alur checkout/pembayaran di lingkungan pengembangan lokal[cite: 1, 3, 9].

> **Catatan Status Pembayaran:** Integrasi **Midtrans Payment Gateway asli belum diaktifkan/dihubungkan** pada proyek ini (alur pembayaran masih berjalan sebagai alur/simulasi lokal dan memerlukan konfigurasi *Server Key*, *Client Key*, serta endpoint callback Midtrans sebelum dipakai secara penuh).

---

## 📊 Grafis Alur Aplikasi & Arsitektur

```mermaid
flowchart LR
    A[("🌐 Browser<br/>localhost:8080")] -->|HTTP Request| B["⚙️ CodeIgniter 3<br/>Controllers & Views"]
    B -->|Query / CRUD| C[("🗄️ MySQL<br/>db_toko_online")]
    B -->|Load Assets| D["🖼️ Folder uploads/ & img/"]
    B -.->|Belum Terhubung| E["💳 Midtrans Gateway<br/>(Belum Diaktifkan)"]

sequenceDiagram
    actor User as 👤 Pengguna
    participant Web as 🖥️ Toko Masih Ada Kok (CI3)
    participant DB as 🗄️ MySQL

    User->>Web: Buka Dashboard & Pilih Kategori
    Web->>DB: Ambil data kategori & produk
    DB-->>Web: Kirim data produk + nama file gambar
    Web-->>User: Tampilkan grid kategori & card produk
    User->>Web: Buka Detail -> Tambah ke Keranjang
    Web-->>User: Perbarui jumlah item & subtotal keranjang
    User->>Web: Klik Pembayaran / Checkout
    Web-->>User: Tampilkan halaman pembayaran lokal (Midtrans asli belum aktif)

git clone [https://github.com/NuxMann/Toko_Masih_Ada_Kok.git](https://github.com/NuxMann/Toko_Masih_Ada_Kok.git)
cd Toko_Masih_Ada_Kok

flowchart TD
    S1["1. Jalankan MySQL di Laragon<br/>(Port 3306)"] --> S2["2. Import Database_MySQL/db_toko_online.sql<br/>via phpMyAdmin atau MySQL CLI"]
    S2 --> S3["3. Atur Koneksi di<br/>application/config/database.php"]
    S3 --> S4["4. Verifikasi Data Dummy &<br/>Gambar di Folder uploads/"]
