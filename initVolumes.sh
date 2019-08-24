#!/usr/bin/env bash

##
# Création des volumes sur l'hôte docker nécessaires au fonctionnement du projet
##

ABS_PATH="$( cd "$(dirname "$0")" || return; pwd -P )"
VOL_PATH="$ABS_PATH/volumes"

dirs=(
  "$VOL_PATH"
  "$VOL_PATH/mysql"
  "$VOL_PATH/mysql/data"
  "$VOL_PATH/mysql/log"
  "$VOL_PATH/php"
  "$VOL_PATH/php/log"
)

for dir in "${dirs[@]}"; do
  if [[ ! -d "$dir" ]]; then
    echo "Création de $dir"
    mkdir "$dir"
  else
    echo "Déjà existant $dir"
  fi
done
