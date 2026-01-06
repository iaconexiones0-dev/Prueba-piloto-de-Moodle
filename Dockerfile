FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libxml2-dev libicu-dev unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql gd zip intl soap opcache \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .
RUN mkdir -p moodledata && chmod -R 777 moodledata

ENV PORT=8080
EXPOSE 8080

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t ."]