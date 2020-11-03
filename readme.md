## TokBuk

TokBuk adalah aplikasi pengelolaan toko buku yang dapat digunakan oleh owner toko buku manapun untuk mengelola dan mencatat atau merekam riwayat pengadaan stok buku atau barang-barang dari supplier, pembelian buku oleh pelanggan, dan mengelola lokasi atau tata letak buku dan barang-barang lainnya.

## Bahan atau software yang diperlukan
- [Composer](https://getcomposer.org)
- [Git](https://git-scm.com/downloads)
- [XAMPP](https://www.apachefriends.org/download.html)

## Instalasi
1. Clone repo ini, dengan menggunakan perintah :

    ```
    git clone https://github.com/novilfahlevy/TokBuk.git
    ```

2. Copy file *.env.example* dan paste menjadi *.env*

3. Variabel-variabel yang harus diisi di file *.env* antara lain :
    - DB_DATABASE
    - DB_USERNAME
    - DB_PASSWORD
    - PUSHER_APP_ID
    - PUSHER_APP_KEY
    - PUSHER_APP_SECRET
    - PUSHER_APP_CLUSTER
    - SENTRY_LARAVEL_DSN (diisi jika menggunakan sentry)
    - SENTRY_TRACES_SAMPLE_RATE (diisi jika menggunakan sentry)

4. Install package, library, dan dependency yang diperlukan dengan menggunakan perintah
    ```
    composer install
    ```

5. Migrate dan seed database menggunakan perintah
    ```
    php artisan migrate --seed
    ```

6. Generate *APP_KEY* pada file *.env* menggunakan perintah
    ```
    php artisan key:generate
    ```

7. *Optimize* menggunakan perintah
    ```
    php artisan optimize
    ```

8. Jalanakan aplikasi secara lokal menggunakan perintah
    ```
    php artisan serve
    ```

9. Jika langkah-langkah diatas sudah dilakukan semua, seharusnya aplikasi sudah dapat diakses di browser melalui url *http://127.0.0.1:8000*

## Kontributor (Kelompok 3)
- [Muhammad Novil Fahlevy](https://github.com/novilfahlevy) - Backend Developer
- [Alisanabela Nasrun](https://github.com/alisanabela13) - Backend Developer
- [Yudha Indra Permana](https://github.com/yudhaip) - Frontend Developer
- [Roofi Ali Raditya](https://github.com/roopi2203) - Frontend Developer
- [Farkhanudin](https://github.com/farhan90909) - Frontend Developer
- Niken Astrid Pradiva Putri - Analis
- Fariz Dwi Januardi - Desainer