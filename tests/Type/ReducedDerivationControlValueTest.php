<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\ReducedDerivationControlValue;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;

/**
 * Class \SimpleSAML\Test\XSD\Type\ReducedDerivationControlValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(ReducedDerivationControlValue::class)]
final class ReducedDerivationControlValueTest extends TestCase
{
    /**
     * @param string $reducedDerivationControl
     * @param bool $shouldPass
     */
    #[DataProvider('provideReducedDerivationControl')]
    public function testReducedDerivationControlValue(string $reducedDerivationControl, bool $shouldPass): void
    {
        try {
            ReducedDerivationControlValue::fromString($reducedDerivationControl);
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
        $x = ReducedDerivationControlValue::fromEnum(DerivationControlEnum::Extension);
        $this->assertEquals(DerivationControlEnum::Extension, $x->toEnum());

        $y = ReducedDerivationControlValue::fromString('extension');
        $this->assertEquals(DerivationControlEnum::Extension, $y->toEnum());
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideReducedDerivationControl(): array
    {
        return [
            'extension' => ['extension', true],
            'list' => ['list', false],
            'restriction' => ['restriction', true],
            'substitution' => ['substitution', false],
            'union' => ['union', false],
            'undefined' => ['undefined', false],
            'empty' => ['', false],
        ];
    }
}
