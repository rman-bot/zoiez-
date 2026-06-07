# 📄 Product Requirements Document (PRD)

## Sistem Inventaris Sparepart Bengkel Berbasis Web
### Studi Kasus: Zoiez Motor

---

| Informasi Dokumen | Detail |
|---|---|
| **Nama Dokumen** | Product Requirements Document (PRD) |
| **Nama Sistem** | Sistem Inventaris Sparepart Bengkel Berbasis Web |
| **Studi Kasus** | Zoiez Motor (UMKM Bengkel Motor) |
| **Versi** | 1.0.0 |
| **Tanggal Dibuat** | Juni 2026 |
| **Status** | Final |

---

## 📋 DAFTAR ISI

1. [Latar Belakang](#1-latar-belakang)
2. [Tujuan Sistem](#2-tujuan-sistem)
3. [Ruang Lingkup](#3-ruang-lingkup)
4. [Pengguna Sistem](#4-pengguna-sistem)
5. [Kebutuhan Fungsional](#5-kebutuhan-fungsional)
6. [Kebutuhan Non-Fungsional](#6-kebutuhan-non-fungsional)
7. [Use Case](#7-use-case)
8. [Alur Sistem (Flow)](#8-alur-sistem-flow)
9. [Desain Database (ERD)](#9-desain-database-erd)
10. [Spesifikasi Teknologi](#10-spesifikasi-teknologi)
11. [Desain UI/UX](#11-desain-uiux)
12. [Batasan Sistem](#12-batasan-sistem)
13. [Kriteria Keberhasilan](#13-kriteria-keberhasilan)
14. [Rencana Pengerjaan](#14-rencana-pengerjaan)
15. [Risiko & Mitigasi](#15-risiko--mitigasi)
16. [Glossary](#16-glossary)

---

## 1. LATAR BELAKANG

### 1.1 Profil Usaha

**Zoiez Motor** adalah usaha mikro kecil dan menengah (UMKM) yang bergerak di bidang jasa perawatan dan perbaikan sepeda motor. Bengkel ini melayani berbagai merek dan tipe sepeda motor, mulai dari servis ringan hingga perbaikan besar.

### 1.2 Permasalahan yang Ada

Saat ini Zoiez Motor masih menggunakan **pencatatan manual** (buku tulis/kertas) untuk mengelola inventaris sparepart. Metode ini menimbulkan berbagai permasalahan:

| No | Permasalahan | Dampak |
|----|---|---|
| 1 | Pencatatan stok dilakukan manual di buku | Data tidak akurat, rawan salah tulis |
| 2 | Tidak ada notifikasi saat stok menipis | Sparepart habis mendadak saat dibutuhkan |
| 3 | Sulit melacak riwayat barang masuk/keluar | Tidak bisa audit stok dengan mudah |
| 4 | Laporan dibuat manual dan memakan waktu | Pemilik kesulitan memantau kondisi stok |
| 5 | Data mudah hilang/rusak (buku sobek, dll) | Kehilangan histori transaksi penting |
| 6 | Tidak bisa diakses dari perangkat lain | Informasi hanya bisa dilihat di buku fisik |

### 1.3 Solusi yang Diusulkan

Membangun **Sistem Inventaris Sparepart Berbasis Web** menggunakan framework Laravel yang dapat:
- Menggantikan pencatatan manual dengan sistem digital
- Memberikan notifikasi otomatis saat stok menipis
- Menghasilkan laporan secara cepat dan akurat
- Diakses melalui browser di komputer/laptop bengkel

---

## 2. TUJUAN SISTEM

### 2.1 Tujuan Umum

Merancang dan membangun sistem informasi inventaris sparepart berbasis web yang mampu meningkatkan efisiensi dan akurasi pengelolaan stok sparepart di Bengkel Zoiez Motor.

### 2.2 Tujuan Khusus

- **Digitalisasi pencatatan** stok sparepart dari manual ke sistem berbasis web
- **Otomatisasi perhitungan** stok setiap terjadi transaksi masuk atau keluar
- **Memberikan peringatan dini** ketika stok sparepart mencapai batas minimum
- **Mempermudah pembuatan laporan** transaksi dengan filter tanggal
- **Menjaga keamanan data** dengan sistem autentikasi login admin

---

## 3. RUANG LINGKUP

### 3.1 Yang Termasuk dalam Sistem (In Scope)

- ✅ Autentikasi login admin (satu pengguna)
- ✅ Dashboard statistik inventaris
- ✅ Manajemen kategori sparepart (CRUD)
- ✅ Manajemen data sparepart (CRUD)
- ✅ Pencatatan barang masuk + update stok otomatis
- ✅ Pencatatan barang keluar + update stok otomatis
- ✅ Notifikasi stok menipis (stok ≤ stok minimal)
- ✅ Laporan transaksi dengan filter tanggal
- ✅ Fungsi logout

### 3.2 Yang Tidak Termasuk dalam Sistem (Out of Scope)

- ❌ Manajemen multi-user / multi-level akses
- ❌ Sistem kasir / point of sale (POS)
- ❌ Manajemen pelanggan (customer management)
- ❌ Manajemen supplier / pembelian otomatis
- ❌ Notifikasi via email atau WhatsApp
- ❌ Aplikasi mobile (Android/iOS)
- ❌ Integrasi dengan sistem akuntansi
- ❌ Fitur backup otomatis terjadwal

---

## 4. PENGGUNA SISTEM

### 4.1 Aktor

Sistem ini hanya memiliki **satu aktor** yaitu:

| Aktor | Deskripsi | Hak Akses |
|---|---|---|
| **Admin** | Pemilik atau pegawai yang ditunjuk untuk mengelola inventaris | Akses penuh ke semua fitur |

### 4.2 Karakteristik Pengguna

| Aspek | Detail |
|---|---|
| Jumlah pengguna | 1 orang (admin) |
| Tingkat keahlian IT | Menengah — bisa mengoperasikan komputer dan browser |
| Frekuensi penggunaan | Setiap hari kerja |
| Perangkat yang digunakan | Komputer/laptop di bengkel |

---

## 5. KEBUTUHAN FUNGSIONAL

### FR-01 — Autentikasi Login

| Atribut | Detail |
|---|---|
| **ID** | FR-01 |
| **Nama** | Login Admin |
| **Deskripsi** | Admin dapat masuk ke sistem menggunakan email dan password |
| **Input** | Email, Password |
| **Proses** | Sistem memverifikasi kredensial dengan database |
| **Output** | Redirect ke dashboard (sukses) atau pesan error (gagal) |
| **Prioritas** | Tinggi |

**Aturan bisnis:**
- Email dan password wajib diisi
- Password dienkripsi menggunakan bcrypt
- Jika login gagal, tampilkan pesan error yang sesuai
- Session aktif selama browser tidak ditutup atau logout

---

### FR-02 — Dashboard

| Atribut | Detail |
|---|---|
| **ID** | FR-02 |
| **Nama** | Dashboard Statistik |
| **Deskripsi** | Menampilkan ringkasan kondisi inventaris secara real-time |
| **Prioritas** | Tinggi |

**Informasi yang ditampilkan:**
- Total jumlah sparepart (item)
- Total jumlah kategori
- Total barang masuk hari ini
- Total barang keluar hari ini
- Daftar sparepart dengan stok menipis
- Grafik atau ringkasan transaksi terbaru

---

### FR-03 — Manajemen Kategori Sparepart

| Atribut | Detail |
|---|---|
| **ID** | FR-03 |
| **Nama** | CRUD Kategori |
| **Deskripsi** | Admin dapat mengelola kategori pengelompokan sparepart |
| **Prioritas** | Tinggi |

**Operasi yang tersedia:**
- **Create** — Tambah kategori baru (nama + deskripsi)
- **Read** — Lihat daftar semua kategori dalam tabel
- **Update** — Edit nama dan deskripsi kategori
- **Delete** — Hapus kategori (hanya jika tidak ada sparepart terkait)

---

### FR-04 — Manajemen Sparepart

| Atribut | Detail |
|---|---|
| **ID** | FR-04 |
| **Nama** | CRUD Sparepart |
| **Deskripsi** | Admin dapat mengelola data master sparepart bengkel |
| **Prioritas** | Tinggi |

**Operasi yang tersedia:**
- **Create** — Tambah sparepart baru dengan data lengkap
- **Read** — Lihat daftar sparepart + indikator stok menipis
- **Update** — Edit semua data sparepart
- **Delete** — Hapus sparepart

**Field yang dikelola:**

| Field | Tipe | Wajib | Keterangan |
|---|---|---|---|
| Kode Sparepart | Teks | ✅ | Unik, format: SP-001 |
| Nama Sparepart | Teks | ✅ | Nama lengkap item |
| Kategori | Pilihan | ✅ | Dropdown dari tabel kategoris |
| Merk | Teks | ❌ | Brand/merek |
| Satuan | Teks | ✅ | pcs, liter, set, dll |
| Harga Beli | Angka | ✅ | Harga dari supplier |
| Harga Jual | Angka | ✅ | Harga ke pelanggan |
| Stok | Angka | ✅ | Jumlah stok saat ini |
| Stok Minimal | Angka | ✅ | Batas minimum notifikasi |
| Keterangan | Teks | ❌ | Catatan tambahan |

---

### FR-05 — Barang Masuk

| Atribut | Detail |
|---|---|
| **ID** | FR-05 |
| **Nama** | Pencatatan Barang Masuk |
| **Deskripsi** | Admin mencatat penambahan stok sparepart, stok otomatis bertambah |
| **Prioritas** | Tinggi |

**Alur proses:**
1. Admin memilih sparepart dari dropdown
2. Admin mengisi jumlah yang masuk dan tanggal
3. Admin mengisi keterangan (opsional)
4. Sistem menyimpan data ke tabel `barang_masuk`
5. Sistem otomatis menambah nilai `stok` pada tabel `spareparti`

**Validasi:**
- Sparepart wajib dipilih
- Jumlah harus lebih dari 0
- Tanggal wajib diisi

---

### FR-06 — Barang Keluar

| Atribut | Detail |
|---|---|
| **ID** | FR-06 |
| **Nama** | Pencatatan Barang Keluar |
| **Deskripsi** | Admin mencatat penggunaan/penjualan stok, stok otomatis berkurang |
| **Prioritas** | Tinggi |

**Alur proses:**
1. Admin memilih sparepart dari dropdown
2. Admin mengisi jumlah yang keluar dan tanggal
3. Sistem mengecek apakah stok mencukupi
4. Jika cukup → simpan ke `barang_keluar` + kurangi stok
5. Jika tidak cukup → tampilkan pesan error

**Validasi:**
- Jumlah keluar tidak boleh melebihi stok yang tersedia
- Jumlah harus lebih dari 0
- Tanggal wajib diisi

---

### FR-07 — Update Stok Otomatis

| Atribut | Detail |
|---|---|
| **ID** | FR-07 |
| **Nama** | Kalkulasi Stok Otomatis |
| **Deskripsi** | Stok sparepart terupdate otomatis setiap ada transaksi masuk/keluar |
| **Prioritas** | Tinggi |

**Logika:**
```
Stok Baru = Stok Lama + Jumlah Masuk   (untuk barang masuk)
Stok Baru = Stok Lama - Jumlah Keluar  (untuk barang keluar)
```

---

### FR-08 — Notifikasi Stok Menipis

| Atribut | Detail |
|---|---|
| **ID** | FR-08 |
| **Nama** | Peringatan Stok Minimum |
| **Deskripsi** | Sistem menampilkan peringatan visual untuk sparepart yang stoknya ≤ stok_minimal |
| **Prioritas** | Tinggi |

**Tampilan peringatan:**
- Badge/label merah pada daftar sparepart
- Widget daftar stok kritis di dashboard
- Indikator visual pada menu sidebar (jumlah item kritis)

**Kondisi trigger:**
```
IF stok <= stok_minimal THEN tampilkan peringatan
```

---

### FR-09 — Laporan Transaksi

| Atribut | Detail |
|---|---|
| **ID** | FR-09 |
| **Nama** | Laporan dengan Filter Tanggal |
| **Deskripsi** | Admin dapat melihat rekap transaksi berdasarkan rentang tanggal |
| **Prioritas** | Tinggi |

**Filter yang tersedia:**
- Tanggal dari — Tanggal sampai
- Jenis transaksi: Semua / Barang Masuk / Barang Keluar

**Informasi yang ditampilkan:**
- Tanggal transaksi
- Nama sparepart
- Jenis (masuk/keluar)
- Jumlah
- Keterangan

---

### FR-10 — Logout

| Atribut | Detail |
|---|---|
| **ID** | FR-10 |
| **Nama** | Logout Admin |
| **Deskripsi** | Admin dapat mengakhiri sesi dengan aman |
| **Prioritas** | Tinggi |

**Proses:**
1. Admin klik tombol logout
2. Sistem menghapus session
3. Redirect ke halaman login

---

## 6. KEBUTUHAN NON-FUNGSIONAL

### NFR-01 — Performa

| Kriteria | Target |
|---|---|
| Waktu loading halaman | < 3 detik |
| Waktu respon operasi CRUD | < 2 detik |
| Waktu query laporan | < 5 detik |

### NFR-02 — Keamanan

| Kriteria | Implementasi |
|---|---|
| Proteksi halaman | Middleware `auth` Laravel |
| Enkripsi password | Bcrypt hashing |
| Proteksi form | CSRF token Laravel |
| Validasi input | Laravel Form Validation |

### NFR-03 — Ketersediaan

| Kriteria | Detail |
|---|---|
| Lingkungan lokal | XAMPP (localhost) |
| Lingkungan produksi | Shared hosting cPanel |
| Kompatibilitas browser | Chrome, Firefox, Edge (versi terbaru) |
| Tidak memerlukan internet | Berjalan offline (localhost) |

### NFR-04 — Kemudahan Penggunaan (Usability)

- Antarmuka bersih, intuitif, dan mudah dipahami
- Navigasi menggunakan sidebar yang konsisten
- Pesan sukses/error yang jelas setiap operasi
- Responsif untuk layar desktop dan tablet

### NFR-05 — Kemudahan Pemeliharaan (Maintainability)

- Kode mengikuti standar MVC Laravel
- Setiap fungsi penting disertai komentar
- Penamaan variabel dan fungsi yang deskriptif
- Struktur folder yang terorganisir

---

## 7. USE CASE

### 7.1 Diagram Use Case (Teks)

```
╔══════════════════════════════════════════════════════════════╗
║           SISTEM INVENTARIS SPAREPART ZOIEZ MOTOR            ║
╠══════════════════════════════════════════════════════════════╣
║                                                              ║
║   ┌──────────┐   UC-01 ► Login                              ║
║   │          │   UC-02 ► Logout                             ║
║   │          │                                              ║
║   │          │   UC-03 ► Lihat Dashboard                    ║
║   │          │                                              ║
║   │  ADMIN   │   UC-04 ► Tambah Kategori                    ║
║   │          │   UC-05 ► Edit Kategori                      ║
║   │          │   UC-06 ► Hapus Kategori                     ║
║   │          │                                              ║
║   │          │   UC-07 ► Tambah Sparepart                   ║
║   │          │   UC-08 ► Edit Sparepart                     ║
║   │          │   UC-09 ► Hapus Sparepart                    ║
║   │          │                                              ║
║   │          │   UC-10 ► Catat Barang Masuk                 ║
║   │          │              └── <<include>> Update Stok     ║
║   │          │                                              ║
║   │          │   UC-11 ► Catat Barang Keluar                ║
║   │          │              └── <<include>> Update Stok     ║
║   │          │              └── <<include>> Cek Stok Cukup  ║
║   │          │                                              ║
║   │          │   UC-12 ► Lihat Notifikasi Stok Menipis      ║
║   │          │                                              ║
║   └──────────┘   UC-13 ► Lihat Laporan (Filter Tanggal)     ║
║                                                              ║
╚══════════════════════════════════════════════════════════════╝
```

### 7.2 Tabel Use Case

| ID | Use Case | Aktor | Deskripsi |
|---|---|---|---|
| UC-01 | Login | Admin | Masuk ke sistem dengan email & password |
| UC-02 | Logout | Admin | Keluar dari sistem |
| UC-03 | Lihat Dashboard | Admin | Melihat statistik & ringkasan inventaris |
| UC-04 | Tambah Kategori | Admin | Menambahkan kategori sparepart baru |
| UC-05 | Edit Kategori | Admin | Mengubah data kategori |
| UC-06 | Hapus Kategori | Admin | Menghapus kategori yang tidak dipakai |
| UC-07 | Tambah Sparepart | Admin | Mendaftarkan sparepart baru ke sistem |
| UC-08 | Edit Sparepart | Admin | Mengubah data sparepart |
| UC-09 | Hapus Sparepart | Admin | Menghapus data sparepart |
| UC-10 | Catat Barang Masuk | Admin | Mencatat penambahan stok sparepart |
| UC-11 | Catat Barang Keluar | Admin | Mencatat penggunaan/penjualan stok |
| UC-12 | Lihat Notifikasi | Admin | Melihat daftar sparepart stok kritis |
| UC-13 | Lihat Laporan | Admin | Melihat rekap transaksi dengan filter tanggal |

---

## 8. ALUR SISTEM (FLOW)

### 8.1 Alur Login

```
[Buka Aplikasi]
      │
      ▼
[Halaman Login]
      │
      ▼
[Input Email + Password]
      │
      ├── [Kosong/Invalid] ──► [Tampil Pesan Validasi]
      │                               │
      │                               ▼
      │                        [Kembali ke Form]
      │
      ├── [Kredensial Salah] ──► [Tampil "Email atau password salah"]
      │
      └── [Kredensial Benar] ──► [Buat Session]
                                        │
                                        ▼
                                 [Redirect Dashboard]
```

### 8.2 Alur Barang Masuk

```
[Admin klik "Tambah Barang Masuk"]
      │
      ▼
[Form: Pilih Sparepart + Jumlah + Tanggal + Keterangan]
      │
      ▼
[Validasi Form]
      │
      ├── [Gagal] ──► [Tampil Pesan Error] ──► [Kembali ke Form]
      │
      └── [Sukses]
              │
              ▼
        [Simpan ke tabel barang_masuk]
              │
              ▼
        [UPDATE spareparti SET stok = stok + jumlah]
              │
              ▼
        [Flash Message "Berhasil dicatat"]
              │
              ▼
        [Redirect ke daftar barang masuk]
```

### 8.3 Alur Barang Keluar

```
[Admin klik "Tambah Barang Keluar"]
      │
      ▼
[Form: Pilih Sparepart + Jumlah + Tanggal + Keterangan]
      │
      ▼
[Validasi Form]
      │
      ├── [Gagal] ──► [Tampil Pesan Error] ──► [Kembali ke Form]
      │
      └── [Sukses]
              │
              ▼
        [Cek: jumlah ≤ stok tersedia?]
              │
              ├── [TIDAK] ──► [Error: "Stok tidak mencukupi"] ──► [Kembali Form]
              │
              └── [YA]
                      │
                      ▼
                [Simpan ke tabel barang_keluar]
                      │
                      ▼
                [UPDATE spareparti SET stok = stok - jumlah]
                      │
                      ▼
                [Cek: stok ≤ stok_minimal?]
                      │
                      ├── [YA] ──► [Tandai sebagai stok kritis]
                      └── [TIDAK] ──► [Selesai]
```

---

## 9. DESAIN DATABASE (ERD)

### 9.1 Entitas & Atribut

#### Tabel: `users`
| Field | Tipe | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| name | VARCHAR(100) | NOT NULL | Nama admin |
| email | VARCHAR(100) | UNIQUE, NOT NULL | Email login |
| password | VARCHAR(255) | NOT NULL | Password (bcrypt) |
| remember_token | VARCHAR(100) | NULL | Token ingat saya |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

#### Tabel: `kategoris`
| Field | Tipe | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| nama_kategori | VARCHAR(100) | NOT NULL | Nama kategori |
| deskripsi | TEXT | NULL | Keterangan |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

#### Tabel: `spareparti`
| Field | Tipe | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| kategori_id | BIGINT | FK → kategoris.id | Relasi kategori |
| kode_sparepart | VARCHAR(50) | UNIQUE, NOT NULL | Kode unik |
| nama_sparepart | VARCHAR(150) | NOT NULL | Nama sparepart |
| merk | VARCHAR(100) | NULL | Brand/merk |
| satuan | VARCHAR(30) | NOT NULL | Satuan ukur |
| harga_beli | DECIMAL(15,2) | NOT NULL | Harga beli |
| harga_jual | DECIMAL(15,2) | NOT NULL | Harga jual |
| stok | INT | DEFAULT 0 | Stok saat ini |
| stok_minimal | INT | DEFAULT 5 | Batas minimum |
| keterangan | TEXT | NULL | Catatan |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

#### Tabel: `barang_masuk`
| Field | Tipe | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| sparepart_id | BIGINT | FK → spareparti.id | Relasi sparepart |
| jumlah | INT | NOT NULL | Jumlah masuk |
| tanggal | DATE | NOT NULL | Tanggal transaksi |
| keterangan | TEXT | NULL | Catatan |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

#### Tabel: `barang_keluar`
| Field | Tipe | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| sparepart_id | BIGINT | FK → spareparti.id | Relasi sparepart |
| jumlah | INT | NOT NULL | Jumlah keluar |
| tanggal | DATE | NOT NULL | Tanggal transaksi |
| keterangan | TEXT | NULL | Catatan |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

### 9.2 Relasi Antar Tabel

```
kategoris (1) ──────────────────< spareparti (N)
                                       │
                           ┌───────────┴───────────┐
                           │                       │
                    (1)    │                (1)    │
              barang_masuk (N)        barang_keluar (N)
```

| Relasi | Tipe | Keterangan |
|---|---|---|
| kategoris → spareparti | 1 : N | Satu kategori memiliki banyak sparepart |
| spareparti → barang_masuk | 1 : N | Satu sparepart bisa masuk berkali-kali |
| spareparti → barang_keluar | 1 : N | Satu sparepart bisa keluar berkali-kali |

---

## 10. SPESIFIKASI TEKNOLOGI

### 10.1 Stack Teknologi

| Komponen | Teknologi | Versi | Keterangan |
|---|---|---|---|
| Backend Framework | Laravel | 11.x / 12.x (terbaru stabil) | MVC Pattern |
| Bahasa Pemrograman | PHP | 8.2+ | Wajib kompatibel |
| Database | MySQL | 5.7+ / 8.0 | Via XAMPP |
| Frontend Styling | Tailwind CSS | v4.x | Utility-first CSS |
| Build Tool | Vite | 6.x | Bundler modern |
| Ikon | Heroicons | 2.x | SVG icons |
| Template Engine | Blade | Bawaan Laravel | Server-side rendering |

### 10.2 Lingkungan Pengembangan

| Item | Spesifikasi |
|---|---|
| Web Server Lokal | XAMPP (Apache + MySQL) |
| Code Editor | Visual Studio Code |
| Browser | Google Chrome (Development) |
| Package Manager PHP | Composer 2.x |
| Package Manager JS | npm 9.x+ |
| Version Control | Git (opsional, disarankan) |

### 10.3 Lingkungan Produksi (Hosting)

| Item | Spesifikasi |
|---|---|
| Jenis Hosting | Shared Hosting cPanel |
| PHP Version | 8.2+ |
| Database | MySQL via phpMyAdmin cPanel |
| Fitur Wajib | Mendukung Laravel (mod_rewrite aktif) |
| Tidak Dibutuhkan | Redis, Queue, WebSocket |

---

## 11. DESAIN UI/UX

### 11.1 Prinsip Desain

- **Clean & Modern** — Tampilan minimalis ala SaaS dashboard
- **Consistent** — Komponen yang sama di setiap halaman
- **Intuitive** — Navigasi mudah dipahami tanpa pelatihan
- **Responsive** — Berfungsi di layar desktop dan tablet

### 11.2 Struktur Halaman

| Halaman | URL | Deskripsi |
|---|---|---|
| Login | `/login` | Form autentikasi admin |
| Dashboard | `/dashboard` | Ringkasan statistik & stok kritis |
| Kategori | `/kategori` | Daftar & kelola kategori |
| Sparepart | `/sparepart` | Daftar & kelola sparepart |
| Barang Masuk | `/barang-masuk` | Log & form barang masuk |
| Barang Keluar | `/barang-keluar` | Log & form barang keluar |
| Laporan | `/laporan` | Laporan dengan filter tanggal |

### 11.3 Komponen UI Utama

**Sidebar (Navigasi Kiri):**
```
┌─────────────────────┐
│  🔧 Zoiez Motor     │
├─────────────────────┤
│  📊 Dashboard       │
│  🏷️  Kategori       │
│  🔩 Sparepart       │
│  📥 Barang Masuk    │
│  📤 Barang Keluar   │
│  ⚠️  Stok Menipis   │
│  📄 Laporan         │
├─────────────────────┤
│  🚪 Logout          │
└─────────────────────┘
```

**Warna Tema:**
- Primary: Biru (`blue-600`) — tombol utama, aksen
- Success: Hijau (`green-500`) — stok aman, sukses
- Warning: Kuning (`yellow-500`) — stok hampir habis
- Danger: Merah (`red-500`) — stok kritis, hapus
- Neutral: Abu-abu (`gray-100 - gray-800`) — background, teks

### 11.4 Komponen Berulang

| Komponen | Digunakan di |
|---|---|
| `btn-primary` | Semua form (Simpan, Tambah) |
| `btn-danger` | Tombol hapus |
| `btn-secondary` | Tombol batal/kembali |
| `card` | Semua panel statistik & tabel |
| `form-input` | Semua input form |
| `form-label` | Semua label form |
| Badge merah | Indikator stok menipis |
| Flash message | Notifikasi sukses/error operasi |

---

## 12. BATASAN SISTEM

| No | Batasan | Keterangan |
|---|---|---|
| 1 | Satu pengguna (admin) | Tidak ada fitur multi-user |
| 2 | Berbasis web, bukan mobile | Tidak ada aplikasi Android/iOS |
| 3 | Offline (localhost) | Tidak memerlukan koneksi internet |
| 4 | Tidak ada notifikasi push/email | Peringatan hanya tampil di UI |
| 5 | Tidak ada fitur cetak/export PDF | Laporan hanya ditampilkan di layar |
| 6 | Barang masuk/keluar tidak bisa diedit | Demi integritas dan audit data |
| 7 | Tidak ada manajemen supplier | Di luar ruang lingkup |

---

## 13. KRITERIA KEBERHASILAN

Sistem dinyatakan berhasil apabila memenuhi kriteria berikut:

| No | Kriteria | Indikator |
|---|---|---|
| 1 | Login berfungsi | Admin bisa masuk dan session terjaga |
| 2 | CRUD Kategori berfungsi | Data tersimpan, terupdate, terhapus di DB |
| 3 | CRUD Sparepart berfungsi | Data tersimpan, terupdate, terhapus di DB |
| 4 | Barang masuk berfungsi | Stok bertambah setelah transaksi |
| 5 | Barang keluar berfungsi | Stok berkurang setelah transaksi |
| 6 | Validasi stok cukup | Sistem menolak jika stok kurang |
| 7 | Notifikasi stok menipis | Badge merah muncul saat stok ≤ minimal |
| 8 | Laporan filter berfungsi | Data tersaring sesuai tanggal |
| 9 | Berjalan di XAMPP | Dapat diakses via localhost |
| 10 | Berjalan di hosting | Dapat diakses via shared hosting |

---

## 14. RENCANA PENGERJAAN

| Tahap | Nama Tahap | Estimasi Waktu |
|---|---|---|
| 1 | Analisis Sistem | 1-2 hari |
| 2 | Desain Database | 1 hari |
| 3 | Setup Project | 1 hari |
| 4 | Authentication | 1-2 hari |
| 5 | Dashboard UI | 2-3 hari |
| 6 | CRUD Sparepart & Kategori | 3-4 hari |
| 7 | Barang Masuk & Keluar | 2-3 hari |
| 8 | Notifikasi Stok Menipis | 1 hari |
| 9 | Laporan | 2 hari |
| 10 | Testing & Finalisasi | 2-3 hari |
| **Total** | | **~16-22 hari kerja** |

---

## 15. RISIKO & MITIGASI

| No | Risiko | Kemungkinan | Dampak | Mitigasi |
|---|---|---|---|---|
| 1 | Error saat instalasi Laravel | Sedang | Tinggi | Ikuti dokumentasi resmi, gunakan versi stabil |
| 2 | Konflik versi PHP & Laravel | Sedang | Tinggi | Gunakan PHP 8.2+ dan Laravel versi terbaru stabil |
| 3 | Data hilang saat development | Rendah | Tinggi | Backup database secara berkala |
| 4 | Error saat deploy ke hosting | Sedang | Sedang | Test di localhost dulu, baca dokumentasi hosting |
| 5 | Performa lambat di hosting | Rendah | Sedang | Optimalkan query, hindari N+1 problem |

---

## 16. GLOSSARY

| Istilah | Penjelasan |
|---|---|
| **CRUD** | Create, Read, Update, Delete — operasi dasar database |
| **MVC** | Model-View-Controller — pola arsitektur Laravel |
| **Migration** | File PHP untuk membuat/mengubah struktur tabel database |
| **Seeder** | File PHP untuk mengisi data awal ke database |
| **Middleware** | Filter yang berjalan sebelum request masuk ke controller |
| **Blade** | Template engine bawaan Laravel untuk membuat tampilan HTML |
| **Eloquent** | ORM (Object Relational Mapper) bawaan Laravel |
| **Foreign Key** | Kolom penghubung antar tabel di database |
| **Stok Minimal** | Batas jumlah stok terendah sebelum notifikasi muncul |
| **UMKM** | Usaha Mikro Kecil dan Menengah |
| **KKP** | Kuliah Kerja Praktek — program magang akademik |
| **ERD** | Entity Relationship Diagram — diagram relasi tabel database |
| **PRD** | Product Requirements Document — dokumen spesifikasi sistem |
| **XAMPP** | Software bundle Apache + MySQL + PHP untuk development lokal |
| **cPanel** | Control Panel untuk mengelola shared hosting |
| **Vite** | Build tool modern untuk mengkompilasi aset CSS dan JavaScript |
| **Tailwind CSS** | Framework CSS berbasis utility class |

---

*Dokumen ini dibuat sebagai bagian dari laporan Kuliah Kerja Praktek (KKP)*
*Sistem Inventaris Sparepart Bengkel — Zoiez Motor*
*© 2026 — Hak cipta dilindungi*
