FROM php:8.0-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/


# RUN apt-get update && \
#     apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
#     pecl install apcu && \
#     docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
#     docker-php-ext-install -j$(nproc) zip opcache intl pdo_pgsql pgsql && \
#     docker-php-ext-enable apcu pdo_pgsql sodium && \
#     apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \

RUN install-php-extensions apcu zip opcache intl pdo_pgsql pgsql

ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then install-php-extensions xdebug; fi

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o ; wait-for-it db:5432 -- bin/console doctrine:migrations:migrate ;  php-fpm 

EXPOSE 9000
