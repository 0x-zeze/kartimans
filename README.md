# Kartimans Barbershop

Sistem informasi **Kartimans Barbershop** (Purwokerto) untuk website publik, booking/pesanan, dan panel admin.

Aplikasi ini mengelola transaksi layanan, data user, daftar harga, dan laporan. UI admin memakai tema hitam/putih/merah di atas Bootstrap 4.

## Fitur

**Website publik**
- Beranda, tentang, layanan, dan kontak
- Tombol login ke panel admin

**Panel admin**
- Login / logout dengan session
- Dashboard: pendapatan, total penjualan, total pengguna, pending
- Input pesanan (kasir/admin) dan input booking (pelanggan)
- Data Master:
  - Data Transaksi (detail, tandai berhasil, cancel)
  - Data Berhasil
  - Data Cancel
  - Data User (detail, edit, hapus)
  - Data Harga (tambah, edit, hapus)
- Laporan pendapatan (untuk pemilik/admin)

## Level pengguna

| Level | Peran     | Akses |
|------:|-----------|--------|
| 1     | Pemilik   | Dashboard, Data Master, Laporan |
| 2     | Admin     | Dashboard, Input Pesanan, Data Master, Laporan |
| 3     | Kasir     | Dashboard, Input Pesanan, Data Master |
| 4     | Pelanggan | Dashboard, Input Booking |

## Stack

- PHP 8 + [CodeIgniter 3](https://codeigniter.com/)
- MySQL / MariaDB (`kartimans`)
- Bootstrap 4 (Ruang Admin sebagai base UI)
- DataTables, Select2, Chart.js, SweetAlert2
- mPDF untuk export PDF

## Struktur folder

```
application/
  controllers/   Home, ControllerLogin, Dashboard, Element
  models/        Layanan, Logint
  views/         home, login, dashboard, data master, layout
assets/          CSS, JS, gambar, plugin admin
data.sql         Skema + data awal database
system/          Core CodeIgniter 3
```

## Instalasi (XAMPP)

1. Clone repo ke folder web server:

```bash
git clone https://github.com/0x-zeze/kartimans.git
```

Letakkan di `C:\xampp\htdocs\admins` (atau sesuaikan virtual host).

2. Pastikan Apache + MySQL berjalan.

3. Import database:

```sql
source data.sql;
```

atau lewat phpMyAdmin: buat database `kartimans`, lalu import `data.sql`.

4. Cek koneksi di `application/config/database.php`:

```
hostname: localhost
username: root
password: (kosong default XAMPP)
database: kartimans
```

5. Buka:

- Website: `http://localhost/admins/`
- Login: `http://localhost/admins/ControllerLogin`

URL mengikuti folder project. Rewrite Apache (`.htaccess`) sudah menghilangkan `index.php`.

## Akun contoh (`data.sql`)

| Username | Password | Level | Status    |
|----------|----------|------:|-----------|
| `admin`  | `123`    | 1     | Pemilik   |
| `adm`    | `123`    | 2     | Admin     |
| `asd`    | `asd`    | 4     | Pelanggan |

Ganti password ini sebelum dipakai di lingkungan nyata. Password saat ini masih plaintext.

## Catatan UI

Tema admin adalah overlay di `assets/css/admin.css` (setelah `ruang-admin.min.css`). Jangan rewrite file Ruang Admin.

- Login greeting muncul sekali di dashboard.
- Alert Data User / Data Harga hanya untuk aksi CRUD.
- `charts.php` (Laporan) belum mengikuti tema overlay.

## Lisensi

Kode aplikasi mengikuti lisensi repo ini. UI admin berangkat dari [RuangAdmin](https://github.com/indrijunanda/RuangAdmin) (MIT). Landing page memakai template BootstrapMade Day.


