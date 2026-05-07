FROM php:8.2-apache

# Instalace systémových závislostí a rozšíření pro PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql

# Povolení modulu mod_rewrite pro Apache (nutné pro routování)
RUN a2enmod rewrite

# Zkopírování konfigurace virtuálního hostitele
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instalace Composeru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html