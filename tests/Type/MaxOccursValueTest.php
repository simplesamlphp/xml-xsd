<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\MaxOccursValue;

/**
 * Class \SimpleSAML\Test\XSD\Type\MaxOccursValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(MaxOccursValue::class)]
final class MaxOccursValueTest extends TestCase
{
    /**
     * @param string $maxOccurs
     * @param bool $shouldPass
     */
    #[DataProvider('provideMaxOccurs')]
    public function testMaxOccursValue(string $maxOccurs, bool $shouldPass): void
    {
        try {
            MaxOccursValue::fromString($maxOccurs);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * Test helpers
    public function testHelpers(): void
    {
        $x = WhiteSpaceValue::fromEnum(WhiteSpaceEnum::Collapse);
        $this->assertEquals(WhiteSpaceEnum::Collapse, $x->toEnum());

        $y = WhiteSpaceValue::fromString('collapse');
        $this->assertEquals(WhiteSpaceEnum::Collapse, $y->toEnum());
    }
     */


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideMaxOccurs(): array
    {
        return [
            'negative' => ['-1', false],
            'zero' => ['0', true],
            'positive' => ['1', true],
            'unbounded' => ['unbounded', true],
            'empty' => ['', false],
        ];
    }
}
