# ADHOCMUSIC.COM

https://www.adhocmusic.com

## Prérequis

- [docker](https://www.docker.com/products/docker-desktop)
- [Node.js](https://nodejs.org/en/)
- [npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [composer](https://getcomposer.org/)

## Installation

1er démarrage et développement :

Récupérer le dépôt

```bash
cd ~/workspace
git clone git@github.com:aerogus/adhocmusic.com.git
cd adhocmusic.com
```

Générer un certificat TLS/SSL autosigné (prérequis = openssl)

```bash
openssl req -newkey rsa:2048 -nodes -keyout ./docker/nginx/ssl/docker.adhocmusic.com.key -x509 -days 365 -out ./docker/nginx/ssl/docker.adhocmusic.com.crt -subj "/C=FR/ST=Ile-de-France/L=Paris/O=AD'HOC/OU=IT/CN=docker.adhocmusic.com" -addext "subjectAltName=DNS:docker.adhocmusic.com,DNS:*.docker.adhocmusic.com"
```

Installer les dépendances

```bash
composer install
npm install
npm run stylus
````

Créer les images docker et instancer les conteneurs

```bash
docker-compose up [--build]
```

Aller sur https://docker.adhocmusic.com

Au niveau DNS, `docker.adhocmusic.com` et `*.docker.adhocmusic.com` sont configurés publiquement pour pointer sur la boucle locale (`127.0.0.1`).

note: la navigateur émet un warning car on a généré des certificats autosignés

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
