<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\NMTokenValue;
use SimpleSAML\XSD\XML\xsd\FormChoiceEnum;

use function array_column;

/**
 * @package simplesaml/xml-xsd
 */
class FormChoiceValue extends NMTokenValue
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
            array_column(FormChoiceEnum::cases(), 'value'),
            SchemaViolationException::class,
        );
    }


    /**
     * @param \SimpleSAML\XSD\XML\xsd\FormChoiceEnum $value
     * @return static
     */
    public static function fromEnum(FormChoiceEnum $value): static
    {
        return new static($value->value);
    }


    /**
     * @return \SimpleSAML\XSD\XML\xsd\FormChoiceEnum $value
     */
    public function toEnum(): FormChoiceEnum
    {
        return FormChoiceEnum::from($this->getValue());
    }
}
