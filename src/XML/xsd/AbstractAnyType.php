<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\{ExtendableAttributesTrait, ExtendableElementTrait};
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

/**
 * Abstract class to be implemented by all the classes that use the xs:anyType complex type
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractAnyType extends AbstractXsdElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = XsNamespace::ANY;
//    public const XS_ANY_ELT_NAMESPACE = NamespaceEnum::Any;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::ANY;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Any;


    /**
     * AbstractAnyType constructor
     *
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $elements
     * @param array<\SimpleSAML\XML\Attribute> $attributes
     */
    public function __construct(
        array $elements = [],
        array $attributes = [],
    ) {
        $this->setElements($elements);
        $this->setAttributesNS($attributes);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getAttributesNS())
            && empty($this->getElements());
    }


    /**
     * Add this AnyType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this anyType to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        return $e;
    }
}
