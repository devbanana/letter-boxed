<?php

declare(strict_types=1);

namespace Devbanana\LetterBoxed\Tests\Util;

use Devbanana\LetterBoxed\Util\StripWords;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class StripWordsTest extends TestCase
{
    private StripWords $stripWords;

    /**
     * @var string[]
     */
    private array $sides;

    protected function setUp(): void
    {
        $this->stripWords = new StripWords();
        $this->sides = ['XBM', 'INA', 'OYL', 'TEC'];
    }

    public function testStripLettersNotPresentResultsInSameLetters(): void
    {
        self::assertSame('ABCEILMNOTXY', $this->stripWords->strip(['hush'], $this->sides));
    }

    public function testOnlyStripPresentLetters(): void
    {
        self::assertSame('BCEILNXY', $this->stripWords->strip(['atoms'], $this->sides));
    }

    public function testStripMultipleWords(): void
    {
        self::assertSame('CILNX', $this->stripWords->strip(['atom', 'maybe'], $this->sides));
    }

    public function testReturnEmptyStringIfAllLettersStripped(): void
    {
        self::assertSame('', $this->stripWords->strip(['bye', 'exclamation'], $this->sides));
    }

    public function testDuplicateLettersShouldBeRemoved(): void
    {
        $sides = ['XBM', 'INA', 'OYL', 'TEX'];

        self::assertSame('BEILNXY', $this->stripWords->strip(['atom'], $sides));
    }
}
