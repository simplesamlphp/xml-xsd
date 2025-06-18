<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;

use function array_column;
use function explode;

/**
 * @package simplesaml/xml-xsd
 */
class DerivationSetValue extends DerivationControlValue
{
    /** @var string */
    public const SCHEMA_TYPE = 'derivationSet';


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

        if ($sanitized !== '#all' && $sanitized !== '') {
            Assert::allOneOf(
                explode(' ', $sanitized),
                array_column(
                    [
                        DerivationControlEnum::Extension,
                        DerivationControlEnum::Restriction,
                    ],
                    'value',
                ),
                SchemaViolationException::class,
            );
        }
    }
}
