FROM php:8.1-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos de la aplicación (opcional si se usa volumen en docker-compose)
COPY . /var/www/html

# Instalar dependencias de Composer
RUN composer install --prefer-dist --no-progress

# El contenedor se quedará corriendo con el servidor embebido de PHP (modo desarrollo)
CMD [ "php", "-S", "0.0.0.0:8000", "-t", "public" ]
