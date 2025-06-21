<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\{IDValue, QNameValue};

use function strval;

/**
 * Abstract class representing the restrictionType-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractRestrictionType extends AbstractAnnotated
{
    use AttrDeclsTrait;

    /**
     * AbstractRestrictionType constructor
     *
     * @param \SimpleSAML\XML\Type\QNameValue $base
     * @param \SimpleSAML\XML\XML\AnyAttribute|null $anyAttribute
     * array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected QNameValue $base,
        protected ?TypeDefParticleInterface $particle = null,
        array $attributes = [],
        ?AnyAttribute $anyAttribute = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the base-property
     *
     * @return \SimpleSAML\XML\Type\QNameValue
     */
    public function getBase(): ?QNameValue
    {
        return $this->base;
    }


    /**
     * Add this Annotated to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this Annotated to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getBase() !== null) {
            $e->setAttribute('base', strval($this->getBase()));
        }

        return $e;
    }
}
