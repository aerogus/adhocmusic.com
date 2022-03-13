# ADHOCMUSIC.COM

https://www.adhocmusic.com

## Prérequis

- [docker](https://www.docker.com/products/docker-desktop)
- [Node.js](https://nodejs.org/en/)
- [npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [composer](https://getcomposer.org/)

## Installation

ajouter les lignes suivantes dans `/etc/hosts` :

```
127.0.0.1 adhocmusic.test www.adhocmusic.test static.adhocmusic.test php.adhocmusic.test mariadb.adhocmusic.test pma.adhocmusic.test
::1       adhocmusic.test www.adhocmusic.test static.adhocmusic.test php.adhocmusic.test mariadb.adhocmusic.test pma.adhocmusic.test

```

1er démarrage et développement :

```
cd ~/workspace
git clone git@github.com:aerogus/adhocmusic.com.git
cd adhocmusic.com
composer install
npm install
npm run stylus
docker-compose up
```

note:
autoriser les certificats autosignés pour (www.)adhocmusic.test et static.adhocmusic.test

Redémarrage avec reconstruction des containers :

```
docker-compose down && docker-compose up --build
```

ou directement npm start

Construction pour la prod :

```
composer install --no-dev
npm install --only=prod
npm run stylus
```

## Format des images

Les `Photo` sont redimensionnées en 2048*2048 à leur arrivées
elles sont converties en :

- 1000x0
- 680x0
- 320x0

Les `Video` doivent avoir une miniature 320x180
