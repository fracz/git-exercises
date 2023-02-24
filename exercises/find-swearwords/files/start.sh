#!/usr/bin/env bash

words=(Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec purus faucibus orci porttitor euismod ac ac elit. Mauris vitae blandit ex, shit vel placerat eros. Ut ultrices sed diam consequat consequat. Cras finibus est sed lobortis fermentum. Sed varius placerat ligula in ultricies. Aenean shit gravida lorem et dui rhoncus aliquam. Praesent cursus elit eu malesuada sollicitudin. In hac habitasse platea dictumst. Morbi aliquam dui in eleifend porttitor. Morbi in leo nibh. Nam in commodo ante. Cras hendrerit magna metus, eu aliquam dolor maximus in. In volutpat semper risus posuere feugiat. Cum shit sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.)

touch words.txt
touch list.txt
git add words.txt
git add list.txt
git commit -m "Add empty files"

for i in "${!words[@]}"; do
  targetFile="words.txt"
  if [ `expr $i % 2` -eq 0 ]
  then
    targetFile="list.txt"
  fi
  echo "${words[$i]}" >> $targetFile
  echo "" >> $targetFile
  commitIndex=$(($i+1))
  git commit -am "Add word #$commitIndex"
done
