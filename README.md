# git-exercises

This repository contains problems that you may encounter in everyday work with Git. Each problem resides in its own
branch which you can checkout and verify your git-skills. In general, all exercises assume that you know basics of Git
(i.e. how to commit a file and what the working and staging area is).

The `README.md` file always contains an explanation of the problem and the expected repository state that should be
achieved. A special git command `git start` has been prepared for the purpose of preparing your local commit history 
and working area for the task.

In fact, you are currently on `master` branch that contains the first exercise.

## Prerequisites

 * make sure you can run `.sh` scripts; you get it out of the box in unix systems; on Windows, you can use Git Bash that
   is shipped with Windows version of Git
 * introduce yourself by executing `git config user.name "Your Name"` and `git config user.email "your@email.com"` 
   commands in the repo directory after you have cloned it
 * execute the `./configure.sh` script; it will add a few git aliases that will ease working with these exercises
   (this WILL NOT affect your global Git settings)

## Exercise - Commit a file

The first exercise is to push a commit that is created when you run the `git start` command.

## Verifying results

When you think you are ready with the exercise, just execute the `git verify` command. It will try to push your changes 
to the remote repository and tell you if the provided solution is correct. 

There may be situation when the `git verify` tells you that the exercise name is invalid. This means that you have
probably changed the branch name during work. In such cases, you need to tell what exercise you are currently trying to
solve with `git verify exercise-name` command.

## How to find the next exercise?

When you pass the exercise successfully, output of `git verify` command will tell you the next exercise name as well as 
the command you need to execute in order to be in the right place (that is `git start exercise-name`).

You can also jump to any of the exercises at any moment. To display list of them, execute the `git exercises` command.

## How to reset exercise and start from the beginning?

Each time you got lost you can discard all changes you made in an exercise and start from scratch with executing
`git start` command without any arguments. 

This will work only if you are on an exercise branch. If not, tell git which task you want to start with by executing 
`git start exercise-name`.
