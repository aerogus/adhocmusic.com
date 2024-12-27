#!/usr/bin/env bash
##
# backup de la base de données
##

ABS_PATH="$( cd "$(dirname "$0")" || return; pwd -P )"

MYSQLDUMP_BIN=$(command -v mysqldump)

DB_HOST="localhost"
DB_USER="root"
DB_NAME="adhocmusic"
BACKUP_PATH="$ABS_PATH/backup"
BACKUP_FILE="$BACKUP_PATH/$DB_NAME.$(date +%Y%m%d%H%M%S).sql"

echo "Archivage base de données AD'HOC"

if [[ ! $MYSQLDUMP_BIN ]]; then
  echo "[ERREUR] commande mysldump introuvable"
  exit 1
fi

if [[ ! -d "$BACKUP_PATH" ]]; then
  echo "Création répertoire backup"
  mkdir "$BACKUP_PATH"
fi

echo "Dump base"
mysqldump -h "$DB_HOST" -u "$DB_USER" -p "$DB_NAME" > "$DB_NAME".sql
echo "Compression fichier"
tar czf "$BACKUP_FILE.tgz" "$BACKUP_FILE"
echo "ménage"
rm "$BACKUP_FILE"
echo "fin"
