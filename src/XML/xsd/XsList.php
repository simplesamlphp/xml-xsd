<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, TooManyElementsException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{IDValue, QNameValue};

use function strval;

/**
 * Class representing the list-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class XsList extends AbstractAnnotated implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'list';


    /**
     * Notation constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null $simpleType
     * @param \SimpleSAML\XML\Type\QNameValue|null $itemType
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected ?LocalSimpleType $simpleType = null,
        protected ?QNameValue $itemType = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the simpleType-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null
     */
    public function getSimpleType(): ?LocalSimpleType
    {
        return $this->simpleType;
    }


    /**
     * Collect the value of the itemType-property
     *
     * @return \SimpleSAML\XML\Type\QNameValue|null
     */
    public function getItemType(): ?QNameValue
    {
        return $this->itemType;
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

        if ($this->getItemType() !== null) {
            $e->setAttribute('itemType', strval($this->getItemType()));
        }

        $this->getSimpleType()?->toXML($e);

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

        $simpleType = LocalSimpleType::getChildrenOfClass($xml);
        Assert::maxCount($simpleType, 1, TooManyElementsException::class);

        return new static(
            array_pop($simpleType),
            self::getOptionalAttribute($xml, 'itemType', QNameValue::class),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
