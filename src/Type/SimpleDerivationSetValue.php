<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\NMTokenValue;
// use SimpleSAML\XSD\XML\xsd\NameSpaceEnum;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;

use function explode;

/**
 * @package simplesaml/xml-xsd
 */
class SimpleDerivationSetValue extends NMTokenValue
{
    /** @var string */
    public const SCHEMA_TYPE = 'simpleDerivationSet';


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
//        if ($sanitized !== NamespaceEnum::Any) {
            $list = explode(' ', $sanitized, C::UNBOUNDED_LIMIT);

            // After filtering the allowed values, there should be nothing left
            $filtered = array_diff(
                $list,
                [
                    DerivationControlEnum::List->value,
                    DerivationControlEnum::Restriction->value,
                    DerivationControlEnum::Union->value,
                ],
            );
            Assert::isEmpty($filtered, SchemaViolationException::class);
        }
    }
}
