FROM alpine:3.20

RUN apk add --no-cache curl git bash unit unit-php83 \
    php83 php83-dom php83-intl php83-fileinfo php83-openssl php83-tokenizer php83-mbstring php83-pecl-xdebug php83-phar php83-session php83-xml php83-xmlwriter

COPY --from=composer:2.7.8 /usr/bin/composer /usr/bin/composer

COPY container/ /
WORKDIR /var/www/html
RUN chmod +x /usr/local/bin/local-entrypoint

ENTRYPOINT [ "/usr/local/bin/local-entrypoint" ]
