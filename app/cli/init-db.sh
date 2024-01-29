#!/usr/bin/env bash
##
# Réinitialisation de la base de données
# - destruction des tables
# - création des tables
# - alimentation avec les données de référence
##

ABS_PATH="$( cd "$(dirname "$0")" || return; pwd -P )"
SQL_PATH="$ABS_PATH/../../docker/mariadb/initdb.d"

echo "INIT de la BDD"
echo "Le mot de passe adhocmusic MariaDB sera demandé"

#cat \
#"$SQL_PATH/99-drop-tables.sql" \
#| mysql -u adhocmusic -p adhocmusic

cat \
"$SQL_PATH/01-schema.sql" \
"$SQL_PATH/02-references-faq_category.sql" \
"$SQL_PATH/02-references-geo-1-country.sql" \
"$SQL_PATH/02-references-geo-2-region.sql" \
"$SQL_PATH/02-references-geo-3-departement.sql" \
"$SQL_PATH/02-references-geo-4-city.sql" \
"$SQL_PATH/02-references-lieu_type.sql" \
"$SQL_PATH/02-references-styles.sql" \
"$SQL_PATH/02-references-type_musicien.sql" \
"$SQL_PATH/02-references-video_host.sql" \
"$SQL_PATH/03-procedure.sql" \
"$SQL_PATH/04-dataset.sql" \
| mysql -u adhocmusic -p adhocmusic

echo "OK"
