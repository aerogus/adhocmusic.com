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
git clone git@github.com:aerogus/adhocmusic.com.git
```

Aller dans le répertoire local

```bash
cd adhocmusic.com
```

Importer une configuration prête pour un développment sous Docker

```bash
cp conf/conf.dist.ini conf/conf.ini
```

Générer un certificat TLS/SSL autosigné (prérequis = `openssl`)

```bash
openssl req -newkey rsa:2048 -nodes -keyout ./docker/nginx/ssl/docker.adhocmusic.com.key -x509 -days 365 -out ./docker/nginx/ssl/docker.adhocmusic.com.crt -subj "/C=FR/ST=Ile-de-France/L=Paris/O=AD'HOC/OU=IT/CN=docker.adhocmusic.com" -addext "subjectAltName=DNS:docker.adhocmusic.com,DNS:*.docker.adhocmusic.com"
```

Installer les dépendances PHP et JavaScript

```bash
composer install
npm install
````

Après avoir installé et démarré le service `Docker` (sous `MacOS` avec `homebrew`: `brew install docker-desktop`), créer les images docker et instancier les conteneurs

```bash
docker-compose up [--build]
```

Au niveau `DNS`, les domaines `docker.adhocmusic.com` et `*.docker.adhocmusic.com` sont configurés publiquement pour pointer sur la boucle locale (`127.0.0.1`).

Avec votre navigateur, allez sur https://docker.adhocmusic.com et https://static.docker.adhocmusic.com et acceptez les avertissements de sécurité causés par l'autosignature des certificats `TLS` plus haut.

Redémarrage avec reconstruction des containers :

```bash
docker-compose down && docker-compose up --build
```

ou directement `npm start`

Construction pour la prod :

```bash
composer install --no-dev
npm install --only=prod
```

## Analyse statique du code

```bash
composer stan # PHPStan
composer pcs # PHP Code Sniffer
composer tcs # Twig Code Sniffer
composer eslint # eslint
```

## Format des images

Les `Photo` sont redimensionnées en 2048*2048 à leur arrivée
elles sont converties en :

- 1000x0
- 680x0
- 320x0

Les `Video` doivent avoir une miniature 320x180

## Dépendances front

https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js
