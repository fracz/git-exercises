## Rebase complex

You were working on an `issue-555` topic branch. You noticed a bug, which you fixed in `rebase-complex` topic branch. 
Then, you finished `issue-555`.

However, you need to have bug fixed in `your-master` branch without any work done on `issue-555`.

Situation is as follows:

                    your-master
                         |
    A <--- B <--- C <--- D
            \
             E <--- F <--- G - issue-555
              \
               H <--- I
                      |
                rebase-complex
                      |
                     HEAD
                     
Only `H` and `I` commits should be rebased onto `D`.

Try to do this with a single git command.
