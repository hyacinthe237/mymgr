rm -Rf bootstrap/cache/* && chmod 0777 bootstrap/cache
php artisan queue:restart
php artisan migrate
php artisan config:clear
php artisan view:clear
# php artisan route:cache

sudo find . -type f -exec chmod 664 {} \;   
sudo find . -type d -exec chmod 775 {} \;