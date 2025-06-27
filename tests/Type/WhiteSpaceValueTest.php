<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\Type\WhiteSpaceValue;
use SimpleSAML\XSD\XML\xsd\WhiteSpaceEnum;

/**
 * Class \SimpleSAML\Test\XSD\Type\WhiteSpaceValueTest
 *
 * @package simplesamlphp/xml-xsd
 */
#[CoversClass(WhiteSpaceValue::class)]
final class WhiteSpaceValueTest extends TestCase
{
    /**
     * @param string $whiteSpace
     * @param bool $shouldPass
     */
    #[DataProvider('provideWhiteSpace')]
    public function testWhiteSpaceValue(string $whiteSpace, bool $shouldPass): void
    {
        try {
            WhiteSpaceValue::fromString($whiteSpace);
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
        $x = WhiteSpaceValue::fromEnum(WhiteSpaceEnum::Collapse);
        $this->assertEquals(WhiteSpaceEnum::Collapse, $x->toEnum());

        $y = WhiteSpaceValue::fromString('collapse');
        $this->assertEquals(WhiteSpaceEnum::Collapse, $y->toEnum());
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideWhiteSpace(): array
    {
        return [
            'collapse' => ['collapse', true],
            'preserve' => ['preserve', true],
            'replace' => ['replace', true],
            'undefined' => ['undefined', false],
            'empty' => ['', false],
        ];
    }
}
