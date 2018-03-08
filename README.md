## Make the file executable by default

You have created a simple bash script in `script.sh`. However, when you check it out
on Unix, it does not have required execute permissions so you can't launch it with
`./script.sh` without performing `chmod +x script.sh` beforehand.

Fix it by adding an executable bit for `script.sh` in Git history.