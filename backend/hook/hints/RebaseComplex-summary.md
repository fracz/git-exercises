[`git rebase --onto`](https://git-scm.com/docs/git-rebase) allows you to move a branch to a different place.

The command:

    git rebase issue-555 --onto your-master

means:

> Get all commits that are not in `issue-555` and place them onto `your-master` branch.

It is consistent with regular rebase (`--onto` defaults to branch you are rebasing to). `git rebase issue-555`
means: 

> Get all commits that are not in `issue-555` and place them onto `issue-555`.

See also [interesting rebases](http://git-scm.com/book/en/v2/Git-Branching-Rebasing#More-Interesting-Rebases) in the Git Book.
