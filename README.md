AD'HOC
======

http://www.adhocmusic.com

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
{{{brew install node}}}

* bower (gestionnaire de dépendances front-end)
{{{ npm install -g bower}}}

* composer (gestionnaire de dépendances back-end php)
{{{ curl -sS https://getcomposer.org/installer | php }}}
{{{ mv composer.phar /usr/local/bin/composer }}}

* brunch (project builder et task runner)
{{{ npm install -g brunch }}}

Installation du projet :
========================

{{{ git clone git:git.ouifm.fm:festival.git }}}
- clonage local du repository

{{{ npm install }}}
- met à jour les dépendances npm du projet

{{{ bower install }}}
- met à jour les dépendances js/css définies dans bower.json

{{{ composer install }}}
{{{ composer update }}}
- met à jour les dépendances php définies dans composer.json

{{{ brunch b }}}
{{{ brunch b --production }}}
 - copie app/assets dans public
 - concatène/minifie les css et js
