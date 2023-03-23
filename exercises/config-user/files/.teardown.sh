#!/bin/bash

name=$(git config --get user.prevname)
email=$(git config --get user.prevemail)

git config user.name "$name"
git config user.email "$email"

git config --unset user.prevname
git config --unset user.prevemail

exit 0
