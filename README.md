# ADHOCMUSIC.COM

https://www.adhocmusic.com

## Prérequis

- docker
- node
- npm
- composer

## Installation

ajouter la ligne suivante dans `/etc/hosts` :

```
127.0.0.1 adhocmusic.test www.adhocmusic.test static.adhocmusic.test php.adhocmusic.test mariadb.adhocmusic.test pma.adhocmusic.test
```

1er démarrage et développement :

```
cd ~/workspace
git clone git@bitbucket.org:adhocmusic/adhocmusic.com.git
cd adhocmusic.com
composer install (dépendances php)
npm install (dépendances js)
npm run serve (brunch watch)
npm start (docker-compose up)
```

Redémarrage avec reconstruction des containers :

```
docker-compose down && docker-compose up --build
```

ou directement npm start
