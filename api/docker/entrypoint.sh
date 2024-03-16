#!/bin/bash

env >> /etc/environment

php artisan migrate --force

php artisan optimize:clear
php artisan optimize

chmod -R 777 /var/www/storage
chmod -R 777 /var/www/bootstrap/cache

# chown -R www-data:www-data /var/www

/usr/local/bin/apache2-foreground


tail -f /dev/null

