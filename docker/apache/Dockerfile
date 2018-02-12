FROM httpd:2.4.25
MAINTAINER Guillaume Seznec <guillaume@seznec.fr>

ENV DEBIAN_FRONTEND noninteractive
ENV TIMEZONE Europe/Paris

# maj complète et install des paquets utiles
RUN apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y locales \
  && apt-get clean

# configuration de l'heure
RUN echo $TIMEZONE > /etc/timezone && dpkg-reconfigure tzdata

# Set la locale fr
ENV LC_ALL fr_FR.UTF-8
ENV LANG fr_FR.UTF-8
ENV LANGUAGE fr_FR.UTF-8
RUN echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && locale-gen
