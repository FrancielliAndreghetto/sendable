FROM php:8.2-fpm

# Instala dependências PHP
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libonig-dev libpng-dev libxml2-dev zip curl \
    nodejs npm \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia o composer.json e package.json para otimizar build
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Instala dependências PHP e Node.js
RUN composer install --no-dev --optimize-autoloader
RUN npm install

# Copia todo código
COPY . .

# Build dos assets (React + Vite ou Mix)
RUN npm run build

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
