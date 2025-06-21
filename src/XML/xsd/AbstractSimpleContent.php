<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\IDValue;

/**
 * Abstract class representing the simpleContent-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractSimpleContent extends AbstractAnnotated
{
    /**
     * SimpleContent constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\Extension|\SimpleSAML\XSD\XML\xsd\Restriction $content
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected Extension|Restriction $content,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the content-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\Extension|\SimpleSAML\XSD\XML\xsd\Restriction
     */
    public function getContent(): Extension|Restriction
    {
        return $this->content;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return false;
    }


    /**
     * Add this SimpleContent to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this SimpleContent to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $this->getContent()->toXML($e);

        return $e;
    }
}
