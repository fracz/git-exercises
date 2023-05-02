#!/usr/bin/env bash

echo "2" > second.txt
git add second.txt
git commit -m "This should be the second commit"
echo "1" > first.txt
git add first.txt
git commit -m "This should be the first commit"
