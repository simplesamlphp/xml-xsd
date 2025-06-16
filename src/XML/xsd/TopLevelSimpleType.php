<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{
    InvalidDOMElementException,
    MissingElementException,
    SchemaViolationException,
    TooManyElementsException,
};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{IDValue, NCNameValue};
use SimpleSAML\XSD\Type\SimpleDerivationSetValue;

use function array_merge;
use function array_pop;

/**
 * Class representing the abstract simpleType.
 *
 * @package simplesamlphp/xml-xsd
 */
final class TopLevelSimpleType extends AbstractTopLevelSimpleType
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'simpleType';


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

        $union = Union::getChildrenOfClass($xml);
        $xsList = XsList::getChildrenOfClass($xml);
        $restriction = Restriction::getChildrenOfClass($xml);

        $derivation = array_merge($union, $xsList, $restriction);
        Assert::minCount($derivation, 1, MissingElementException::class);
        Assert::maxCount($derivation, 1, TooManyElementsException::class);

        return new static(
            array_pop($derivation),
            self::getAttribute($xml, 'name', NCNameValue::class),
            self::getOptionalAttribute($xml, 'final', SimpleDerivationSetValue::class, null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
