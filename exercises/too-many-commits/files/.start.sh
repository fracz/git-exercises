#!/usr/bin/env bash

echo "This is the first line." > file.txt
git add file.txt
git commit -am "Add file.txt"
echo "This is the second line I have forgotten." >> file.txt
git commit -am "Crap, I have forgotten to add this line."
