# Chase branch that escaped
You are currently on `chase-branch` branch. There is also `escaped` branch that has two more commits.

       HEAD
         |
    chase-branch        escaped
         |                 |
         A <----- B <----- C


You want to make `chase-branch` to point to the same commit as the `escaped` branch.

                        escaped
                           |
         A <----- B <----- C
                           |
                      chase-branch
                           |
                          HEAD
