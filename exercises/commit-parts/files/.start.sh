#!/usr/bin/env bash

echo "This is a program" > file.txt
echo "It is supposed to work." >> file.txt
echo "It works" >> file.txt
echo "It is quite brilliant, actually." >> file.txt
git add file.txt
git commit -m "Base version of a program"
echo "I forgot to add file header." > file.txt
echo "This is a program" >> file.txt
echo "And this is new feature done in task 1." >> file.txt
echo "It lasts for many lines as task 1 was big." >> file.txt
echo "It is supposed to work." >> file.txt
echo "It works!" >> file.txt
echo "This is not related, it is task 2." >> file.txt
echo "It is quite brilliant, actually." >> file.txt
echo "Task 1 is finished." >> file.txt
