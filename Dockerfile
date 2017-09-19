FROM php:5.5-apache

COPY / /var/www/html

RUN apt-get update && apt-get install -y git vim libmcrypt-dev zip unzip

EXPOSE 80

RUN docker-php-ext-install mcrypt

RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite && service apache2 restart

# Setup the Composer installer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"
