<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\NonNegativeIntegerValue;

/**
 * @package simplesaml/xml-xsd
 */
class MaxOccursValue extends NonNegativeIntegerValue
{
    /** @var string */
    public const SCHEMA_TYPE = 'maxOccurs';


    /**
     * Validate the value.
     *
     * @param string $value  The value
     * @throws \Exception on failure
     * @return void
     */
    protected function validateValue(string $value): void
    {
        $sanitized = $this->sanitizeValue($value);
        if ($sanitized !== 'unbounded') {
            Assert::validNonNegativeInteger($sanitized, SchemaViolationException::class);
        }
    }
}
