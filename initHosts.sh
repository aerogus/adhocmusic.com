#!/usr/bin/env bash
##
# Ajout des hostnames des conteneurs docker
##

rules="127.0.0.1 docker.adhocmusic.com www.docker.adhocmusic.com static.docker.adhocmusic.com php.docker.adhocmusic.com mariadb.docker.adhocmusic.com pma.docker.adhocmusic.com"
hosts="/etc/hosts"

if ! grep -q "$rules" $hosts; then
  echo "Règles de hosts qui vont être ajoutées dans $hosts (nécessite root)"
  echo "$rules"
  echo "$rules" >> $hosts
else
  echo "Règles de hosts pour adhocmusic.test OK dans $hosts"
fi
