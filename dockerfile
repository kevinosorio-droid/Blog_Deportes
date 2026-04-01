# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilita extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia configuración PHP personalizada
# usarla solo si el archvio envia mas de 1000 variables que exceden el limite en php 
COPY config/config.ini /usr/local/etc/php/conf.d/

# Copia todos los archivos del proyecto al contenedor
COPY . /var/www/html/

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto del servidor Apache
EXPOSE 80
