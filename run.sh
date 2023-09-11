cd /var/www/html

php artisan migrate:fresh --seed
php artisan queue:listen database