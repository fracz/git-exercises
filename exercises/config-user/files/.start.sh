name=$(git config --get user.name)
email=$(git config --get user.email)

git config user.prevname "$name"
git config user.prevemail "$email"

git config user.name "Your Name"
git config user.email "you@example.com"

sed -i "s/ORIGINAL_NAME/$name/"  README.md
sed -i "s/ORIGINAL_EMAIL/$email/" README.md

git add README.md

