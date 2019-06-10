FROM ubuntu:bionic
ENV DEBIAN_FRONTEND noninteractive

RUN mkdir /phone_validator
WORKDIR /phone_validator

RUN apt-get update && \
    apt-get install -y nginx php-fpm php-sqlite3 php-xml curl git zip curl && \
    apt-get clean

ADD ./nginx.config /etc/nginx/sites-available/default

VOLUME /phone_validator

EXPOSE 80

RUN service php7.2-fpm start

RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
    && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
    # Make sure we're installing what we think we're installing!
    && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
    && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot \
    && rm -f /tmp/composer-setup.*

CMD ["sh", "-c", "/etc/init.d/php7.2-fpm restart; nginx -g \"daemon off;\""]