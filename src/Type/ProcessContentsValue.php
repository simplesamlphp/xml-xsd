<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\NMTokenValue;
use SimpleSAML\XSD\XML\xsd\ProcessContentsEnum;

use function array_column;

/**
 * @package simplesaml/xml-xsd
 */
class ProcessContentsValue extends NMTokenValue
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
            array_column(ProcessContentsEnum::cases(), 'value'),
            SchemaViolationException::class,
        );
    }


    /**
     * @param \SimpleSAML\XSD\XML\xsd\ProcessContentsEnum $value
     * @return static
     */
    public static function fromEnum(ProcessContentsEnum $value): static
    {
        return new static($value->value);
    }


    /**
     * @return \SimpleSAML\XSD\XML\xsd\ProcessContentsEnum $value
     */
    public function toEnum(): ProcessContentsEnum
    {
        return ProcessContentsEnum::from($this->getValue());
    }
}
