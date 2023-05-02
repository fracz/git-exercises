#!/usr/bin/env bash

git checkout more-conflicts
git branch -D double-check
git config --local --unset merge.conflictstyle
