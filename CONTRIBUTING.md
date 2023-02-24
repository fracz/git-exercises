# I want to add new exercise

**DOCUMENT WORK IN PROGRESS**

Perfect.

First of all, you need to have an idea. You need to know:

- what is the start point of the exercise - commit 
history, files in working and staging area and where the `HEAD` is
- what is the expected result
- what is the name of the exercise

Once you now that, you may proceed.

## 0. Fork and clone the repo

When on `master` branch, run `./configure.sh` script to create git-exercises aliases.

## 1. Create a branch for the exercise

Every exercise lives in its own branch. Create it, using the `exercise-base` tag as a start place.

For this instruction, we will assume that the exercise you are adding is a `commit-one-file-staged`.

```
git branch commit-one-file-staged exercise-base
git checkout commit-one-file-staged
```

Replace `commit-one-file-staged` with your new exercise name.

## 2. Define script that prepares the exercise

Put commands that prepare the exercise in the `start.sh` script (they do not have to work for now)

```
#!/usr/bin/env bash
echo 'A' > 'A.txt'
echo 'B' > 'B.txt'
git add A.txt
git add B.txt
```

and commit it:

```
git commit -am "Ex: commit-one-file-staged"
```

From now, we will refer to this commit (the first one after `exercise-base` that contains the new exercise) as
_the exercise commit_.

## 3. Try out the script

Run `./start.sh` in order to see if the script behaves correctly. If it does not:
1. Go back to the exercise commit from #2 with `git reset --hard <exercise-commit-hash>`.
1. Fix the script.
1. Amend the exercise commit with `git commit --amend -a --no-edit`
1. Try again.

## 4. Write instructions for the exercise

Go back to the exercise commit from #2 with `git reset --hard <exercise-commit-hash>`.

Fill in the `README.md` file with necessary instructions for the exercise. This content will appear
in the task description on the website. Try to be exhaustive and concise. Example:

```
## Commit one file of two currently staged

There are two files created in the root project directory - `A.txt` and `B.txt`. They are both added to the staging 
area.

The goal is to commit only one of them.
```

When you are ready, add instructions to the exercise commit with `git commit --amend -a --no-edit`.

## 5. Push the new task to the repository

The commit history should contain only the exercise commit and the exercise base. 

```
$ git log -2 --oneline
7a5a881 Ex: commit-one-file-staged
8fbeef9 Exercise base
```

If it looks similar, push the new task to the repository

```
git push origin commit-one-file-staged
```

## 6. Create a verification script

Checkout the `verifications` branch.

```
git checkout verifications
```

The verification scripts (and the whole branch) live in the server and verifiy solutions 
submitted by users.

Verification is a PHP class that is given access to all the commits submitted in the exercise.
Its name should equal the exercise name, UpperCamelCased.

Create verification for your exercise for example in `/backend/hook/verifications/CommitOneFileStaged.php`.

```
<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;

class CommitOneFileStaged extends AbstractVerification
{
    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure(in_array($file, ['A.txt', 'B.txt']), 'None of the generated files has been commited. Received %s.', [ConsoleUtils::blue($file)]);
    }
}
```

If the `doVerify()` method throws a `VerificationFailure`, its message is used to display an error
to the user and the exercise is considered failed. If no exception thrown, the exercise is passed.

You might find these resources helpful:
- [`AbstractVerification`](https://github.com/fracz/git-exercises/blob/verifications/backend/hook/AbstractVerification.php)
class
- [`GitUtils`](https://github.com/fracz/git-exercises/blob/verifications/backend/hook/utils/GitUtils.php) class
- [current verifications](https://github.com/fracz/git-exercises/tree/verifications/backend/hook/verifications)
