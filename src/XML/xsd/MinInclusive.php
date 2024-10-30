<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

use function array_pop;

/**
 * Class representing the minInclusive element
 *
 * @package simplesamlphp/xml-xsd
 */
final class MinInclusive extends AbstractFacet
{
    /** @var string */
    public const LOCALNAME = 'minInclusive';


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
            self::getAttribute($xml, 'value'),
            self::getOptionalBooleanAttribute($xml, 'fixed', null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', null),
            self::getAttributesNSFromXML($xml),
        );
    }
}