[Interactive rebase](https://git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages)
is one of the most powerful tools in Git. It allows you to amend any commit in history.

There are a few operations that you can do with `git rebase -i` command.
Now you should be familiar with edit operation that allows you to pause
rebasing and amend commit. There is also reword operation that should
be used when you want to change commit message only.

As you have noticed, rebasing can also lead to conflicts.

Remember that you don't need to know the commit SHA-1 hashes when specifying
them in `git rebase -i` command. When you know that you want to go 2 commits
back, you can always run `git rebase -i HEAD^^` or `git rebase -i HEAD~2`.

Note that you should not rebase commits when you have published them already. 
[Find out why](http://git-scm.com/book/en/v2/Git-Branching-Rebasing#The-Perils-of-Rebasing).
