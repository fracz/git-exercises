#!/usr/bin/env bash

git branch -D escaped
git checkout -b escaped
echo "Sample content" > file.txt
git add file.txt
git commit -m "First escaped commit"
echo "More content" >> file.txt
git commit -am "Second escaped commit"
git checkout chase-branch
