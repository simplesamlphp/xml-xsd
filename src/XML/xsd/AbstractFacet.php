<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;

/**
 * Abstract class representing the facet-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractFacet extends AbstractAnnotated
{
    /**
     * Facet constructor
     *
     * @param string $value
     * @param bool $fixed
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param string|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected string $value,
        protected ?bool $fixed = false,
        ?Annotation $annotation = null,
        ?string $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the value-property
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }


    /**
     * Collect the value of the fixed-property
     *
     * @return bool|null
     */
    public function getFixed(): ?bool
    {
        return $this->fixed;
    }


    /**
     * Add this Facet to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this facet to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('value', $this->getValue());

        if ($this->getFixed() !== null) {
            $e->setAttribute('fixed', $this->getFixed() ? 'true' : 'false');
        }

        return $e;
    }
}
