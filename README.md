# Change branch history
You were working on a regular issue while your boss came in and told you to fix recent bug in an application. Because your
work on the issue hasn't been done yet, you decided to go back where you started and do a bug fix there.

Your repository look like this:

            HEAD
             |
    change-branch-history
             |
    A <----- B
     \
      \----- C
             |
         hot-bugfix
         
Now you realized that the bug is really annoying and you don't want to continue your work without the fix you have made.
You wish your repository looked like you started after fixing a bug.

                     HEAD
                      |
             change-branch-history
                      |
    A <----- C <----- B
             |
         hot-bugfix

Achieve that.
