#!/usr/bin/env bash

# Configure "git start" local alias for starting the exercise of user's choice of restarting the current one.
git config alias.start "! f() { currentBranch=\$(git rev-parse --abbrev-ref HEAD); exercise=\${1-\$currentBranch}; git show origin/\$exercise:start.sh >/dev/null 2>&1 && git checkout -f \$exercise >/dev/null 2>&1 && git reset --hard origin/\$exercise >/dev/null 2>&1 && git clean -fdx >/dev/null 2>&1 && echo \"Preparing the exercise environment, hold on...\" && ./start.sh >/dev/null 2>&1 && echo \"Exercise \$exercise started! Read the README.md for instructions.\" || echo \"Invalid exercise: \$exercise\"; }; f"

# Add "git verify" local alias for submitting exercises solutions.
git config alias.verify "! f() { currentBranch=\$(git rev-parse --abbrev-ref HEAD); exercise=\${1-\$currentBranch}; git show origin/\$exercise:start.sh >/dev/null 2>&1 && echo \"Verifying the \$exercise exercise. Hold on...\" && git push -f origin HEAD:\$exercise 2>&1 | sed -n '/\\*\\*\\*/,/\\*\\*\\*/p' | grep -v \"\\*\\*\" | sed 's/remote: //g' || echo \"Invalid exercise: \$exercise\"; }; f"

# Add "git exercises" alias that shows list of available exercises
git config alias.exercises "! git push origin HEAD:exercises 2>&1 | sed -n '/\\*\\*\\*/,/\\*\\*\\*/p' | grep -v '\\*\\*' | sed 's/remote: //g'"

# Make sure you have a "current" push strategy set; this will allow you to push only current exercise with simple git
# push command instead of pushing all matching branches (default in Git < 2.0)
git config push.default current

echo "OK"
