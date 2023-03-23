#!/bin/bash

err=0
name=$(git config --get --local user.name)
prevname=$(git config --get --local user.prevname)
if [ "$name" == "" ]
then
	echo "The name was not configured"
	err=1
fi

if [ "$name" != "$prevname" ]
then
	echo "The name should be $prevname"
	err=1
fi

email=$(git config --get --local user.email)
prevemail=$(git config --get --local user.prevemail)
if [ "$email" == "" ]
then
	echo "Pas de courriel configuré"
	err=1
fi
if [ "$email" != "$prevemail" ]
then
	echo "Email should be $prevemail"
	err=1
fi

if [ $err -gt 0 ]
then
	exit $err
else
	git commit -m "Commit with configured name and email."
fi

