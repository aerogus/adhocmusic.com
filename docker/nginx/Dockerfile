FROM nginx:1.14.1

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
# (Common name doit être *.adhocmusic.test)
#
# ```
# openssl req -newkey rsa:2048 -nodes -keyout ./ssl/adhocmusic.test.key -x509 -days 365 -out ./ssl/adhocmusic.test.crt
# ```
#
# le docker-compose.yml se charge de faire les volumes nécessaires
