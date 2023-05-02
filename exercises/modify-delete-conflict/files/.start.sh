#!/usr/bin/env bash

echo to be modified > keep.txt
echo to be deleted > delete.txt

git add keep.txt delete.txt
git commit -m "initial commit"

git checkout -b another

echo This should be deleted > delete.txt
git add delete.txt
git rm keep.txt
git commit -m "More changes"

git checkout modify-delete-conflict

echo Changes done > keep.txt
git add keep.txt
git rm delete.txt
git commit -m "My changes"


git merge anothes
