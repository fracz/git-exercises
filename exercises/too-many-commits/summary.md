The easiest way to make one commit out of two (or more) is to [squash](https://git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Squashing-Commits) them
with `git rebase -i` command and choose squash option for all but the first
commit you want to preserve. Note that you can also use `fixup` command
when you want to discard consequent commit messages and leave only the
first one.

Remember that you don't need to know the commit SHA-1 hashes when specifying
them in `git rebase -i` command. When you know that you want to go 2 commits
back, you can always run `git rebase -i HEAD^^` or `git rebase -i HEAD~2`.

Note that you should not squash commits when you have published them already.
[Find out why](http://git-scm.com/book/en/v2/Git-Branching-Rebasing#The-Perils-of-Rebasing).
