<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\ProcessContentsValue;
use SimpleSAML\XSD\XML\xsd\ProcessContentsEnum;

/**
 * Class \SimpleSAML\Test\XSD\Type\ProcessContentsValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(ProcessContentsValue::class)]
final class ProcessContentsValueTest extends TestCase
{
    /**
     * @param string $processContents
     * @param bool $shouldPass
     */
    #[DataProvider('provideProcessContents')]
    public function testProcessContentsValue(string $processContents, bool $shouldPass): void
    {
        try {
            ProcessContentsValue::fromString($processContents);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * Test helpers
     */
    public function testHelpers(): void
    {
        $x = ProcessContentsValue::fromEnum(ProcessContentsEnum::Lax);
        $this->assertEquals(ProcessContentsEnum::Lax, $x->toEnum());

        $y = ProcessContentsValue::fromString('lax');
        $this->assertEquals(ProcessContentsEnum::Lax, $y->toEnum());
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideProcessContents(): array
    {
        return [
            'lax' => ['lax', true],
            'skip' => ['skip', true],
            'strict' => ['strict', true],
            'undefined' => ['undefined', false],
            'empty' => ['', false],
        ];
    }
}
