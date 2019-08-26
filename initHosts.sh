#!/usr/bin/env bash
##
# Ajout des hostnames des conteneurs docker
##

rules="127.0.0.1 adhocmusic.test www.adhocmusic.test static.adhocmusic.test php.adhocmusic.test mariadb.adhocmusic.test pma.adhocmusic.test"
hosts="/etc/hosts"

if ! grep -q "$rules" $hosts; then
  echo "Règles de hosts qui vont être ajoutées dans $hosts (nécessite root)"
  echo "$rules"
  echo "$rules" >> $hosts
else
  echo "Règles de hosts pour adhocmusic.test OK dans $hosts"
fi
