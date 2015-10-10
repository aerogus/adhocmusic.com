AD'HOC
======

http(s)://www.adhocmusic.com

Technos utilisées
=================

* Stylus (pré-processeur CSS)
  https://learnboost.github.io/stylus/

* Bootstrap (Framework CSS)
  http://getbootstrap.com/

* AngularJS (Framework javascript)
  https://angularjs.org/


Outils de build requis :
========================

* npm (node package manager), fourni avec node.js
{{{ brew install node }}}

* bower (gestionnaire de dépendances front-end)
{{{ npm install -g bower }}}

* composer (gestionnaire de dépendances back-end php)
{{{ curl -sS https://getcomposer.org/installer | php }}}
{{{ mv composer.phar /usr/local/bin/composer }}}

* brunch (project builder et task runner)
{{{ npm install -g brunch }}}

Installation du projet :
========================

{{{ git clone git:git.adhocmusic.com:adhoc.git }}}
- clonage local du repository

{{{ npm install }}}
{{{ npm update }}}
- installe/met à jour les dépendances npm définies dans package.json

{{{ bower install }}}
{{{ bower update }}}
- installe/met à jour les dépendances bower (front) définies dans bower.json

{{{ composer install }}}
{{{ composer update }}}
- installe / met à jour les dépendances composer (php) définies dans composer.json

{{{ brunch b }}}
{{{ brunch b -P }}}
- Brunch compile, concatène, minifie, exporte l'application dans public

{{{ mkdir log && chmod 777 log }}}
- Créer un répertoire de log et le rendre accessible en écriture au serveur web

{{{ mkdir cache }}}
{{{ mkdir cache/img && chmod 777 cache/img }}}
{{{ mkdir cache/smarty && chmod 777 cache/smarty }}}
- Création des répertoires de cache nécessaires et les rendre acessibles en écriture par le serveur web
