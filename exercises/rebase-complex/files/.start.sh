#!/usr/bin/env bash

echo "Hello" > file.txt
git add file.txt
git commit -m "Base commit for rebase complex"

git branch -D your-master
git checkout -b your-master
echo "World" >> file.txt
git commit -am "First commit in your-master"
echo "Or mundo" >> file.txt
git commit -am "Second commit in your-master"

git checkout rebase-complex
echo "Issue" > issue.txt
git add issue.txt
git commit -m "First issue commit"
echo "Bug" > bug.txt
git add bug.txt
git commit -m "First commit fixing bug"
echo "Bug fixed!" >> bug.txt
git commit -am "Bug finally fixed"

git checkout HEAD^^
git branch -D issue-555
git checkout -b issue-555
echo "More work on issue" >> issue.txt
git commit -am "More work on issue"
echo "Even more work on issue" >> issue.txt
git commit -am "Evnt more work on issue"

git checkout rebase-complex
