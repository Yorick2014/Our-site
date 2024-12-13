# Используем образ PHP с поддержкой FPM
FROM php:7.4-fpm

RUN echo "deb http://deb.debian.org/debian buster main" > /etc/apt/sources.list.d/buster.list
RUN apt-get update && apt-get install -y postgresql-client

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    apt-transport-https \
    ca-certificates \
    libpq-dev \
    gcc \
    make \
    autoconf \
    pkg-config \
    postgresql-client \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Удаляем дефолтный сайт Nginx
RUN rm -f /etc/nginx/sites-enabled/default

# Копируем файлы приложения в контейнер
COPY app /var/www/html

# Копируем конфигурацию Nginx
COPY nginx/default.conf /etc/nginx/conf.d/

# Указываем рабочую директорию
WORKDIR /var/www/html

# Указываем порты
EXPOSE 80

# Запускаем Nginx и PHP-FPM
CMD ["sh", "-c", "service nginx start && php-fpm"]
