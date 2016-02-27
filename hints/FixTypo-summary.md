When you want to change the last commit (the one that is pointed by HEAD), use
`git commit --amend`
If you want to change only commited files but no edit message, use
`git commit --amend --no-edit`
Moreover, you can skip git add command and update last commit with all current
changes in working area:
`git commit --amend --no-edit -a`

Note that you should not amend a commit when you have published it already.
Need to know why? See: http://git-scm.com/book/en/v2/Git-Branching-Rebasing#The-Perils-of-Rebasing

More info: http://git-scm.com/book/en/v2/Git-Basics-Undoing-Things
