# Khamim E-Commerce
Website sederhana untuk manage produk dan pembelian produk dengan payment gateway midtrans.

## Kebutuhan Aplikasi

- PHP >= 8.1
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Laragon or XAMPP
- Visual Studio Code

## Instalasi

1. clone repo melalui terminal dengan cara `git clone https://github.com/amimhayden22/Khamim-E-Commerce`
2. `cd Khamim-E-Commerce` untuk masuk ke dalam folder project ini
3. install semua dependesi yang dibutuhkan, dengan perintah `composer install` di terminal
4. kemudian buat database mysql dengan nama `khamim_e_commerce` bisa melalui phpmyadmin di xampp/laragon lalu import file sql yang ada di dalam folder ini yaitu `khamim_e_commerce.sql`.
5. selanjutnya, ketik `cp .env.example .env` di terminal
6. kemudian buka `.env` lalu isi semua pengaturan yang diperlukan seperti pengaturan database, pengaturan api midtrans, dsb
7. untuk menjalankan website ini ketik `php artisan serve` di terminal
8. kemudian buka browser dan ketik url berikut: `http://127.0.0.1:8000`

## Catatan

Untuk membuka halaman admin silakan buka url `http://127.0.0.1:8000/login`. Anda dapat login menggunakan akun berikut:

> Email: **admin@gmail.com** <br>
> Password: **password**


Created By: [Gus Khamim](https://khamim.my.id).
