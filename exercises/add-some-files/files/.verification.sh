#!/bin/bash
err=0

for fichier in A.txt B.txt C.txt
do
    if ! git ls-files | grep -q $file
    then
    	echo "The file $file has not been staged"
    	err=1
    fi
done

for fichier in $(git ls-files *.txt)
do
    if echo A.txt B.txt C.txt | grep -qv $file
    then
    	echo "The file $file should not have been staged"
    	err=2
    fi
done

if [ $err -gt 0 ]
then
	exit $err
else
	git commit -m "Files added to the staging area." &>/dev/null
fi
   
