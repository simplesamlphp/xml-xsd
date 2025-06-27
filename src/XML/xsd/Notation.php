<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, TooManyElementsException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{AnyURIValue, IDValue, NCNameValue};
use SimpleSAML\XSD\Type\PublicValue;

use function strval;

/**
 * Class representing the notation-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class Notation extends AbstractAnnotated implements
    SchemaTopInterface,
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'notation';


    /**
     * Notation constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XSD\Type\PublicValue $public
     * @param \SimpleSAML\XML\Type\AnyURIValue $system
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected NCNameValue $name,
        protected ?PublicValue $public = null,
        protected ?AnyURIValue $system = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
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
     * Collect the value of the public-property
     *
     * @return \SimpleSAML\XSD\Type\PublicValue
     */
    public function getPublic(): PublicValue
    {
        return $this->public;
    }


    /**
     * Collect the value of the system-property
     *
     * @return \SimpleSAML\XML\Type\AnyURIValue|null
     */
    public function getSystem(): ?AnyURIValue
    {
        return $this->system;
    }


    /**
     * Add this Notation to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this notation to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', strval($this->getName()));

        if ($this->getPublic() !== null) {
            $e->setAttribute('public', strval($this->getPublic()));
        }

        if ($this->getSystem() !== null) {
            $e->setAttribute('system', strval($this->getSystem()));
        }

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
        Assert::maxCount($annotation, 1, TooManyElementsException::class);

        return new static(
            self::getOptionalAttribute($xml, 'name', NCNameValue::class),
            self::getOptionalAttribute($xml, 'public', PublicValue::class, null),
            self::getOptionalAttribute($xml, 'system', AnyURIValue::class, null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
