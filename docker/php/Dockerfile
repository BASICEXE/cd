FROM php:7.2-apache
# FROM php:7.2-fpm                                        
COPY php.ini /usr/local/etc/php/                                        
                                        
RUN apt update \                                        
  && apt install -y default-mysql-client \                                        
  libbz2-dev \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  # libpng12-dev \
  # libxpm-dev \
  # libvpx-dev \
  libmcrypt-dev \
  # libmemcached-dev \
  && docker-php-ext-install pdo_mysql gd

WORKDIR /var/www

# ユーザーを追加

ENV UID=1000
ENV GID=1000
RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

RUN chown -R www-data:www-data /var/www

