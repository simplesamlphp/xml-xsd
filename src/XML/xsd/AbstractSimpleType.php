<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\{IDValue, NCNameValue};
use SimpleSAML\XSD\Type\SimpleDerivationSetValue;
use SimpleSAML\XSD\XML\xsd\SimpleDerivationTrait;

use function strval;

/**
 * Abstract class representing the abstract simpleType.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractSimpleType extends AbstractAnnotated
{
    use SimpleDerivationTrait;


    /**
     * Annotated constructor
     *
     * @param (
     *   \SimpleSAML\XSD\XML\xsd\Union|
     *   \SimpleSAML\XSD\XML\xsd\XsList|
     *   \SimpleSAML\XSD\XML\xsd\Restriction
     * ) $derivation
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XSD\Type\SimpleDerivationSetValue $final
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        Union|XsList|Restriction $derivation,
        protected ?NCNameValue $name = null,
        protected ?SimpleDerivationSetValue $final = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);

        $this->setDerivation($derivation);
    }


    /**
     * Collect the value of the final-property
     *
     * @return \SimpleSAML\XSD\Type\SimpleDerivationSetValue|null
     */
    public function getFinal(): ?SimpleDerivationSetValue
    {
        return $this->final;
    }


    /**
     * Collect the value of the name-property
     *
     * @return \SimpleSAML\XML\Type\NCNameValue|null
     */
    public function getName(): ?NCNameValue
    {
        return $this->name;
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
     * Add this SimpleType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this SimpleType to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getFinal() !== null) {
            $e->setAttribute('final', strval($this->getFinal()));
        }

        if ($this->getName() !== null) {
            $e->setAttribute('name', strval($this->getName()));
        }

        $this->getDerivation()?->toXML($e);

        return $e;
    }
}
