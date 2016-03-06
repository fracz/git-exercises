#!/usr/bin/env bash

git tag -d 1.0.0 2.0.0 3.0.0
echo "First working version" > product.txt
git add product.txt
git commit -m "First working version"
echo "1.0.0" > version.txt
git add version.txt
git commit -m "Release of 1.0.0 version"
for i in 1 2 3; do
  echo "Feature $i" >> product.txt
  git commit -am "Implement feature $i"
done
echo "2.0.0" > version.txt
git commit -am "Release of 2.0.0 version"
echo "BUGFIX" >> product.txt
git commit -am "Critical bugfix"
for i in 4 5 6 7; do
  echo "Feature $i" >> product.txt
  git commit -am "Implement feature $i"
done
echo "3.0.0" > version.txt
git commit -am "Release of 3.0.0 version"