FROM php:8.2-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    curl zip unzip git nodejs npm \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build
RUN cp .env.example .env && php artisan key:generate --force
RUN php artisan storage:link
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8080
CMD php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080
