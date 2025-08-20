FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 777 /var/www/html

RUN mkdir -p /var/www/html/data \
    && chown www-data:www-data /var/www/html/data \
    && chmod 777 /var/www/html/data

EXPOSE 80

CMD ["apache2-foreground"]
