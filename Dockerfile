FROM php:8.2-apache

# 1. Cài đặt các system dependencies và PHP extensions cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Bật Apache mod_rewrite để Laravel routing hoạt động
RUN a2enmod rewrite

# 3. Cấu hình lại Apache DocumentRoot trỏ vào thư mục public của dự án
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Cài đặt Composer từ image chính thức
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Thiết lập thư mục làm việc
WORKDIR /var/www/html

# 6. Copy toàn bộ mã nguồn vào container
COPY . .

# 7. Cài đặt các PHP dependencies (loại bỏ dev tools để tối ưu dung lượng)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 8. Phân quyền cho thư mục storage và bootstrap/cache để Laravel có thể ghi file
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Cấu hình lại để Apache tự động nhận Port linh hoạt từ Render cấp phát
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g' /etc/apache2/sites-available/*.conf

# 10. Chạy Apache ở chế độ foreground
CMD ["apache2-foreground"]