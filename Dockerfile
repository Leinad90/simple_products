FROM php:8.5-apache

RUN a2enmod rewrite
# Nastavení pracovního adresáře
WORKDIR /var/www/html

# Otevření portu
EXPOSE 80