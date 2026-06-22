# ── Imagen base con PHP 8.2 (Laravel 12 requiere 8.2+) ──
FROM php:8.2-cli

# Paquetes del sistema + extensiones PHP que necesita Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libpq-dev \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-install pdo_pgsql mbstring bcmath zip \
    && rm -rf /var/lib/apt/lists/*

# Composer (copiado desde la imagen oficial)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiamos el proyecto e instalamos dependencias (sin las de desarrollo)
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan config:clear

# Render inyecta el puerto en la variable $PORT
ENV PORT=10000
EXPOSE 10000

# Al arrancar: migrate:fresh REINICIA el esquema desde cero (borra y recrea
# todas las tablas) y siembra. Esto limpia el estado inconsistente que dejó
# un deploy a medias. El guard del seeder evita duplicar datos.
CMD php artisan migrate:fresh --force --seed && php artisan serve --host 0.0.0.0 --port ${PORT}
