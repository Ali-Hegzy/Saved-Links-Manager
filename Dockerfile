FROM php:8.3-cli-alpine

RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite-dev \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_sqlite pcntl bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# نسخ ملفات المشروع
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN if [ -f "package.json" ]; then npm install && npm run build; fi

RUN mkdir -p /var/www/storage /var/www/bootstrap/cache /var/www/database \
    && touch /var/www/database/database.sqlite \
    && chmod -R 777 /var/www/storage /var/www/bootstrap/cache /var/www/database

EXPOSE 8080

CMD php artisan config:clear && \
    php artisan migrate --force --seed && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
