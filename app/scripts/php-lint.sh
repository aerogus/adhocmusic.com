#!/usr/bin/env bash

declare -a dirs=(
  "./.."
  "./../assets"
  "./../controllers"
  "./../models"
  "./../scripts"
)

reset=$(tput sgr0)
red=$(tput setaf 1)
green=$(tput setaf 76)

e_success() { printf "${green}✔ %s${reset}\n" "$@"; }
e_error() { printf "${red}✖ %s${reset}\n" "$@"; }

echo "Test syntaxique du code PHP AD'HOC"
echo "PHP v.$(php -v)"

for dir in ${dirs[@]}; do
  printf "Répertoire: %s\n" "$dir"
  for file in $dir/*.php; do
    printf "Analyse: %s " "$file"
    res=$(php -l "$file" 2>&1)
    if [[ "$res" =~ "No syntax errors detected" ]]; then
      e_success "OK"
    else
      e_error "KO"
      echo "$res"
    fi
  done
done

exit 0
