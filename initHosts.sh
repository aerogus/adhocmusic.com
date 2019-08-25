#!/bin/bash
#
# Ajout des hostnames des conteneurs docker
#

rules="127.0.0.1 adhocmusic.test www.adhocmusic.test static.adhocmusic.test php.adhocmusic.test mariadb.adhocmusic.test pma.adhocmusic.test"
hosts="/etc/hosts"

if ! grep -q "$rules" $hosts; then
  echo "Règles de hosts à ajouter dans $hosts (nécessite root)"
  echo "$rules"
  echo "$rules" >> $hosts
else
  echo "Règles de hosts OK dans $hosts"
fi
