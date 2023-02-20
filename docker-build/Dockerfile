FROM php:8.1.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libssl-dev \
    iputils-ping

# Install rdkafka
RUN ( \
            cd /tmp \
            && mkdir librdkafka \
            && cd librdkafka \
            && git clone https://github.com/edenhill/librdkafka.git . \
            && ./configure \
            && make \
            && make install \
        ) \
    && rm -r /var/lib/apt/lists/*

# Install RDKafka
RUN pecl install rdkafka && docker-php-ext-enable rdkafka

#Enbaled pdo_mysql
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Install Mongodb
RUN pecl install mongodb && docker-php-ext-enable mongodb


RUN usermod -u 1000 www-data

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Swoole
RUN pecl install swoole
RUN docker-php-ext-enable swoole

# Install Redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

EXPOSE 9501

####### To Build #######
RUN chown www-data.www-data /var/www
RUN chown www-data.www-data $(composer config --global home)
RUN chmod 770 /var/www
COPY . /var/www/
RUN composer install
RUN chmod +x /var/www/docker-entrypoint.sh
USER www-data
ENTRYPOINT [ "/var/www/docker-entrypoint.sh" ]
