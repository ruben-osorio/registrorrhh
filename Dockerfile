# SSRP - Sub-Sistema de Registro de Personal
# Imagen para Railway: PHP 8.4 + Apache
FROM php:8.4-apache

# Extensiones PHP requeridas por la aplicación
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" mysqli gd calendar bcmath \
    && rm -rf /var/lib/apt/lists/*

# Configuración PHP (producción + compatibilidad del código legado)
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php.ini "$PHP_INI_DIR/conf.d/zz-ssrp.ini"

# Apache: escuchar en el puerto que asigna Railway ($PORT)
ENV PORT=8080
RUN a2enmod rewrite headers \
    && sed -ri 's/^Listen 80$/Listen ${PORT}/' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf \
    && printf 'ServerName localhost\nServerTokens Prod\nServerSignature Off\n' > /etc/apache2/conf-available/ssrp.conf \
    && a2enconf ssrp

# Código de la aplicación
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/ssrp-entrypoint
RUN chmod +x /usr/local/bin/ssrp-entrypoint

EXPOSE 8080
ENTRYPOINT ["ssrp-entrypoint"]
CMD ["apache2-foreground"]
