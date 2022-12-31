dashToCamelCase() {
	echo $1|awk -F"-" '{for(i=1;i<=NF;i++){$i=toupper(substr($i,1,1)) substr($i,2)}} 1' OFS=""
}

git config --global user.email "you@example.com"
git config --global user.name "Your Name"
  
git init && \
echo init-exercises.sh > .gitignore
git checkout -b exercise-base && \
touch README.md && \
git add README.md && \
git commit -m "Initial commit" && \
echo '#!/usr/bin/env bash' > start.sh && \
chmod +x start.sh && \
git add start.sh && \
git commit -m "Exercice base"

cp /tmp/exercises/exercises/exercise-order.txt /var/www/website/backend/hook/
for exercise in $(cat /tmp/exercises/exercises/exercise-order.txt)
do
	git checkout exercise-base
	git checkout -b $exercise
	cp -r /tmp/exercises/exercises/$exercise/files/* .
	git add .
	git commit -m "Exercice files"

	cp /tmp/exercises/exercises/$exercise/hint.md /var/www/website/backend/hook/hints/$exercise-hint.md || true
	cp /tmp/exercises/exercises/$exercise/summary.md /var/www/website/backend/hook/hints/$exercise-summary.md || true
	cp /tmp/exercises/exercises/$exercise/solution.txt /var/www/website/backend/hook/hints/$exercise-solution.txt || true
	cp /tmp/exercises/exercises/$exercise/verification.php /var/www/website/backend/hook/verifications/$( dashToCamelCase $exercise ).php || true
done
