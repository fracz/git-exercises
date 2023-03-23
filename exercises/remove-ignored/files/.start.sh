#!/usr/bin/env bash

echo "This should be ignored" > ignored.txt
git add ignored.txt
git commit -m "Add ignored.txt"
echo "ignored.txt" > .gitignore
git add .gitignore
git commit -m "Ignore ignored.txt"
