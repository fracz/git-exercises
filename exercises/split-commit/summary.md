In order to split a commit you need to go just before it (force working
area looks like the commit has not been made) and repeat commit(s)
as you wish.

To go back, you should use [`git reset`](https://git-scm.com/docs/git-reset) command. It does three things
in a specific order, stopping when you tell it to (depending on a reset type):

1. Moves the branch `HEAD` points to (stops here if `--soft`)
1. Makes the Index look like `HEAD` (stops here if `--mixed`, default, if no flag specified)
1. Makes the Working Directory look like the Index (`--hard`)

In this exercise, you should have `git reset HEAD^` (reset your
branch and Index too look like one commit before but leave Working Area
untouched). Then it's easy to prepare your commit(s) again as you desire.

Read more [about reset command](http://git-scm.com/book/en/v2/Git-Tools-Reset-Demystified) 
and [splitting commits](http://git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Splitting-a-Commit) in the Git Book. 
