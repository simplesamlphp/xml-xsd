<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\IDValue;

use function strval;

/**
 * Abstract class representing the annotated-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractAnnotated extends AbstractOpenAttrs
{
    /**
     * Annotated constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected ?Annotation $annotation = null,
        protected ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($namespacedAttributes);
    }


    /**
     * Collect the value of the annotation-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\Annotation|null
     */
    public function getAnnotation(): ?Annotation
    {
        return $this->annotation;
    }


    /**
     * Collect the value of the id-property
     *
     * @return \SimpleSAML\XML\Type\IDValue|null
     */
    public function getId(): ?IDValue
    {
        return $this->id;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getAnnotation()) &&
            empty($this->getId());
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

        if ($this->getId() !== null) {
            $e->setAttribute('id', strval($this->getId()));
        }

        $this->getAnnotation()?->toXML($e);
        return $e;
    }
}
