<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, SchemaViolationException};
use SimpleSAML\XML\Type\{BooleanValue, IDValue, IntegerValue};
use SimpleSAML\XML\Type\ValueTypeInterface;

use function strval;

/**
 * Abstract class representing the facet-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractNumFacet extends AbstractFacet
{
    /**
     * NumFacet constructor
     *
     * @param \SimpleSAML\XML\Type\ValueTypeInterface $value
     * @param \SimpleSAML\XML\Type\BooleanValue|null $fixed
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ValueTypeInterface $value,
        ?BooleanValue $fixed = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($value, $fixed, $annotation, $id, $namespacedAttributes);
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

        return new static(
            self::getAttribute($xml, 'value', IntegerValue::class),
            self::getOptionalAttribute($xml, 'fixed', BooleanValue::class, null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
