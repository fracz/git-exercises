Because the branches have diverged, fast-forward merge strategy could not be applied.
Therefore, a merge conflict was possible. Because two branches made changes in the same
file and near the same line, Git decided not to handle the situation itself but to
throw a merge conflict (letting user decide what to do).

After you resolve the conflict, you need to add it to staging area to tell Git that you have handled the situation. 
`git commit` then continues the merging process.

However, when Git stops and tells you that there is a conflict to resolve, you are not left on your own. There are some tricks
that can make conflict resolution process a lot easier.

 * By default, Git shows only *your* changes and *their* changes of conflicting lines. This will look like this:
 
         <<<<<<< HEAD
         2 + ? = 5
         =======
         ? + 3 = 5
         >>>>>>> another-piece-of-work
         
    It is often very helpful to see also how the code looked like before both of these changes. Seeing more context can
    help figure out good conflict resolution a lot faster. You can 
    [checkout each file in `diff3` mode](http://git-scm.com/book/en/v2/Git-Tools-Advanced-Merging#_checking_out_conflicts)
    that shows all three states of conflicting lines.
    
         git checkout --conflict=diff3 equation.txt
         
    Conflict in `equation.txt` will be presented now as:
    
        <<<<<<< HEAD
        2 + ? = 5
        ||||||| merged common ancestors
        ? + ? = 5
        =======
        ? + 3 = 5
        >>>>>>> another-piece-of-work
        
    If you like the `diff3` presentation of conflicts, you can enable them by default with
    
        git config merge.conflictstyle diff3
        
 * Sometimes you want either discard *your* changes or *their* changes that introduces the conflict. You can do that easily
   with 
    
       git checkout --ours equation.txt

It's also worth to read the [Basic Branching and Merging](http://git-scm.com/book/en/v2/Git-Branching-Basic-Branching-and-Merging) from the Git Book.
