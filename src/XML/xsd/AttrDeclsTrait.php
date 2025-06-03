<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Trait grouping common functionality for elements that use the attrDecls-group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait AttrDeclsTrait
{
    /**
     * The attributes.
     *
     * @var \SimpleSAML\XML\xsd\Attribute|\SimpleSAML\XML\xsd\AttributeGroup|\SimpleSAML\XML\xsd\AnyAttribute
     */
    protected string $attributes;


    /**
     * Collect the value of the attributes-property
     *
     * @return array<\SimpleSAML\XML\xsd\Attribute|\SimpleSAML\XML\xsd\AttributeGroup|\SimpleSAML\XML\xsd\AnyAttribute>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }


    /**
     * Set the value of the attributes-property
     *
     * @param array<\SimpleSAML\XML\xsd\Attribute|\SimpleSAML\XML\xsd\AttributeGroup|\SimpleSAML\XML\xsd\AnyAttribute>
     */
    protected function setAttributes(array $attributes): void
    {
        Assert::allIsInstanceOfAny(
            $attributes,
            [Attribute::class, AttributeGroup::class, AnyAttribute::class],
            SchemaViolationException::class,
        );

        $this->attributes = $attributes;
    }
}
