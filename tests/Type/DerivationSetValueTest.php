<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\DerivationSetValue;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;

/**
 * Class \SimpleSAML\Test\XSD\Type\DerivationSetValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(DerivationSetValue::class)]
final class DerivationSetValueTest extends TestCase
{
    /**
     * @param string $derivationSet
     * @param bool $expected
     */
    #[DataProvider('provideDerivationSet')]
    public function testDerivationSetValue(string $derivationSet, bool $shouldPass): void
    {
        try {
            DerivationSetValue::fromString($derivationSet);
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
        $x = DerivationSetValue::fromEnum(DerivationControlEnum::Extension);
        $this->assertEquals(DerivationControlEnum::Extension, $x->toEnum());

        $y = DerivationSetValue::fromString('extension');
        $this->assertEquals(DerivationControlEnum::Extension, $y->toEnum());
    }


    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function provideDerivationSet(): array
    {
        return [
            '#all' => ['#all', true],
            'extension' => ['extension', true],
            'list' => ['list', false],
            'restriction' => ['restriction', true],
            'substitution' => ['substitution', false],
            'union' => ['union', false],
            'undefined' => ['undefined', false],
            'empty' => ['', true],
        ];
    }
}
