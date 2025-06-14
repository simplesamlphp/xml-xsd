<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\SimpleDerivationSetValue;

/**
 * Class \SimpleSAML\Test\XSD\Type\SimpleDerivationSetValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(SimpleDerivationSetValue::class)]
final class SimpleDerivationSetValueTest extends TestCase
{
    /**
     * @param string $SimpleDerivationSet
     * @param bool $expected
     */
    #[DataProvider('provideSimpleDerivationSet')]
    public function testSimpleDerivationSetValue(string $simpleDerivationSet, bool $shouldPass): void
    {
        try {
            SimpleDerivationSetValue::fromString($simpleDerivationSet);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function provideSimpleDerivationSet(): array
    {
        return [
            '#all' => ['#all', true],
            '#all combined' => ['#all list restriction union', false],
            'list' => ['list', true],
            'union' => ['union', true],
            'restriction' => ['restriction', true],
            'combined' => ['restriction union list', true],
            'multiple spaces and newlines' => [
                "restriction  list \n union",
                true,
            ],
            'undefined' => ['undefined', false],
            'empty' => ['', true],
        ];
    }
}
