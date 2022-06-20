#!/bin/sh
chmod o+w ./storage/ -R

apk update && apk add curl && \
  curl -sS https://getcomposer.org/installer | php  \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer


cp .env.example .env
composer  install 
composer  install 

php artisan config:clear
php  artisan migrate:fresh --seed
php artisan passport:install

