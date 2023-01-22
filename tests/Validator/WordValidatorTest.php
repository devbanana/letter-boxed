<?php

declare(strict_types=1);

namespace Devbanana\LetterBoxed\Tests\Validator;

use Devbanana\LetterBoxed\Validator\WordValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class WordValidatorTest extends TestCase
{
    private WordValidator $wordValidator;

    /**
     * @var string[]
     */
    private array $sides;

    protected function setUp(): void
    {
        $this->wordValidator = new WordValidator();
        $this->sides = ['XBM', 'INA', 'OYL', 'TEC'];
    }

    public function testInvalidIfNoWordsGiven(): void
    {
        self::assertFalse($this->wordValidator->validate([], $this->sides));
    }

    public function testNonAlphaCharactersInSidesAreInvalid(): void
    {
        self::assertFalse($this->wordValidator->validate(['atom'], ['XBM', 'INA', 'OYL', 'TE-']));
    }

    public function testConsecutiveLettersFromSameSideAreInvalid(): void
    {
        self::assertFalse($this->wordValidator->validate(['tea'], $this->sides));
        self::assertFalse($this->wordValidator->validate(['intel'], $this->sides));
    }

    public function testConsecutiveLettersFromDifferentSidesAreValid(): void
    {
        self::assertTrue($this->wordValidator->validate(['exclamation'], $this->sides));
    }

    public function testEveryLetterMustBeFoundInSides(): void
    {
        self::assertFalse($this->wordValidator->validate(['atoms'], $this->sides));
    }

    public function testInvalidIfFirstLetterOfWordDoesNotMatchLastLetterofPreviousWord(): void
    {
        self::assertFalse($this->wordValidator->validate(['limitation', 'maybe'], $this->sides));
    }

    public function testValidIfFirstLetterOfWordMatchesLastLetterOfPreviousWord(): void
    {
        self::assertTrue($this->wordValidator->validate(['atom', 'maybe'], $this->sides));
    }
}
