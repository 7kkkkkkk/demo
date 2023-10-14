FROM php:8.1-fpm

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 设置环境变量以允许 Composer 以超级用户权限运行
ENV COMPOSER_ALLOW_SUPERUSER 1

# 设置工作目录
WORKDIR /var/www

# 安装 PHP 扩展和必要的依赖
RUN apt-get update && \
    apt-get install --no-install-recommends \
    --no-install-suggests -qq \
    -y git unzip libicu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY demo /var/www

# 安装 Composer 依赖
RUN composer install --no-scripts --no-autoloader --working-dir=/var/www/demo

# 更改权限
RUN chmod -R 777 /var/www/demo/writable

EXPOSE 9000

CMD ["php-fpm"]