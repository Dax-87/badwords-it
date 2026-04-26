<?php

use BadwordsIt\Filter;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    private Filter $filter;

    protected function setUp(): void
    {
        $this->filter = new Filter();
    }

    // --- hasProfanity ---

    public function testCleanTextReturnsFalse(): void
    {
        $this->assertFalse($this->filter->hasProfanity('Ciao, vorrei un preventivo'));
        $this->assertFalse($this->filter->hasProfanity('Mario Rossi'));
        $this->assertFalse($this->filter->hasProfanity(''));
    }

    public function testRegexWordBoundaryMatch(): void
    {
        $this->assertTrue($this->filter->hasProfanity('che cazzo'));
        $this->assertTrue($this->filter->hasProfanity('MERDA'));
        $this->assertTrue($this->filter->hasProfanity('vaffanculo tutto'));
    }

    public function testSubstringConcatenation(): void
    {
        $this->assertTrue($this->filter->hasProfanity('cazzomerda'));
        $this->assertTrue($this->filter->hasProfanity('madonnaputtana'));
    }

    public function testPhraseMatch(): void
    {
        $this->assertTrue($this->filter->hasProfanity('porco dio'));
        $this->assertTrue($this->filter->hasProfanity('figlio di puttana'));
        $this->assertTrue($this->filter->hasProfanity('che palle questa cosa'));
    }

    public function testCaseInsensitive(): void
    {
        $this->assertTrue($this->filter->hasProfanity('CAZZO'));
        $this->assertTrue($this->filter->hasProfanity('Merda'));
        $this->assertTrue($this->filter->hasProfanity('VaFfAnCuLo'));
    }

    // --- hasProfanityEmail ---

    public function testCleanEmailReturnsFalse(): void
    {
        $this->assertFalse($this->filter->hasProfanityEmail('mario.rossi@gmail.com'));
        $this->assertFalse($this->filter->hasProfanityEmail('info@danielecannavacciuolo.it'));
    }

    public function testProfanityInEmailLocal(): void
    {
        $this->assertTrue($this->filter->hasProfanityEmail('cazzo123@gmail.com'));
        $this->assertTrue($this->filter->hasProfanityEmail('merda@test.com'));
    }

    public function testProfanityInEmailDomain(): void
    {
        $this->assertTrue($this->filter->hasProfanityEmail('user@merda.com'));
    }

    // --- hasSpam ---

    public function testCleanTextNoSpam(): void
    {
        $this->assertFalse($this->filter->hasSpam('Buongiorno, vorrei un appuntamento'));
    }

    public function testSpamKeywords(): void
    {
        $this->assertTrue($this->filter->hasSpam('buy bitcoin now'));
        $this->assertTrue($this->filter->hasSpam('visit our site at spam.ru'));
        $this->assertTrue($this->filter->hasSpam('SELECT * FROM users'));
        $this->assertTrue($this->filter->hasSpam('<script>alert(1)</script>'));
    }

    // --- checkFields ---

    public function testCheckFieldsMultiple(): void
    {
        $this->assertFalse($this->filter->checkFields(['Mario', 'Rossi', 'Buongiorno']));
        $this->assertTrue($this->filter->checkFields(['Mario', 'cazzo', 'Buongiorno']));
    }

    // --- inspect ---

    public function testInspectClean(): void
    {
        $result = $this->filter->inspect(['Mario', 'Rossi', 'Messaggio pulito'], 'mario@gmail.com');
        $this->assertFalse($result['profanity']);
        $this->assertFalse($result['spam']);
    }

    public function testInspectProfanityAndSpam(): void
    {
        $result = $this->filter->inspect(['che cazzo', 'buy bitcoin'], 'cazzo@test.com');
        $this->assertTrue($result['profanity']);
        $this->assertTrue($result['spam']);
    }
}
