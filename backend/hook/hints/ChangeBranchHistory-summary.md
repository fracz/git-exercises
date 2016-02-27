Although rebase is the easiest way of solving this exercise you may also
use a cherry-pick command:
git checkout hot-bugfix
git cherry-pick change-branch-history
This results in the same commit history of the change-branch-history
branch but the overall result is different than after rebase. When
cherry-picking, the hot-bugfix branch is moved forward and it points
to the same commit as change-branch-history. Be aware of that.

Note that you should not rebase commits when you have published them already.
Need to know why? See: http://git-scm.com/book/en/v2/Git-Branching-Rebasing#The-Perils-of-Rebasing

More info: http://git-scm.com/book/en/v2/Git-Branching-Rebasing
