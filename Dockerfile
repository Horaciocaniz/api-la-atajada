FROM php:8.2-apache

# Copia los archivos de tu repositorio a la carpeta del servidor Apache
COPY ./api /var/www/html

# Activa mod_rewrite si lo necesitas
RUN a2enmod rewrite

# Establece los permisos adecuados
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
