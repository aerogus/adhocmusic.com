FROM nginx:1.27.2

LABEL maintainer="guillaume@seznec.fr"

RUN apt-get update && apt-get install -y \
    locales

RUN sed -i 's/# fr_FR.UTF-8 UTF-8/fr_FR.UTF-8 UTF-8/' /etc/locale.gen && locale-gen

ENV LANGUAGE=fr_FR.UTF-8
ENV LC_ALL=fr_FR.UTF-8
ENV LC_CTYPE=UTF-8
ENV LANG=fr_FR.UTF-8

##
# Certificat TLS/SSL
##
# openssl n'est pas présent dans le container
# pour générer/renouveler les certificatq TLS/SSL autosignés, exécuter la commande suivante sur un poste disposant d'openssl:
# (Common name doit être *.docker.adhocmusic.com + docker.adhocmusic.com)
#
# ```
# openssl req -newkey rsa:2048 -nodes -keyout ./ssl/docker.adhocmusic.com.key -x509 -days 365 -out ./ssl/docker.adhocmusic.com.crt -subj "/C=FR/ST=Ile-de-France/L=Paris/O=AD'HOC/OU=IT/CN=docker.adhocmusic.com" -addext "subjectAltName=DNS:docker.adhocmusic.com,DNS:*.docker.adhocmusic.com"
# ```
#
# le docker-compose.yml se charge de faire les volumes nécessaires
