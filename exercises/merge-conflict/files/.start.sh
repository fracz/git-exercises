#!/usr/bin/env bash

git branch -D another-piece-of-work
echo 'print("? + ? = 5")' > equation.txt
git add equation.txt
git commit -m "Add equation without numbers"
git checkout -b another-piece-of-work
echo 'print("? + 3 = 5")' > equation.txt
git commit -am "Add the second number"
git checkout merge-conflict
echo 'print("2 + ? = 5")' > equation.txt
git commit -am "Add the first number"
