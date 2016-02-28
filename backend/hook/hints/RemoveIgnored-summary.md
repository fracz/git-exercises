When file is ignored but is tracked for whatever reason, you can always execute
[`git rm <file>`](https://git-scm.com/docs/git-rm)
to remove the file from both repository and working area.

If you want to leave it in your working directory (which is often when dealing
with mistakenly tracked files), you can tell Git to remove it only from repository
but not from working area with

    git rm --cached <file>

See [removing files](http://git-scm.com/book/ch2-2.html#Removing-Files) in the Git Book.
