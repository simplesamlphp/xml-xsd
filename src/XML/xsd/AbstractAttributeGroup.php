<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};

use function strval;

/**
 * Abstract class representing the attributeGroup-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractAttributeGroup extends AbstractAnnotated
{
    use AttrDeclsTrait;
    use DefRefTrait;

    /**
     * Annotated constructor
     *
     * @param array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\AttributeGroup> $attributes
     * @param \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     * @param \SimpleSAML\XML\Type\NCNameValue|null $name
     * @param \SimpleSAML\XML\Type\QNameValue|null $reference
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        array $attributes = [],
        ?AnyAttribute $anyAttribute = null,
        ?NCNameValue $name = null,
        ?QNameValue $reference = null,
        protected ?Annotation $annotation = null,
        protected ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);

        $this->setAttributes($attributes);
        $this->setAnyAttribute($anyAttribute);
        $this->setName($name);
        $this->setReference($reference);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getName()) &&
            empty($this->getReference()) &&
            empty($this->getAttributes()) &&
            empty($this->getAnyAttribute());
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

        if ($this->getName() !== null) {
            $e->setAttribute('name', strval($this->getName()));
        }

        if ($this->getReference() !== null) {
            $e->setAttribute('ref', strval($this->getReference()));
        }

        foreach ($this->getAttributes() as $attr) {
            $attr->toXML($e);
        }

        $this->getAnyAttribute()?->toXML($e);

        return $e;
    }
}
