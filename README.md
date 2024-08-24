# Aplikasi e-Library
#### Aplikasi ini dikirimkan untuk keperluan pengumpulan tugas akhir bootcamp "Kazee Fullstack Developer Bootcamp".
<hr>

### Cara Penggunaan
1. Clone repositori ini `git clone https://github.com/Maple06/e-lib`
2. Buka command prompt dan pergi ke direktori repositori ini
3. Jalankan `composer install`
4. Buat salinan .env.example lalu ubah menjadi .env kemudian atur bagian pengaturan database, dsb
5. Nyalakan server MySQL pada XAMPP lalu buat database baru yang kosong sesuai dengan nama yang tadi dimasukkan ke .env pada phpmyadmin
6. Jalankan `php artisan key:generate` 
7. Jalankan `php artisan migrate` 
8. Jalankan `php artisan db:seed` 
8. Jalankan `php artisan storage:link` 
8. Jalankan `php artisan serve` lalu pergi ke http://localhost:8000/
<hr>

### Fitur yang ditambahkan
1. Hapus pengguna (hanya admin) pada halaman pengguna (429785d1bd1bc11a7e142e17d461d5081bd6e4db)
2. Validasi telepon menggunakan [Laravel-Phone plugin](https://github.com/Propaganistas/Laravel-Phone) (429785d1bd1bc11a7e142e17d461d5081bd6e4db)
3. Perubahan dalam styling login page (75f179ba118141e4f99b423781fca9dedd9686e3)
4. CRUD Penerbit (bbe4124f22af96c4ec95a2e5aba2a70bde148d9f)
5. CRUD Kategori (bbe4124f22af96c4ec95a2e5aba2a70bde148d9f)
6. Buat pengguna alias pustakawan (hanya admin) (ccf80f41cdb8815f5ed709242a01c84523b7cecd)
7. Pengaturan akun termasuk ganti password dan hapus akun (b20622840fb07e65cb0d2e1c96fa24c414881a4e)
8. Pengaturan aplikasi (hanya admin) (b20622840fb07e65cb0d2e1c96fa24c414881a4e)
9. Menghapus page contoh karena tidak diperlukan lagi (2bf936bcd0eb7046eded024ddc7b330d583876e1)
 
### Fitur yang belum diimplementasikan
1. Mengganti UI dan backend dashboard
2. Mengganti landing page
3. Menambahkan burger menu untuk sidebar bagi yang mengakses aplikasi pada tablet atau handphone
4. Menambahkan datatables pada halaman anggota, pengguna, dan juga penyewaan

### Fitur yang dapat ditambahkan dikemudian hari
1. Built-in fitur crop foto profil atau logo aplikasi menjadi 1:1
2. Pada dashboard, menggunakan range bulan dan tidak hanya dapat melihat data statistik setiap bulan 1 per 1
3. Halaman baru untuk melihat penyewaan yang belum dikembalikan