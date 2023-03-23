#!/usr/bin/env bash
if ! git checkout new-branch
then
    git checkout -b new-branch
fi

git branch -D old-branch
