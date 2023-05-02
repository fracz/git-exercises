#!/usr/bin/env bash

echo "Hello wordl" > file.txt
git add file.txt
git commit -m "Add Hello wordl"
echo "Hello world is an excellent program." >> file.txt
git commit -am "Further work on Hello world"
