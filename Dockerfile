# Imagen base con PHP y Apache
FROM php:8.2-apache

# Copiar el código al contenedor
COPY . /var/www/html/

# Dar permisos a los archivos (opcional según necesidades)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer el puerto 80
EXPOSE 80
