## Find commit that has introduced bug
Your customer claims that there is a bug in application. The word *jackass* is being displayed on main screen.

He can not tell when the word appeared the first time. However, he is sure that there was no *jackass* in the version 1.0
of the application. He want you to find who has added this and fix it ASAP.

However, the task is not so simple. It turns out that the home screen text is encoded in source code with base64
algorithm for sanity reasons. It is impossible to search for commit that introduces this swearword with `git log -S`
command. What's more, the text in home screen has been changed in the last 300 commits.

Your task is to find the first commit that introduces the *jackass* word and push it for verification.

### Justification
Normally you don't face base64 encoded strings that you need to search in. However, this perfectly simulates common
situation when *something were working back then but now is broken*. You often can't even tell where and when the bug 
could be introduced. In *real life* you would write an unit test that verifies if the bug exists. This would help you to 
find a commit introducing bug dramatically.

## Useful tips
 * First of all, you don't want to search for *jackass* commit by hand.
 * You can find last known working (no *jackass*) version of the project by `1.0` tag.
 * You can decode contents of the home page text with the following command
    
        openssl enc -base64 -A -d < home-screen-text.txt
        
 * `grep` can help you verify whether the decoded content contains *jackass* or not. It's worth to know the `grep -v`
   option that inverts default grep behavior - returns status code `0` if the word has not been found and `1` otherwise
 * you can run any command in shell with `sh -c "any command"`
 * Use informations above to create a simple unit test that would help to automate searching for a first commit with bug
 * When you find the first commit with *jackass*, you can push it for verification with the following command
 
        git push origin COMMIT_ID:find-bug
