#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --no-dev --optimize-autoloader

npm install
npm run build

touch database/database.sqlite

php artisan migrate --force --seed

php artisan config:cache
php artisan route:cache
php artisan view:cache
