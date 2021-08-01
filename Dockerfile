FROM php:7.4
LABEL author="Ady"

RUN useradd -ms /bin/bash captcha

RUN apt update && \
    apt install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php

RUN apt install -y wget make unzip nano curl sudo

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer self-update

RUN echo "captcha  ALL=(ALL) NOPASSWD:ALL" | sudo tee /etc/sudoers.d/captcha

USER captcha

WORKDIR /app
