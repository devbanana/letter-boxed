<?php

declare(strict_types=1);

namespace Devbanana\LetterBoxed\Util;

final class StripWords
{
    /**
     * Strip the letters of the given words from the letters in the given sides.
     *
     * @param string[] $words The words to strip
     * @param string[] $sides The sides of the puzzle
     *
     * @return string The remaining letters
     */
    public function strip(array $words, array $sides): string
    {
        $remainingLetters = [];

        foreach ($sides as $side) {
            foreach (str_split(strtoupper($side)) as $letter) {
                $remainingLetters[$letter] = 1;
            }
        }

        foreach ($words as $word) {
            foreach (str_split(strtoupper($word)) as $letter) {
                unset($remainingLetters[$letter]);
            }
        }

        ksort($remainingLetters);

        return implode('', array_keys($remainingLetters));
    }
}
