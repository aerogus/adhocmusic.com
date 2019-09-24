#!/usr/bin/env bash

##
# Création des volumes sur l'hôte docker nécessaires au fonctionnement du projet
##

ABS_PATH="$( cd "$(dirname "$0")" || return; pwd -P )"
VOL_PATH="$ABS_PATH/volumes"

dirs=(
  "$VOL_PATH"
  "$VOL_PATH/mariadb"
  "$VOL_PATH/mariadb/data"
  "$VOL_PATH/mariadb/log"
  "$VOL_PATH/nginx"
  "$VOL_PATH/nginx/log"
  "$VOL_PATH/php"
  "$VOL_PATH/php/log"
  "$VOL_PATH/pma"
  "$VOL_PATH/pma/log"
)

for dir in "${dirs[@]}"; do
  if [[ ! -d "$dir" ]]; then
    echo "Création de $dir"
    mkdir "$dir"
  else
    echo "Déjà existant $dir"
  fi
done
