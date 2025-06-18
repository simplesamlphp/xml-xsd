<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};

use function strval;

/**
 * Class representing the keyref-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class Keyref extends AbstractKeybase implements IdentityConstraintInterface, SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'keyref';


    /**
     * Keyref constructor
     *
     * @param \SimpleSAML\XML\Type\QNameValue $refer
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XSD\XML\xsd\Selector $selector
     * @param array<\SimpleSAML\XSD\XML\xsd\Field> $field
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected QNameValue $refer,
        NCNameValue $name,
        Selector $selector,
        array $field = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($name, $selector, $field, $annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the refer-property
     *
     * @return \SimpleSAML\XML\Type\QNameValue
     */
    public function getRefer(): QNameValue
    {
        return $this->refer;
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
        $e->setAttribute('refer', strval($this->getRefer()));

        return $e;
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $annotation = Annotation::getChildrenOfClass($xml);
        $selector = Selector::getChildrenOfClass($xml);
        $field = Field::getChildrenOfClass($xml);

        return new static(
            self::getAttribute($xml, 'refer', QNameValue::class),
            self::getAttribute($xml, 'name', NCNameValue::class),
            array_pop($selector),
            $field,
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
