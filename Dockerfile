FROM php:8.1-apache

# Enable rewrite (if quieres)
RUN a2enmod rewrite

# Copy site
COPY www/ /var/www/html/

# Ajustes permisos (si hace falta)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
