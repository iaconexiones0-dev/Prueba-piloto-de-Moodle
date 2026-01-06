FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli gd zip intl soap opcache \
    && rm -rf /var/lib/apt/lists/*

COPY . /app
WORKDIR /app

RUN mkdir -p moodledata && chmod 777 moodledata

EXPOSE 8080

CMD php -d display_errors=1 -S 0.0.0.0:8080 -t /app