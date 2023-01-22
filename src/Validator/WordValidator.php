<?php

declare(strict_types=1);

namespace Devbanana\LetterBoxed\Validator;

final class WordValidator
{
    /**
     * Validate that the given words are valid according to the provided sides.
     *
     * @param string[] $words The words to validate
     * @param string[] $sides The sides containing the 4 sets of letters
     */
    public function validate(array $words, array $sides): bool
    {
        // Validate that $words contains at least 1 word
        if (\count($words) < 1) {
            return false;
        }

        // Filter out all non-alpha characters
        $sides = array_filter($sides, 'ctype_alpha');

        if (\count($sides) !== 4) {
            return false;
        }

        foreach ($words as $i => $word) {
            if (!$this->validateWord($word, $sides)) {
                return false;
            }

            // Validate that the first letter of each word matches the last letter of the prior word
            if ($i > 0 && !$this->validateWordsMatch($words[$i - 1], $words[$i])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates that the given two words are valid according to the provided matches.
     *
     * @param string $word1 The first word to validate
     * @param string $word2 The second word to validate
     */
    private function validateWordsMatch(string $word1, string $word2): bool
    {
        $lastLetter = strtolower($word1[\strlen($word1) - 1]);
        $firstLetter = strtolower($word2[0]);

        return $lastLetter === $firstLetter;
    }

    /**
     * Validates that the given word is valid according to the provided sides.
     *
     * @param string   $word  The word to validate
     * @param string[] $sides The 4 sides of the puzzle
     */
    private function validateWord(string $word, array $sides): bool
    {
        if (\strlen($word) < 3) {
            return false;
        }

        $previousLetterSide = null;

        foreach (str_split($word) as $letter) {
            $letterSide = $this->findSideByLetter($letter, $sides);
            if ($previousLetterSide === $letterSide || $letterSide === null) {
                return false;
            }
            $previousLetterSide = $letterSide;
        }

        return true;
    }

    /**
     * Find the side that contains the given letter.
     *
     * @param string   $letter The letter to search for
     * @param string[] $sides  The 4 sides of the puzzle
     */
    private function findSideByLetter(string $letter, array $sides): ?int
    {
        foreach ($sides as $i => $side) {
            if (stripos($side, $letter) !== false) {
                return $i;
            }
        }

        return null;
    }
}
