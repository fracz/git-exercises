echo "*.o" > .gitignore
echo "*.exe" >> .gitignore
echo "*.jar" >> .gitignore
echo "libraries/" >> .gitignore
git add .gitignore
git commit -m "Ignore binary files"
