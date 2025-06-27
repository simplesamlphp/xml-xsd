<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\TypeDerivationControlValue;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;

/**
 * Class \SimpleSAML\Test\XSD\Type\TypeDerivationControlValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(TypeDerivationControlValue::class)]
final class TypeDerivationControlValueTest extends TestCase
{
    /**
     * @param string $typeDerivationControl
     * @param bool $shouldPass
     */
    #[DataProvider('provideTypeDerivationControl')]
    public function testTypeDerivationControlValue(string $typeDerivationControl, bool $shouldPass): void
    {
        try {
            TypeDerivationControlValue::fromString($typeDerivationControl);
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
        $x = TypeDerivationControlValue::fromEnum(DerivationControlEnum::Extension);
        $this->assertEquals(DerivationControlEnum::Extension, $x->toEnum());

        $y = TypeDerivationControlValue::fromString('extension');
        $this->assertEquals(DerivationControlEnum::Extension, $y->toEnum());
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideTypeDerivationControl(): array
    {
        return [
            'extension' => ['extension', true],
            'list' => ['list', true],
            'restriction' => ['restriction', true],
            'substitution' => ['substitution', false],
            'union' => ['union', true],
            'undefined' => ['undefined', false],
            'empty' => ['', false],
        ];
    }
}
