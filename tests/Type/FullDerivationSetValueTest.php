<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\FullDerivationSetValue;

/**
 * Class \SimpleSAML\Test\XSD\Type\FullDerivationSetValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(FullDerivationSetValue::class)]
final class FullDerivationSetValueTest extends TestCase
{
    /**
     * @param string $fullDerivationSet
     * @param bool $expected
     */
    #[DataProvider('provideFullDerivationSet')]
    public function testFullDerivationSetValue(string $fullDerivationSet, bool $shouldPass): void
    {
        try {
            FullDerivationSetValue::fromString($fullDerivationSet);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function provideFullDerivationSet(): array
    {
        return [
            '#all' => ['#all', true],
            '#all combined' => ['#all list restriction union', false],
            'extension' => ['extension', true],
            'list' => ['list', true],
            'union' => ['union', true],
            'restriction' => ['restriction', true],
            'substitution' => ['substitution', false],
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
