cp .env.example .env
composer install
npm install
npm run prod
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/node_modules
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/node_modules
php artisan config:cache
php artisan cache:clear
php artisan view:clear
php artisan storage:link
