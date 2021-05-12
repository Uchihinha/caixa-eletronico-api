#!/bin/bash
echo "Aliasing $FRAMEWORK"
sudo ln -s /etc/nginx/sites/$FRAMEWORK.conf /etc/nginx/sites/enabled.conf

# cp .env.example .env

# php artisan config:cache

# php artisan migrate --database=pgsql_test

# php artisan migrate --seed

# php artisan passport:install

nohup /usr/sbin/php-fpm -y /etc/php7/php-fpm.conf -F -O 2>&1 &

nohup php /var/www/app/artisan queue:work --verbose --tries=3 --timeout=90 &

nginx
