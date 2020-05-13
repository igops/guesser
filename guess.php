<?php

const DEBUG_START = "\e[33mDEBUG: ";
const DEBUG_END = "\e[39m";

$GUESS_FROM = (int) ($argv[1] ?? 1);
$GUESS_TO   = (int) ($argv[2] ?? 1000);
$DEBUG      = strtoupper($argv[3] ?? '') === 'DEBUG';

println();
println("This message comes before welcome");
println("********** Welcome to the Vadim's guesser! **********");
println("Vadim will maintain the project then");
println();
println(sprintf("Debug mode is %s", $DEBUG ? "ON" : "OFF"));
println();
println(sprintf("I guarantee the success in %d questions!", ceil(log($GUESS_TO - $GUESS_FROM, 2))));
printl(sprintf("Think of a number between %d and %d and press Enter! \n", $GUESS_FROM, $GUESS_TO));
readln();

println("Great, now I'm gonna guess it!");
println("Please be honest ;)");
println();

$nextGuessFrom = $GUESS_FROM;
$nextGuessTo = $GUESS_TO;
$guessCounter = 0;

while(true) {
    $median = $nextGuessFrom + intval(($nextGuessTo - $nextGuessFrom) / 2);
    if ($DEBUG) {
        println(sprintf(DEBUG_START . "Let's reduce a range of guessing by half: [%d:%d] and [%d:%d]" . DEBUG_END,
            $nextGuessFrom, $median, $median+1, $nextGuessTo));
    }
    printl(sprintf("[#%02d] Is your number bigger than %d? (y/n): ", ++$guessCounter, $median));
    $yes = in_array(trim(strtoupper(readln())), ['Y','']);

    if ($yes) {
        $nextGuessFrom = $median + 1;
    } else {
        $nextGuessTo = $median;
    }
    if ($DEBUG) {
        println(sprintf(DEBUG_START . "OK, now guessing in: [%d:%d]" . DEBUG_END, $nextGuessFrom, $nextGuessTo));
    }

    if ($nextGuessTo === $nextGuessFrom) {
        if ($DEBUG) {
            println(sprintf(DEBUG_START . "The range contains a single number, so I've guessed ;)" . DEBUG_END));
        }
        println();
        println(sprintf("You thought %d!", $yes ? $nextGuessTo : $median));
        println();
        break;
    }
}

function printl($line) {
    echo $line;
}
function println($line = "") {
    printl($line . PHP_EOL);
}
function readln() {
    return trim( fgets(STDIN) );
}
