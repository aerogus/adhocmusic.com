FROM nginx:1.10.3

LABEL maintainer="guillaume@seznec.fr"

RUN ln -s /var/www/adhocmusic.test/static /static

#COPY ./nginx.conf /etc/nginx/nginx.conf

# créer les certificats avec cette commande (Common name doit être *.adhocmusic.test)
#openssl req -newkey rsa:2048 -nodes -keyout ./ssl/adhocmusic.test.key -x509 -days 365 -out ./ssl/adhocmusic.test.crt

#COPY ./ssl/adhocmusic.test.crt /etc/nginx/ssl/adhocmusic.test.crt
#COPY ./ssl/adhocmusic.test.key /etc/nginx/ssl/adhocmusic.test.key