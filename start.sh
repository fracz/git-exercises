#!/usr/bin/env bash

git branch -D hot-bugfix
echo "This is content of file.txt" > file.txt
echo "This is a bug" > buggy.txt
git add file.txt
git add buggy.txt
git commit -m "Base of work"
echo "This is better content of file.txt" > file.txt
git commit -am "Work on an issue"
git branch hot-bugfix HEAD^
git checkout hot-bugfix
echo "Bug removed" > buggy.txt
git commit -am "Bug fix"
git checkout change-branch-history
