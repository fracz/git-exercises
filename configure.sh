#!/usr/bin/env bash

# Configure "git start" local alias for starting the exercise of user's choice and restarting the current one.
git config --local alias.start "! f() { export LC_ALL=C; currentBranch=\$(git rev-parse --abbrev-ref HEAD); exercise=\${1-\$currentBranch}; if [ \$exercise != HEAD ]; then if [ \$exercise != next ]; then if git show origin/\$exercise:start.sh >/dev/null 2>&1 ; then if git checkout -f \$exercise >/dev/null 2>&1 && git reset --hard origin/\$exercise >/dev/null 2>&1 && git clean -fdx >/dev/null ; then if echo \"Preparing the exercise environment, hold on...\" && ./start.sh >/dev/null 2>&1; then echo \"Exercise \$exercise started!\" && echo 'Read the README.md for instructions or view them in browser:' && echo \"http://gitexercises.fracz.com/e/\$exercise\" ; else echo 'Could not execute the start script.' && echo 'Try running the ./start.sh script yourself.' ; fi else echo 'Could not clean the working directory.' && echo 'Make sure that none of the files inside the working directory' && echo 'is used by another process and run git start again.'; fi else echo \"Invalid exercise: \$exercise\" && false; fi else git push origin master:next-exercise 2>&1 | sed -n '/\\*\\*\\*/,/\\*\\*\\*/p' | grep -v '\\*\\*' | sed 's/remote: //g' | xargs git start | grep -v Invalid || echo 'You have passed all exercises!'; fi else echo 'You need to use git start <exercise-name> in detached HEAD'; fi }; f"

# Add "git verify" local alias for submitting exercises solutions.
git config --local alias.verify "! f() { export LC_ALL=C; currentBranch=\$(git rev-parse --abbrev-ref HEAD); exercise=\${1-\$currentBranch}; if [ \$exercise != HEAD ]; then if git show origin/\$exercise:start.sh >/dev/null 2>&1 ; then if ! (git status | grep 'up-to-date' >/dev/null 2>&1 || git status | grep 'up to date' >/dev/null 2>&1) ; then if echo \"Verifying the \$exercise exercise. Hold on...\" && git push -f origin HEAD:\$exercise --tags 2>&1 | sed -n '/\\*\\*\\*/,/\\*\\*\\*/p' | sed 's/remote: //g' | grep -v \"\\*\\*\" ; then : ; else echo 'Solution could not be verified - push failed.' && echo 'Do you have an internet connection?'; fi else echo \"You haven't made any progress on exercise \$exercise.\" && echo 'Did you forget to commit your changes?'; fi else echo \"Invalid exercise: \$exercise\"; fi else echo 'You need to use git verify <exercise-name> in detached HEAD'; fi }; f"

# Add "git exercises" alias that shows list of available exercises.
git config --local alias.exercises "! git push origin master:exercises 2>&1 | sed -n '/\\*\\*\\*/,/\\*\\*\\*/p' | grep -v '\\*\\*' | sed 's/remote: //g'"

# Make sure you have a "current" push strategy set; this will allow you to push only current exercise with simple git
# push command instead of pushing all matching branches (default in Git < 2.0)
git config --local push.default current

echo "OK"
