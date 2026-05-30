FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    curl zip unzip git nodejs npm libpq-dev nginx \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build
RUN cp .env.example .env && php artisan key:generate --force
RUN php artisan storage:link
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN chmod -R 777 storage bootstrap/cache

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 8080
CMD sh -c 'php artisan migrate --force && php-fpm -D && nginx -g "daemon off;"'
