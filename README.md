# ADHOCMUSIC.COM

https://adhocmusic.com

## Technos utilisées

* Stylus (pré-processeur CSS)
  https://learnboost.github.io/stylus/

## Outils de build requis :

* npm (node package manager), fourni avec node.js
`brew install node`

* composer (gestionnaire de dépendances back-end php)
`curl -sS https://getcomposer.org/installer | php`
`mv composer.phar /usr/local/bin/composer`

* brunch (project builder et task runner)
`npm install -g brunch`

## Installation du projet :

# Clone localement le repository
`git clone git@bitbucket.org:adhocmusic/adhocmusic.com.git`

# Installe les dépendances npm définies dans package.json
`npm install`

# Installe les dépendances composer (php) définies dans composer.json
`composer install`

# Compile, concatène, minifie, exporte l'application dans public
`brunch b -p`

# Crée les répertoires de log, de cache et de media et les rend accessible en écriture au serveur web
`mkdir log && chmod 777 log`
`mkdir cache cache/img cache/smarty && chmod 777 cache/*`
`mkdir media media/audio media/photo media/video && chmod 777 media/*`

# charger la procédure stockée MySQL en invoquant la méthode suivante :
Lieu::mysql_init_geo();

