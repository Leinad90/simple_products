FROM php:8.1-apache

#RUN apt-get update && apt-get install -y php5-mysql && apt-get clean

COPY . /var/www/html/