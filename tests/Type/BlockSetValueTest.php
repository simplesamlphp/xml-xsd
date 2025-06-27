<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\BlockSetValue;

/**
 * Class \SimpleSAML\Test\XSD\Type\BlockSetValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(BlockSetValue::class)]
final class BlockSetValueTest extends TestCase
{
    /**
     * @param string $blockSet
     * @param bool $shouldPass
     */
    #[DataProvider('provideBlockSet')]
    public function testBlockSetValue(string $blockSet, bool $shouldPass): void
    {
        try {
            BlockSetValue::fromString($blockSet);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideBlockSet(): array
    {
        return [
            '#all' => ['#all', true],
            '#all combined' => ['#all extension restriction substitution', false],
            'extension' => ['extension', true],
            'list' => ['list', false],
            'union' => ['union', false],
            'restriction' => ['restriction', true],
            'substitution' => ['substitution', true],
            'combined' => ['extension restriction substitution', true],
            'multiple spaces and newlines' => [
                "extension  restriction \n substitution",
                true,
            ],
            'undefined' => ['undefined', false],
            'empty' => ['', true],
        ];
    }
}
