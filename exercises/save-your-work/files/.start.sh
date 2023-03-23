#!/usr/bin/env bash

echo "This file contains bug" > bug.txt
echo "It has to be somewhere." >> bug.txt
echo "I feel like I can smell it." >> bug.txt
echo "THIS IS A BUG - remove the whole line to fix it." >> bug.txt
echo "How this program could work with such bug?" >> bug.txt
echo "This is a completely working program." > program.txt
echo "This has been written in Brainfuck" >> program.txt
echo "++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>." >> program.txt
git add bug.txt
git add program.txt
git commit -m "Excellent version with a bug"
echo "This is the work I have done recently." >> bug.txt
echo "I would be very sad if I loose it." >> bug.txt
echo "++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>." > program.txt
echo ",----------[----------------------.,----------]" >> program.txt
echo ",>,>++++++++[<------<------>>-]." >> program.txt
echo "<<[>[>+>+<<-]>>[<<+>>-]<<<-]" >> program.txt
echo ">>>++++++[<++++++++>-]<." >> program.txt
