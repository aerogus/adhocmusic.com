# ADHOCMUSIC.COM

https://adhocmusic.com

## Prérequis globaux :

- node
- npm
- composer
- docker

## Installation du projet :

ajouter la ligne suivante dans /etc/hosts :

```
127.0.0.1 adhocmusic.test www.adhocmusic.test static.adhocmusic.test php.adhocmusic.test mysql.adhocmusic.test pma.adhocmusic.test
```

1er Démarrage :

```
cd ~/workspace
git clone git@bitbucket.org:adhocmusic/adhocmusic.com.git
cd adhocmusic.com
npm install
composer install
./node_modules/.bin/brunch build --production
docker-compose up
```

Redémarrage avec reconstruction des containers :

```
docker-compose down && docker-compose up --build
```

ou directement npm start
