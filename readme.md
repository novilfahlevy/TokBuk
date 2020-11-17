<p align="center">
    <img src="./public/assets/img/logo.png" alt="TokBuk" width="200" style="margin-bottom: 20px" />
</p>

## Tentang TokBuk

TokBuk adalah aplikasi pengelolaan toko buku yang dapat digunakan oleh owner toko buku manapun untuk mengelola dan mencatat atau merekam riwayat pengadaan stok buku dari distributor, pengadaan oleh pelanggan, dan mengelola lokasi atau tata letak buku.

## Bahan atau software yang diperlukan
- [Composer](https://getcomposer.org)
- [Git](https://git-scm.com/downloads)
- [XAMPP](https://www.apachefriends.org/download.html)
- [Pusher](https://pusher.com) (opsional)
- [Sentry](https://docs.sentry.io/platforms/php/guides/laravel/) (opsional, jika ingin melakukan error tracking)

## Instalasi
1. Clone repo ini dengan menggunakan perintah

    ```bash
    git clone https://github.com/novilfahlevy/TokBuk.git
    ```

2. Copy file *.env.example* dan paste menjadi *.env*

3. Variabel-variabel yang harus diisi di file *.env* antara lain
    - DB_DATABASE
    - DB_USERNAME
    - DB_PASSWORD
    - PUSHER_APP_ID (opsional)
    - PUSHER_APP_KEY (opsional)
    - PUSHER_APP_SECRET (opsional)
    - PUSHER_APP_CLUSTER (opsional)
    - SENTRY_LARAVEL_DSN (opsional, jika menggunakan sentry)
    - SENTRY_TRACES_SAMPLE_RATE (opsional, jika menggunakan sentry)

4. Install package, library, dan dependency yang diperlukan dengan menggunakan perintah
    ```bash
    composer install
    ```

5. Migrate dan seed database menggunakan perintah
    ```bash
    php artisan migrate --seed
    ```

6. Generate *APP_KEY* pada file *.env* menggunakan perintah
    ```bash
    php artisan key:generate
    ```

7. *Optimize* menggunakan perintah
    ```bash
    php artisan optimize
    ```

8. Jalankan aplikasi secara lokal menggunakan perintah
    ```bash
    php artisan serve
    ```

9. Jika langkah-langkah sebelumnya sudah dilakukan semua, seharusnya aplikasi sudah dapat diakses di browser melalui url *http://127.0.0.1:8000*, dan jangan lupa untuk menyalakan *mysql* di *XAMPP*

10. Akun (username) yang dapat dipakai untuk login antara lain
    - admin
    - operator
    - kasir

    Semua akun menggunakan password *123123*

## Kontributor (Kelompok 3)
- [Muhammad Novil Fahlevy](https://github.com/novilfahlevy)
- [Alisanabela Nasrun](https://github.com/alisanabela13)
- [Yudha Indra Permana](https://github.com/yudhaip)
- [Roofi Ali Raditya](https://github.com/roopi2203)
- [Farkhanudin](https://github.com/farhan90909)
- Niken Astrid Pradiva Putri
- Fariz Dwi Januardi
