FROM nginx:1.29.1

LABEL maintainer="guillaume@seznec.fr"

RUN apt-get update && apt-get install -y \
    locales

RUN sed -i 's/# fr_FR.UTF-8 UTF-8/fr_FR.UTF-8 UTF-8/' /etc/locale.gen && locale-gen

ENV LANGUAGE=fr_FR.UTF-8
ENV LC_ALL=fr_FR.UTF-8
ENV LC_CTYPE=UTF-8
ENV LANG=fr_FR.UTF-8
