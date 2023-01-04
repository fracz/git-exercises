#!/bin/bash

dashToCamelCase() {
	echo $1|awk -F"-" '{for(i=1;i<=NF;i++){$i=toupper(substr($i,1,1)) substr($i,2)}} 1' OFS=""
}

# Config the name of the original committer
git config --global init.defaultBranch main
git config --global user.email "$SITE_ADMIN_EMAIL"
git config --global user.name "$SITE_ADMIN_NAME"

# Create the first commits
git init && \
echo init-exercises.sh > .gitignore
git checkout -b exercise-base && \
touch README.md && \
git add .gitignore README.md && \
git commit -m "Initial commit" && \
echo '#!/usr/bin/env bash' > .start.sh && \
echo '#!/usr/bin/env bash' > .verification.sh && \
echo '#!/usr/bin/env bash' > .teardown.sh && \
chmod +x .start.sh .verification.sh .teardown.sh && \
git add .start.sh .verification.sh .teardown.sh && \
git commit -m "Exercice base"

# Create the branches
cp /tmp/exercises/exercises/exercise-order.txt /var/www/website/backend/hook/
shopt -s dotglob
for exercise in $(cat /tmp/exercises/exercises/exercise-order.txt)
do
	git checkout exercise-base
	git checkout -b $exercise
	cp -r /tmp/exercises/exercises/$exercise/files/* .
	git add .
	git commit -m "Exercice files"

	# Copy the hind, summary, solution and verification files into the backend
	[ -f /tmp/exercises/exercises/$exercise/hint.md ] && cp /tmp/exercises/exercises/$exercise/hint.md /var/www/website/backend/hook/hints/$exercise-hint.md || true
	[ -f /tmp/exercises/exercises/$exercise/summary.md ] && cp /tmp/exercises/exercises/$exercise/summary.md /var/www/website/backend/hook/hints/$exercise-summary.md || true
	[ -f /tmp/exercises/exercises/$exercise/solution.txt ] && cp /tmp/exercises/exercises/$exercise/solution.txt /var/www/website/backend/hook/hints/$exercise-solution.txt || true
	[ -f /tmp/exercises/exercises/$exercise/verification.php ] && cp /tmp/exercises/exercises/$exercise/verification.php /var/www/website/backend/hook/verifications/$( dashToCamelCase $exercise ).php || true
done
