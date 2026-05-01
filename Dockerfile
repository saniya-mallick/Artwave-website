FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY Saniya_Mallick/code/ /var/www/html/

EXPOSE 80