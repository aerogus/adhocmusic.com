# ADHOCMUSIC.COM

https://www.adhocmusic.com

## Prérequis

- node
- npm
- composer
- docker

## Installation

ajouter la ligne suivante dans `/etc/hosts` :

```
127.0.0.1 adhocmusic.test www.adhocmusic.test static.adhocmusic.test php.adhocmusic.test mysql.adhocmusic.test pma.adhocmusic.test
```

1er démarrage :

```
cd ~/workspace
git clone git@bitbucket.org:adhocmusic/adhocmusic.com.git
cd adhocmusic.com
composer install
npm install
npm run build
npm start
```

Redémarrage avec reconstruction des containers :

```
docker-compose down && docker-compose up --build
```

ou directement npm start
