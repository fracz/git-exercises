<?php
/*
 * This script is to generate base64 strings, one of which introduces swearword.
 * They are used in the find-bug exercise.
 */

$noOfCommits = 200;
$swearword = 'jackass';

$wordsUrl = 'http://api.wordnik.com/v4/words.json/randomWords?' . http_build_query([
        'limit' => $noOfCommits,
        'api_key' => 'a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5'
    ]);

$words = json_decode(file_get_contents($wordsUrl));
$words = array_map(function ($def) {
    return $def->word;
}, $words);

$swearwordAdded = false;
srand(microtime(true));

while (!$swearwordAdded) {
    $content = [];
    $strings = [];
    for ($i = 0; $i < $noOfCommits; $i++) {
        $add = count($content) < 5 ? true : (count($content) > 20 ? false : rand(0, 1));
        if ($add) {
            if (!$swearwordAdded && rand(0, $noOfCommits) == 0) {
                $swearwordAdded = true;
                $content[] = $swearword;
            } else {
                $content[] = $words[rand(0, $noOfCommits - 1)];
            }
        } else {
            if ($content[0] != $swearword) {
                array_shift($content);
            }
        }
        shuffle($content);
        $strings[] = base64_encode(implode(' ', $content));
    }
}

file_put_contents('bisect.sh', 'strings=(' . implode(' ', $strings) . ')' . PHP_EOL);
