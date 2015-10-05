#!/usr/bin/env bash

echo "This is the good version of a file." > file.txt
git add file.txt
git commit -m "Very imporant piece of work"
echo "I have accidentally deleted my work!" > file.txt
git commit -a --amend -m "Accidental change"
