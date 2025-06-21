<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\MinOccursValue;

/**
 * Class \SimpleSAML\Test\XSD\Type\MinOccursValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(MinOccursValue::class)]
final class MinOccursValueTest extends TestCase
{
    /**
     * @param string $minOccurs
     * @param bool $shouldPass
     */
    #[DataProvider('provideMinOccurs')]
    public function testMinOccursValue(string $minOccurs, bool $shouldPass): void
    {
        try {
            MinOccursValue::fromString($minOccurs);
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
    public static function provideMinOccurs(): array
    {
        return [
            'negative' => ['-1', false],
            'zero' => ['0', true],
            'positive' => ['1', true],
            'unbounded' => ['unbounded', false],
            'empty' => ['', false],
        ];
    }
}
