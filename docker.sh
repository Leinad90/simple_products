

docker run -d -p 8080:80 --name my-apache-php-app -v "$PWD":/var/www/html php:8.3-apache