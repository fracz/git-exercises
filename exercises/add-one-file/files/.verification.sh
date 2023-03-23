#!/bin/bash
err=0

if [ "$(git diff --cached --name-only)" == "" ]
then
	echo "The file new.txt has not been staged"
	err=1
fi

if [ $err -eq 0 -a "$(git diff --cached --name-only)" != "new.txt" ]
then
	echo Only new.txt should be staged
	err=2
fi

if [ $err -gt 0 ]
then
	exit $err
else
	git commit -m "Files added to the staging area" &>/dev/null
fi
   
