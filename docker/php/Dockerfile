FROM php:7.2.2-fpm
LABEL maintainer="guillaume@seznec.fr"

# maj complète et install des paquets utiles
# cette image contient déjà l'extension php mbstring
RUN apt-get update && apt-get install -y \
  libpng-dev \
  && docker-php-ext-install gd \
  && apt-get autoremove \
  && apt-get clean
