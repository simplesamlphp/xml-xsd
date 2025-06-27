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
     * The attributes + groups.
     *
     * @var array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     */
    protected array $attributes = [];

    /**
     * The AnyAttribute
     *
     * @var \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     */
    protected ?AnyAttribute $anyAttribute = null;


    /**
     * Collect the value of the attributes-property
     *
     * @return array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }


    /**
     * Collect the value of the anyAttribute-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\AnyAttribute|null
     */
    public function getAnyAttribute(): ?AnyAttribute
    {
        return $this->anyAttribute;
    }


    /**
     * Set the value of the attributes-property
     *
     * @param array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     */
    protected function setAttributes(array $attributes): void
    {
        Assert::allIsInstanceOfAny(
            $attributes,
            [Attribute::class, ReferencedAttributeGroup::class],
            SchemaViolationException::class,
        );

        $this->attributes = $attributes;
    }


    /**
     * Set the value of the anyAttribute-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     */
    protected function setAnyAttribute(?AnyAttribute $anyAttribute): void
    {
        $this->anyAttribute = $anyAttribute;
    }
}
