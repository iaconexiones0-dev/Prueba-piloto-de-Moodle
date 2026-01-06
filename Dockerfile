FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libxml2-dev libicu-dev unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql gd zip intl soap opcache \
    && rm -rf /var/lib/apt/lists/*

RUN a2dismod mpm_event && a2enmod mpm_prefork rewrite

WORKDIR /var/www/html
COPY . .
RUN mkdir -p moodledata && chmod 777 moodledata && chown -R www-data:www-data .

EXPOSE 80
CMD ["apache2-foreground"]