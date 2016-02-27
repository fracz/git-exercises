A [`.gitignore`](http://git-scm.com/docs/gitignore) file specifies intentionally untracked files that Git should ignore.

To ignore all files with specific string inside filename, just type it in, i.e. `dumb`
To ignore all files with specific extension use wildcard, i.e. `*.exe`
To ignore the whole directories, put a slash in the end of the rule, i.e. `libraries/`
To specify full path from the `.gitignore` location start rule with slash, i.e. `/libraries`

Note that there is a difference between `libraries/` and `/libraries/` rule.
The first one would ignore all directories named "libraries" in the whole project whereas
the second one would ignore only the "libraries" directory in the same location as `.gitignore` file.
