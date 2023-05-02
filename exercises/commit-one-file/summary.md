You prepare changes to be committed with [`git add <file>`](https://git-scm.com/docs/git-add) command. 
It adds files from working area to staging area. 
Only files that are in staging area will be included in the commit when you run the [`git commit`](https://git-scm.com/docs/git-commit) command.

Remember that you can `git add -A` to add all changed files to staging area. You can also do this *in air* with `-a` option for
[`git commit`](https://git-scm.com/docs/git-commit), e.g. 

    git commit -am "Some Commit Message"
