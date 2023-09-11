FROM php:fpm as php1

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql

COPY run.sh /run.sh
RUN chmod +x /run.sh
# ENTRYPOINT "/run.sh"

FROM golang:1.19.0 as golang1

WORKDIR /usr/src/server

RUN go install github.com/cosmtrek/air@latest

COPY ./src/server .

RUN go mod tidy



