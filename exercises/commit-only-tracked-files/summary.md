The '-u' option or in its long form '--update' limits the addition of files to the staging area to those that are already tracked by git. 

It is best to avoid blindly adding all files modified with 'git add *' or 'git add .'. You risk polluting your repository with unnecessary files, which makes tracking changes more painful. A good practice is to: 

1. Add the changes to the preparation area with 'git add' 
2. Validate that all changes are wanted and understood with 'git status' and 'git diff' 
3. Commit with a clear message about what the changes bring 

You can also create a .gitignore file for files you never want to commit... That's the topic of the next exercise!
