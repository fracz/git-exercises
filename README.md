## Find a commit that has been lost

You have created a commit with very important piece of work. You then wanted to fix something in the last commit
so you have amended it. However, you have just realized you have accidentally committed the wrong changes and you
desperately need the first version of the commit you have just amended.

However, there is no previous version in the history - you have edited the last commit with `git commit --amend`.

Your goal is to find the first version of the commit in the repository. It must be somewhere...

Once found, force the `commit-lost` branch to point at it again and verify the solution.
