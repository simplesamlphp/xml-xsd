<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\AbstractValueType;
use SimpleSAML\XML\XsNamespace;
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;

use function explode;

/**
 * @package simplesaml/xml-xsd
 */
class NamespaceListValue extends AbstractValueType
{
    /** @var string */
    public const SCHEMA_TYPE = 'namespaceList';


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

        if ($sanitized !== XsNamespace::ANY && $sanitized !== XsNamespace::OTHER) {
//        if ($sanitized !== NamespaceEnum::Any && $sanitized !== NamespaceEnum::Other) {
            $list = explode(' ', $sanitized, C::UNBOUNDED_LIMIT);

            // After filtering the two special namespaces, only AnyURI's should be left
            $filtered = array_diff($list, [XsNamespace::TARGET->value, XsNamespace::LOCAL->value]);
//            $filtered = array_diff($list, [NamespaceEnum::TargetNamespace, NamespaceEnum::Local]);
            Assert::allValidAnyURI($filtered, SchemaViolationException::class);
        }
    }


    /**
     * @param \SimpleSAML\XSD\XML\xsd\NamespaceEnum $value
     * @return static
    public static function fromEnum(NamespaceEnum $value): static
    {
        return new static($value->value);
    }
     */


    /**
     * @return \SimpleSAML\XSD\XML\xsd\NamespaceEnumEnum $value
    public function toEnum(): NamespaceEnum
    {
        return NamespaceEnum::from($this->getValue());
    }
     */

    /**
     * @param \SimpleSAML\XML\XsNamespace $value
     * @return static
     */
    public static function fromEnum(XsNamespace $value): static
    {
        return new static($value->value);
    }


    /**
     * @return \SimpleSAML\XML\XsNamespace $value
     */
    public function toEnum(): XsNamespace
    {
        return XsNamespace::from($this->getValue());
    }
}
