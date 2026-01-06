FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libxml2-dev libicu-dev git unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql gd zip intl soap opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .
RUN mkdir -p moodledata && chmod 777 moodledata
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]