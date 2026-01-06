FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libicu-dev \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP necesarias para Moodle
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    intl \
    soap \
    opcache

# Habilitar extensiones adicionales
RUN docker-php-ext-enable \
    pdo_pgsql \
    pgsql

# Configurar directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Crear directorio moodledata
RUN mkdir -p moodledata && chmod 777 moodledata

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]