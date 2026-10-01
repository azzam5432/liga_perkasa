# 🚀 Panduan Lengkap Setup & Hosting Proyek Liga Perkasa ke Hostinger

Dokumen ini berisi rangkuman arsitektur teknologi (*tech stack*) dari repositori **Liga Perkasa** beserta panduan langkah demi langkah untuk melakukan hosting ke **Hostinger** (baik paket *Shared Hosting / Cloud hPanel* maupun *VPS*).

---

## 📌 1. Analisis Tech Stack & Kebutuhan Sistem

Berdasarkan hasil analisis terhadap seluruh berkas dan dependensi repositori:

| Komponen | Spesifikasi / Paket | Keterangan Penting |
| :--- | :--- | :--- |
| **Framework Backend** | Laravel **12.x** (`laravel/framework: ^12.0`) | Versi rilis terbaru Laravel |
| **Versi PHP Minimum** | **PHP 8.3** atau **PHP 8.4** | ⚠️ **PENTING**: Meskipun `composer.json` menyebut `^8.2`, dependensi `phpoffice/phpspreadsheet 5.9.0` mengunci `maennchen/zipstream-php 3.2.2` yang **mewajibkan PHP 64-bit >= 8.3**. Di Hostinger hPanel, pilih minimal **PHP 8.3**. |
| **Ekstensi PHP Wajib** | `pdo_mysql`, `zip`, `gd`, `fileinfo`, `mbstring`, `xml`, `curl`, `bcmath`, `ctype` | Aktifkan di menu *PHP Extensions* Hostinger |
| **Database** | MySQL / MariaDB | 25 file migrasi database (Tabel Pengguna, Lomba, Tim, Peserta, Juri, Penilaian, Penghargaan, Pembimbing) |
| **Frontend UI** | Bootstrap 5.3 (CDN), FontAwesome 6 (CDN), Google Fonts Inter | Tampilan utama menggunakan Blade templates dengan CDN |
| **Asset Bundler** | Vite 6 + Tailwind CSS v4 | Berkas build tersimpan di `public/build/` |
| **Fitur Unggulan** | Export Excel (`phpoffice/phpspreadsheet`), Dynamic Klasemen, Otentikasi Multi-role (`super_admin` & `panitia`) | Ekspor Excel membutuhkan ekstensi PHP `gd` dan `zip` |
| **Penyimpanan Upload** | Folder lokal `public/uploads/profil/` | Perlu dipastikan memiliki izin tulis (*write permission*) `775` atau `755` |

### 🔑 Akun Default (Seeder)
Jika Anda menjalankan database seeder (`php artisan db:seed`):
- **Email**: `superadmin@example.com`
- **Password**: `password123`
- **Role**: `super_admin`
> *Catatan: Segera ubah email dan password akun ini setelah website online!*

---

## 🛠️ 2. File Pendukung yang Telah Disiapkan di Repositori

Untuk mempermudah proses deploy, beberapa file pendukung telah dibuat di dalam proyek:

