#!/usr/bin/env bash

echo "First" > first.txt
echo "Second" > second.txt
git add first.txt second.txt
git commit -m "This commit needs to be splitted"
