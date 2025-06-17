<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Type\{IDValue, NCNameValue};

use function strval;

/**
 * Abstract class representing the keybase-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractKeybase extends AbstractAnnotated
{
    /**
     * Keybase constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XSD\XML\xsd\Selector $selector
     * @param array<\SimpleSAML\XSD\XML\xsd\Field> $field
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected NCNameValue $name,
        protected Selector $selector,
        protected array $field = [],
        protected ?Annotation $annotation = null,
        protected ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::allIsInstanceOf($field, Field::class, MissingElementException::class);

        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the name-property
     *
     * @return \SimpleSAML\XML\Type\NCNameValue
     */
    public function getName(): NCNameValue
    {
        return $this->name;
    }


    /**
     * Collect the value of the selector-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\Selector
     */
    public function getSelector(): Selector
    {
        return $this->selector;
    }


    /**
     * Collect the value of the field-property
     *
     * @return array<\SimpleSAML\XSD\XML\xsd\Field>
     */
    public function getField(): array
    {
        return $this->field;
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
     * Add this Annotated to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this Annotated to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);
        $e->setAttribute('name', strval($this->getName()));

        $this->getSelector()->toXML($e);

        foreach ($this->getField() as $field) {
            $field->toXML($e);
        }

        return $e;
    }
}
