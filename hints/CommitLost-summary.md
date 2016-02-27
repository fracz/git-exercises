git reflog records where you have been previously. You can find any
commit you have been on with this tool and find commits that you have
lost accidentally (i.e. by rebase, amend).

There are even more powerful selectors. Do you want to know what were
you working on yesterday?
git show -q HEAD@{1.day.ago}

More info: https://git-scm.com/docs/git-reflog
