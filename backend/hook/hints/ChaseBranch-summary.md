Because the chase branch was direct ancestor of the escaped branch, branch pointer
could be simply moved and no merge commit is necessary (also, conflicts are
impossible to happen in such situations).

This is what Git calls as "Fast-Forward merge" as the branch pointer is only "fast forwarded"
to commit you are merging into.

If you want to merge only if the branch is fast-forwardable, you can
git merge <branch> --ff-only

If you want to always create merge commit (although branch could be fast-forwarded), use
git merge <branch> --no-ff
You may want to do so if you want to preserve branch history.

Note that you could easily fool this task by executing command
git push origin escaped:chase-branch
Remote repository could not tell then if you have done the merge or if you just wanted
to set remote chase-branch to point to the same commit as your local escaped branch.

More info: http://git-scm.com/book/en/v2/Git-Branching-Basic-Branching-and-Merging
