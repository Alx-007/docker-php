FROM php:8.2-apache

# Instalamos la extensión para que PHP pueda hablar con MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Damos permisos a la carpeta de la web
RUN chown -R www-data:www-data /var/www/html
