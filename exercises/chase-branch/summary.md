Because the `chase` branch was direct ancestor of the `escaped` branch, the pointer
could be simply moved and no merge commit is necessary (also, conflicts are
impossible to happen in such situations).

This is what Git calls as *Fast-Forward merge* because the branch pointer is only *fast forwarded*
to the commit you are merging with.

Note that you could easily fool this task by executing command

    git push origin escaped:chase-branch

Remote repository could not tell then if you have done the merge or if you just wanted
to set the remote `chase-branch` to point to the same commit as your local `escaped` branch (which is what the command above does).

See also: [Basic Branching and Merging](http://git-scm.com/book/en/v2/Git-Branching-Basic-Branching-and-Merging) from Git Book.
