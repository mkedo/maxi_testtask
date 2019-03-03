FROM php:7.1-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo


# Install symfony
ADD maxi_currency /var/www/symfony/
ADD parameters.yml /var/www/symfony/app/config/parameters.yml

WORKDIR /var/www/symfony/
RUN composer install
RUN mkdir /var/www/symfony/var/data && \
    php bin/console doctrine:database:create && \
    php bin/console doctrine:schema:create
RUN chown -R www-data:www-data /var/www/symfony/var/

WORKDIR /var/www/symfony/web

RUN echo "memory_limit =  512M" > /usr/local/etc/php/conf.d/php.ini

# Install supervisord
RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]