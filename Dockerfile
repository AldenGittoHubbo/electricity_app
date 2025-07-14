# Dockerfile
FROM php:8.1-apache

# Install ekstensi mysqli
RUN docker-php-ext-install mysqli

# Salin semua file ke folder web Apache
COPY app/ /var/www/html/

# Aktifkan mod_rewrite (jika CI atau login pakai redirect)
RUN a2enmod rewrite