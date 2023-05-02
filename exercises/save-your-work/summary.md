It's hard to verify if you have done this task correctly.

Its aim was to demonstrate [`git stash`](https://git-scm.com/docs/git-stash) feature. When you run this command
on dirty working area, it will save its state in stashed changes. You can
do another work then, make any commits, checkout to any branch and then
get the stashed changes back. You can think of stash as an intelligent Git clipboard.

An interesting option of stash command is the `--keep-index` which allows to
stash all changes that were not added to staging area yet.

Keep in mind that applying stash might lead to conflicts if your working area
introducted changes conflicting with stash. Therefore, its often safer to run
`git stash apply` instead of `git stash pop` (the first one does not remove stashed
changes).

Last thing to remember is that stashes are only local - you can't push them to
remote repository.

See [Stashing](http://git-scm.com/book/en/v2/Git-Tools-Stashing-and-Cleaning) in the Git Book.
