FROM php:8.0.11-fpm
LABEL maintainer="guillaume@seznec.fr"

# maj complète et install des paquets utiles
# cette image contient déjà l'extension php mbstring
# ajout du module GD compilé avec support gif/png/jpeg
RUN apt-get update && apt-get install -y \
  locales \
  libpng-dev \
  libjpeg62-turbo-dev \
  && docker-php-ext-configure gd --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install -j$(nproc) exif \
  && docker-php-ext-install -j$(nproc) mysqli

RUN sed -i 's/# fr_FR.UTF-8 UTF-8/fr_FR.UTF-8 UTF-8/' /etc/locale.gen && locale-gen

ENV LANGUAGE=fr_FR.UTF-8
ENV LC_ALL=fr_FR.UTF-8
ENV LC_CTYPE=UTF-8
ENV LANG=fr_FR.UTF-8
