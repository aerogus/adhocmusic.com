FROM php:7.2-fpm
LABEL maintainer="guillaume@seznec.fr"

ENV DEBIAN_FRONTEND noninteractive
ENV TIMEZONE Europe/Paris

# maj complète et install des paquets utiles
# cette image contient déjà l'extension php mbstring
RUN apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y locales \
  && docker-php-ext-install gettext \
  && docker-php-ext-install mysqli \
  && docker-php-ext-install gd \
  && apt-get autoremove \
  && apt-get clean

# configuration de l'heure
RUN echo $TIMEZONE > /etc/timezone && dpkg-reconfigure tzdata

# Set la locale fr
ENV LC_ALL fr_FR.UTF-8
ENV LANG fr_FR.UTF-8
ENV LANGUAGE fr_FR.UTF-8
RUN echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && locale-gen

COPY php.ini /usr/local/etc/php/

RUN mkdir /var/log/php \
  && chmod 777 /var/log/php
