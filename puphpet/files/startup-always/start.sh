#!/bin/bash

service php-fpm start;
service memcached start;
service redis start;

cp /var/www/lb/puphpet/files/nginx.conf /etc/nginx/nginx.conf
cp /var/www/lb/puphpet/files/lb.conf /etc/nginx/sites-available/lb.conf
ln -s /var/www/lb/puphpet/files/lb.conf /etc/nginx/sites-enabled/lb.conf
service nginx restart

# websocket app start by this way
# su vagrant -c "forever start /var/www/cservice/web/serverJs/main.js --env test --database test --port 56444"