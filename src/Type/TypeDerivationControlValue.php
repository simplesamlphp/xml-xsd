<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;

use function array_column;

/**
 * @package simplesaml/xml-xsd
 */
class TypeDerivationControlValue extends DerivationControlValue
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
            array_column(
                [
                    DerivationControlEnum::Extension,
                    DerivationControlEnum::List,
                    DerivationControlEnum::Restriction,
                    DerivationControlEnum::Union,
                ],
                'value',
            ),
            SchemaViolationException::class,
        );
    }
}
