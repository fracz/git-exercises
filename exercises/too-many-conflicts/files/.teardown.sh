#!/usr/bin/env bash

git checkout too-many-conflicts
git branch -D double-check
git config --local --unset merge.conflictstyle
