#!/bin/sh
# pour tester si l'ensemble des fichiers php compilent bien
for fichier in `ls *.php`
do
    php5 -l $fichier
done

