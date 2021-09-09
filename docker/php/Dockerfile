FROM php:7.4-fpm
# timezone
ARG TZ
RUN echo ${TZ} > /etc/timezone
# Set working directory
RUN mkdir /app
WORKDIR /app
# Install dependencies
RUN apt-get update && apt-get install -y \
  build-essential \
  libzip-dev \
  libpng-dev \
  libonig-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  locales \
  zip \
  jpegoptim optipng pngquant gifsicle \
  vim \
  unzip \
  git \
  curl \
  supervisor \
  cron \
  libmosquitto-dev
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
  composer config -g repos.packagist composer https://packagist.org
  # && \
  # composer global require hirak/prestissimo
# Install xdebug
#RUN pecl install xdebug \
#  && docker-php-ext-enable xdebug \
#  && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "xdebug.profiler_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "xdebug.profiler_output_dir=/tmp/snapshots" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "xdebug.max_nesting_level=9999" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#  && echo "xdebug.profiler_enable_trigger=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Mosquitto-alpha
RUN pecl install Mosquitto-alpha \
    && docker-php-ext-enable mosquitto

# Copy supervisord conf
COPY supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# Crontab
#COPY cron/scheduler /etc/cron.d/scheduler
#RUN crontab /etc/cron.d/scheduler
# Expose port 9000 and start supervisor: php-fpm server & worker
EXPOSE 9000
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

#FROM redis:alpine

#COPY redis.conf /usr/local/etc/redis/redis.conf
#CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]
