FROM php:7.2.2-fpm
LABEL maintainer="guillaume@seznec.fr"

# maj complète et install des paquets utiles
# cette image contient déjà l'extension php mbstring
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libjpeg62-turbo-dev \
  && docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install -j$(nproc) mysqli \
  && apt-get autoremove \
  && apt-get clean
