#!/usr/bin/env bash

echo "This is base version of the program." > program.txt
echo "It has only two lines at the beginning." >> program.txt
git add program.txt
git commit -m "Base version of a program"

git branch -D feature-a
git checkout -b feature-a
echo "This is complete feature A" >> program.txt
git commit -am "Implement Feature A"

git branch -D feature-b
git checkout HEAD^
git checkout -b feature-b
mv program.txt program_temp.txt
echo "This is complete feature B" > program.txt
cat program_temp.txt >> program.txt
rm program_temp.txt
git commit -am "Implement Feature B"

git branch -D feature-c
git branch feature-c HEAD^
git checkout feature-c
echo "This is first part Feature C" >> program.txt
git commit -am "Implement part of Feature C"
echo "This is second part of Feature C" >> program.txt
git commit -am "Complete Feature C"

git checkout pick-your-features
