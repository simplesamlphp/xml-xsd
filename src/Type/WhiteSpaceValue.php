<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\NMTokenValue;
use SimpleSAML\XSD\XML\xsd\WhiteSpaceEnum;

use function array_column;

/**
 * @package simplesaml/xml-xsd
 */
class WhiteSpaceValue extends NMTokenValue
{
    /** @var string */
    public const SCHEMA_TYPE = 'whiteSpace';


    /**
     * Validate the value.
     *
     * @param string $value  The value
     * @throws \Exception on failure
     * @return void
     */
    protected function validateValue(string $value): void
    {
        Assert::oneOf(
            $this->sanitizeValue($value),
            array_column(WhiteSpaceEnum::cases(), 'value'),
            SchemaViolationException::class,
        );
    }


    /**
     * @param \SimpleSAML\XSD\XML\xsd\WhiteSpaceEnum $value
     * @return static
     */
    public static function fromEnum(WhiteSpaceEnum $value): static
    {
        return new static($value->value);
    }


    /**
     * @return \SimpleSAML\XSD\XML\xsd\WhiteSpaceEnum $value
     */
    public function toEnum(): WhiteSpaceEnum
    {
        return WhiteSpaceEnum::from($this->getValue());
    }
}
