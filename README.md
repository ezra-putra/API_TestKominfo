<h2 align="center">DOKUMENTASI INSTALASI</h2>

## Instalasi Laravel

note: 
     -     Versi Laravel : 8.0 dan Versi PHP : 7.4.

Langkah pertama adalah melakukan instalasi laravelnya yaitu sebagai berikut
1. Lakukan terlebih dahulu Clone Repositories ke direktori yang ingin dituju.
2. Kemudian Bukan CMD/Terminal dan arahkan ke folder project laravel dan jalankan perintah dibawah ini:
   -        composer install
   -    Apabila composer belum terinstall pada komputer anda maka dapat melakukan instalasi composer dengan mengunduh composer dari link dibawah ini:
   -        https://getcomposer.org/Composer-Setup.exe
   -    Setelah itu jalankan perintah dibawah ini untuk melakukan generate key:
   -        php artisan key:generate
   -    Kemudian buat file .env: Salin file .env.example menjadi .env dengan perintah dibawah:
   -        cp .env-example .env
   -    Lakukan pengaturan file .env dengan mengcopy paste code dibawah ini:
   -        DB CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=admin_api
            DB_USERNAME=root
            DB_PASSWORD=
            
            
   -    Lakukan perintah dibawah ini untuk migrasi database dan database yang digunakan adalah MySQL:
   -        php artisan migrate
   -    Setelah itu jalankan aplikasi laravel dengan perintah dibawah ini:
   -        php artisan serve


