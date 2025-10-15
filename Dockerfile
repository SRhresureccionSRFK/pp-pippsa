# -------------------------------
# Dockerfile para SRFK++ + Vue + Render
# -------------------------------

# Imagen base PHP con Apache
FROM php:8.2-apache

# Copia todos los archivos al contenedor
COPY . /var/www/html/

# Instala extensiones PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilita mod_rewrite para .htaccess
RUN a2enmod rewrite

# Permite que .htaccess funcione
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Ajusta permisos del directorio web
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto que Render usa internamente
EXPOSE 10000

# CMD inicia Apache en primer plano
CMD ["apache2-foreground"]
