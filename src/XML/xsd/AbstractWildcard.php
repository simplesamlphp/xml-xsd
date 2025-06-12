<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\{AnyURIValue, IDValue};
use SimpleSAML\XSD\Type\{NamespaceListValue, ProcessContentsValue};

use function strval;

/**
 * Abstract class representing the wildcard-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractWildcard extends AbstractAnnotated
{
    /**
     * Wildcard constructor
     *
     * @param \SimpleSAML\XSD\Type\NamespaceListValue|null $namespace
     * @param \SimpleSAML\XSD\Type\ProcessContentsValue|null $processContents
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected ?NamespaceListValue $namespace = null,
        protected ?ProcessContentsValue $processContents = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the namespace-property
     *
     * @return \SimpleSAML\XSD\Type\NamespaceListValue|null
     */
    public function getNamespace(): ?NamespaceListValue
    {
        return $this->namespace;
    }


    /**
     * Collect the value of the processContents-property
     *
     * @return \SimpleSAML\XSD\Type\ProcessContentsValue|null
     */
    public function getProcessContents(): ?ProcessContentsValue
    {
        return $this->processContents;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getNamespace()) &&
            empty($this->getProcessContents());
    }


    /**
     * Add this Wildcard to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this Wildcard to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getNamespace() !== null) {
            $e->setAttribute('namespace', strval($this->getNamespace()));
        }

        if ($this->getProcessContents() !== null) {
            $e->setAttribute('processContents', strval($this->getProcessContents()));
        }

        return $e;
    }
}
