FROM php:8.2-apache

# 1. Instalace závislostí, PHP modulů, vyčištění cache a povolení mod_rewrite
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git libxml2-dev libpng-dev libjpeg-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql dom gd \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Kopírování konfigurace Apache a instalace Composeru
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN git config --global --add safe.directory /var/www/html

WORKDIR /var/www/html

# 3. Zkopírování souborů aplikace do kontejneru (nutné pro Composer)
COPY . .

# 4. Instalace závislostí přes Composer
RUN composer require dompdf/dompdf:^3.0