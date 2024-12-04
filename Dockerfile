# Используем образ PHP с поддержкой FPM
FROM php:7.4-fpm

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install pdo pdo_mysql

# Копируем файлы приложения в контейнер
COPY app /var/www/html

# Устанавливаем Nginx
RUN apt-get update && apt-get install -y nginx \
    && rm /etc/nginx/sites-enabled/default

# Копируем конфигурацию Nginx
COPY nginx/default.conf /etc/nginx/conf.d/

# Открываем порт 80
EXPOSE 80

# Запускаем Nginx и PHP-FPM
CMD service nginx start && php-fpm