1. [`.env.production.example`](file:///.env.production.example): Template konfigurasi *environment* yang sudah disesuaikan untuk server produksi Hostinger (MySQL, cache aman, log level error, mail Hostinger).
2. [`.htaccess.root.example`](file:///.htaccess.root.example): Konfigurasi rewrite aman untuk Shared Hosting jika Anda mengunggah seluruh folder proyek ke dalam `public_html/`.
3. [`deploy-hostinger.sh`](file:///deploy-hostinger.sh): Script shell otomatis untuk Anda yang menggunakan akses SSH/Terminal di Hostinger.
4. Folder [`public/build/`](file:///public/build/): Aset Vite production telah di-compile sehingga siap digunakan langsung.

---

## 🌐 3. Panduan Deploy ke Hostinger Shared / Cloud Hosting (hPanel)

Terdapat 2 opsi deployment tergantung preferensi Anda:

---

### 🔹 METODE A (Sangat Direkomendasikan: Menggunakan Git & SSH hPanel)

Metode ini paling rapi, mudah diperbarui saat ada revisi code, dan aman.

#### Langkah 1: Atur Versi PHP di hPanel
1. Buka dashboard **Hostinger hPanel**.
2. Masuk ke menu **Tingkat Lanjut (Advanced)** -> **Konfigurasi PHP (PHP Configuration)**.
3. Pilih **PHP 8.3** (atau 8.4), lalu klik **Perbarui (Update)**.
4. Masuk ke tab **Ekstensi PHP (PHP Extensions)**, pastikan ekstensi berikut tercentang:
   - `pdo_mysql`, `zip`, `gd`, `fileinfo`, `mbstring`, `xml`, `curl`, `bcmath`.

#### Langkah 2: Buat Database MySQL
1. Di hPanel, buka menu **Database** -> **Database MySQL**.
2. Buat database baru, contoh:
   - **Nama Database**: `u123456789_ligaperkasa`
   - **Username**: `u123456789_admin`
   - **Password**: `PasswordKuatAnda123!`
3. Catat ketiga informasi tersebut.

#### Langkah 3: Clone Repository via SSH
1. Buka menu **Tingkat Lanjut** -> **Akses SSH** dan aktifkan SSH.
2. Buka terminal komputer Anda atau gunakan fitur **Browser Terminal** di hPanel.
3. Hubungkan ke SSH Hostinger:
   ```bash
   ssh -p [PORT] [USERNAME]@[IP_ATAU_DOMAIN]
   ```
4. Pindah ke direktori utama (di luar `public_html`):
   ```bash
   cd ~
   git clone https://github.com/azzam5432/liga_perkasa.git liga_perkasa
   cd liga_perkasa
   ```

#### Langkah 4: Konfigurasi `.env` & Migrasi
1. Salin template production env:
   ```bash
   cp .env.production.example .env
   nano .env
   ```
2. Isi detail database yang tadi dibuat:
   ```env
   APP_URL=https://namadomainanda.com
   DB_DATABASE=u123456789_ligaperkasa
   DB_USERNAME=u123456789_admin
   DB_PASSWORD=PasswordKuatAnda123!
   ```
   *(Tekan `Ctrl + O` lalu `Enter` untuk simpan, `Ctrl + X` untuk keluar)*.
3. Jalankan instalasi composer dan key generate:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --seed --force
   ```

#### Langkah 5: Hubungkan ke `public_html`
Ada dua cara menghubungkan aplikasi ke web:
- **Cara Symlink (Termudah):**
  ```bash
  # Hapus folder default public_html jika masih kosong
  rm -rf ~/public_html
  # Buat symlink dari public/ ke public_html
  ln -s ~/liga_perkasa/public ~/public_html
  ```
- **Cara Pindah Isi Folder:**
  Pindahkan seluruh isi `~/liga_perkasa/public/*` ke dalam `~/public_html/`, kemudian edit baris require di `~/public_html/index.php`:
  ```php
  require __DIR__.'/../liga_perkasa/vendor/autoload.php';
  $app = require_once __DIR__.'/../liga_perkasa/bootstrap/app.php';
  ```

#### Langkah 6: Optimasi & Izin Folder
Jalankan script otomatis yang telah disiapkan:
```bash
bash deploy-hostinger.sh
```

---

### 🔹 METODE B (Metode File Manager / Upload File ZIP tanpa SSH)

Jika Anda tidak memiliki akses SSH:

#### Langkah 1: Persiapan File di Komputer Lokal
1. Pastikan berkas dependensi composer dan aset telah terpasang di komputer lokal.
2. Siapkan file `.env` dengan kredensial database Hostinger.
3. Kompres seluruh proyek menjadi format `.zip` **KECUALI** folder `.git`, `tests`, dan `node_modules` (folder `vendor`, `public`, `app`, dll. harus diikutsertakan).

#### Langkah 2: Upload ke Hostinger File Manager
1. Buka hPanel -> **File Manager**.
2. Masuk ke direktori root pengguna (satu tingkat di atas `public_html`).
3. Buat folder baru bernama `liga_perkasa` dan unggah file `.zip`, lalu ekstrak di folder tersebut.
4. Buka folder `liga_perkasa/public`, pindahkan seluruh isinya (termasuk `.htaccess`, `index.php`, folder `build`, `uploads`, dll.) ke dalam folder `public_html`.

#### Langkah 3: Sesuaikan Path di `public_html/index.php`
Buka file `public_html/index.php` menggunakan editor File Manager hPanel, ubah path autoload dan bootstrap menjadi:
```php
// Jika posisi project di: /home/uXXXXXXX/liga_perkasa/
if (file_exists($maintenance = __DIR__.'/../liga_perkasa/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../liga_perkasa/vendor/autoload.php';

$app = require_once __DIR__.'/../liga_perkasa/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

#### Langkah 4: Import Database
1. Buka phpMyAdmin dari menu Database hPanel.
2. Buat database dan import struktur database (atau gunakan terminal SSH untuk menjalankan `php artisan migrate --seed`).
3. Pastikan folder `storage`, `bootstrap/cache`, dan `public_html/uploads` memiliki permission `775` atau `755`.

---

## 🖥️ 4. Panduan Deploy ke Hostinger VPS (Ubuntu / Nginx)

Jika Anda menyewa Hostinger VPS:

1. **Install Nginx, PHP 8.3 & Ekstensi:**
   ```bash
   sudo apt update && sudo apt upgrade -y
   sudo apt install -y nginx mysql-server git unzip curl
   sudo add-apt-repository ppa:ondrej/php -y
   sudo apt update
   sudo apt install -y php8.3-fpm php8.3-cli php8.3-mysql php8.3-gd php8.3-zip php8.3-xml php8.3-mbstring php8.3-curl php8.3-bcmath
   ```

2. **Clone Proyek ke `/var/www/`:**
   ```bash
   sudo git clone https://github.com/azzam5432/liga_perkasa.git /var/www/liga_perkasa
   cd /var/www/liga_perkasa
   sudo chown -R www-data:www-data /var/www/liga_perkasa
   sudo chmod -R 775 storage bootstrap/cache public/uploads
   ```

3. **Konfigurasi Virtual Host Nginx (`/etc/nginx/sites-available/liga_perkasa`):**
   ```nginx
   server {
       listen 80;
       server_name domain-anda.com www.domain-anda.com;
       root /var/www/liga_perkasa/public;

       index index.php index.html;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           include snippets/fastcgi-php.conf;
           fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```
4. Aktifkan config dan pasang SSL gratis (Let's Encrypt / Certbot):
   ```bash
   sudo ln -s /etc/nginx/sites-available/liga_perkasa /etc/nginx/sites-enabled/
   sudo nginx -t && sudo systemctl reload nginx
   sudo apt install -y certbot python3-certbot-nginx
   sudo certbot --nginx -d domain-anda.com
   ```

---

## ⚠️ 5. Troubleshooting Masalah Umum di Hostinger

| Masalah | Penyebab | Solusi |
| :--- | :--- | :--- |
| **Error 500 (Internal Server Error)** | Izin folder atau file `.env` belum ada / APP_KEY kosong | 1. Cek `storage/logs/laravel.log`.<br>2. Pastikan file `.env` ada dan jalankan `php artisan key:generate`.<br>3. Beri izin: `chmod -R 775 storage bootstrap/cache`. |
| **ZipStream / PhpSpreadsheet Error** | Versi PHP di hPanel di bawah 8.3 | Masuk ke **hPanel -> PHP Configuration** dan ubah ke **PHP 8.3** atau **8.4**. |
| **Upload Foto Profil Gagal / Error 403/404** | Folder `public/uploads/profil` belum ada atau tidak writable | Buat folder `public/uploads/profil` dan jalankan `chmod -R 775 public/uploads`. |
| **Tampilan CSS/JS Rusak atau 404** | Aset Vite belum di-build | File di `public/build` sudah disiapkan. Pastikan `APP_URL` di `.env` sudah menggunakan `https://domain-anda.com` yang valid. |
| **Route mengarah ke 404 pada sub-halaman** | Mod_rewrite apache belum aktif atau `.htaccess` hilang | Pastikan file `.htaccess` di dalam `public/` ikut terunggah (file tersembunyi/dotfile). |

---

Dengan mengikuti panduan di atas, aplikasi **Liga Perkasa** siap online dan berjalan stabil di Hostinger!
