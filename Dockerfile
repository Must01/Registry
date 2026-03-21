FROM composer:latest AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader

FROM php:8.3-fpm-alpine
RUN apk add --no-cache nodejs npm
RUN docker-php-ext-install pdo_mysql exif pcntl bcmath
RUN mkdir -p /var/www/html/storage/logs \
             /var/www/html/storage/framework/cache \
             /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/bootstrap/cache \
             /tmp
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
COPY . /var/www/html
COPY --from=composer /app/vendor /var/www/html/vendor
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN npm install && npm run build
CMD ["php-fpm"]
