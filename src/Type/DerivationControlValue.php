<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\NMTokenValue;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;

use function array_column;

/**
 * @package simplesaml/xml-xsd
 */
class DerivationControlValue extends NMTokenValue
{
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
            array_column(DerivationControlEnum::cases(), 'value'),
            SchemaViolationException::class,
        );
    }


    /**
     * @param \SimpleSAML\XSD\XML\xsd\DerivationControlEnum $value
     * @return static
     */
    public static function fromEnum(DerivationControlEnum $value): static
    {
        return new static($value->value);
    }


    /**
     * @return \SimpleSAML\XSD\XML\xsd\DerivationControlEnum $value
     */
    public function toEnum(): DerivationControlEnum
    {
        return DerivationControlEnum::from($this->getValue());
    }
}
