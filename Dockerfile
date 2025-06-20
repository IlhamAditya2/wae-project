# Gunakan image dasar PHP yang sudah memiliki Nginx dan PHP-FPM
# richarvey/nginx-php-fpm adalah image populer yang cocok untuk Laravel
FROM richarvey/nginx-php-fpm:latest

# Atur direktori kerja di dalam kontainer
WORKDIR /var/www/html

# Salin semua file proyek dari komputer lokal Anda ke dalam kontainer
# Ini harus dilakukan SETELAH RUN composer install, untuk memanfaatkan Docker caching layer
COPY . /var/www/html

# Instal dependensi Composer (richarvey/nginx-php-fpm biasanya sudah punya Composer)
# --no-dev: Hanya instal dependensi produksi
# --optimize-autoloader: Mengoptimalkan autoloader untuk performa
RUN composer install --no-dev --optimize-autoloader

# Hapus cache Laravel yang tidak perlu untuk lingkungan produksi
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear

# Setel izin (permissions) untuk folder storage dan bootstrap/cache
# Ini krusial agar Laravel bisa menulis log, cache, dll.
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Ekspos port default Nginx
EXPOSE 80

# Command default yang dijalankan saat kontainer dimulai (sudah ada di image dasar)
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]