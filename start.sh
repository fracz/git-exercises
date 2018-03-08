#!/usr/bin/env bash

echo "#!/usr/bin/env bash" > script.sh
echo "echo \"Git exercises\"" >> script.sh
git add script.sh
git commit -m "Create script.sh"