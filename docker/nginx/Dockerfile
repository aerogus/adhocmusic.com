FROM nginx:1.10.3

LABEL maintainer="guillaume@seznec.fr"

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./conf.d/php.conf /etc/nginx/conf.d/php.conf
COPY ./sites-enabled/adhocmusic.test.conf /etc/nginx/site-enabled/adhocmusic.test.conf
